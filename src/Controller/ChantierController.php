<?php

namespace App\Controller;

use App\Entity\Chantier;
use App\Entity\Client;
use App\Entity\ChantierEtape;
use App\Form\ChantierType;
use App\Repository\ChantierRepository;
use App\Repository\EtapeRepository;
use App\Repository\PosteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/chantier')]
final class ChantierController extends AbstractController
{
    #[Route(name: 'app_chantier_index', methods: ['GET'])]
    public function index(ChantierRepository $chantierRepository): Response
    {
        return $this->render('chantier/index.html.twig', [
            'chantiers' => $chantierRepository->findBy(['archive' => 0]),
        ]);
    }

    #[Route('/new', name: 'app_chantier_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        EtapeRepository $etapeRepository,
        PosteRepository $posteRepository
    ): Response {
        $chantier = new Chantier();
        $chantier->setArchive(0);

        $form = $this->createForm(ChantierType::class, $chantier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gérer le client (existant ou nouveau)
            $client = $form->get('client')->getData();

            if (!$client) {
                // Créer un nouveau client
                $nom = $form->get('nouveauClientNom')->getData();
                $prenom = $form->get('nouveauClientPrenom')->getData();
                $telephone = $form->get('nouveauClientTelephone')->getData();
                $mail = $form->get('nouveauClientMail')->getData();

                if ($nom) {
                    $client = new Client();
                    $client->setNom($nom)
                           ->setPrenom($prenom)
                           ->setTelephone($telephone)
                           ->setMail($mail);

                    $entityManager->persist($client);
                }
            }

            if ($client) {
                $chantier->setClient($client);
            }

            // Persister le chantier
            $entityManager->persist($chantier);

            // Traiter les étapes
            $postes = $posteRepository->findBy(['archive' => 0], ['ordre' => 'ASC']);

            foreach ($postes as $poste) {
                $etapes = $etapeRepository->findBy([
                    'poste' => $poste,
                    'archive' => 0
                ]);

                foreach ($etapes as $etape) {
                    $fieldName = 'etape_' . $etape->getId();

                    if ($form->has($fieldName)) {
                        $value = $form->get($fieldName)->getData();

                        // Ne créer une ChantierEtape que si une valeur a été saisie
                        if ($value !== null && $value !== '') {
                            $chantierEtape = new ChantierEtape();
                            $chantierEtape->setChantier($chantier);
                            $chantierEtape->setEtape($etape);


                            // Définir la valeur selon le type d'EtapeFormat
                            $etapeFormat = $etape->getEtapeFormat();
                            if ($etapeFormat) {
                                $this->setChantierEtapeValue($chantierEtape, $etapeFormat->getId(), $value);
                            } else {
                                $chantierEtape->setValText((string)$value);
                            }

                            $entityManager->persist($chantierEtape);
                        }
                    }
                }
            }

            $entityManager->flush();

            $this->addFlash('success', 'Le chantier a été créé avec succès.');
            return $this->redirectToRoute('app_chantier_show', ['id' => $chantier->getId()]);
        }

        return $this->render('chantier/new.html.twig', [
            'chantier' => $chantier,
            'form' => $form,
            'postes' => $posteRepository->findBy(['archive' => 0], ['ordre' => 'ASC']),
        ]);
    }

    #[Route('/{id}', name: 'app_chantier_show', methods: ['GET'])]
    public function show(Chantier $chantier): Response
    {
        // Organiser les étapes par poste
        $etapesParPoste = [];
        foreach ($chantier->getChantierEtapes() as $chantierEtape) {
            $posteId = $chantierEtape->getPoste()->getId();
            if (!isset($etapesParPoste[$posteId])) {
                $etapesParPoste[$posteId] = [
                    'poste' => $chantierEtape->getPoste(),
                    'etapes' => []
                ];
            }
            $etapesParPoste[$posteId]['etapes'][] = $chantierEtape;
        }

        // Trier par ordre des postes
        uasort($etapesParPoste, function($a, $b) {
            return $a['poste']->getOrdre() <=> $b['poste']->getOrdre();
        });

        return $this->render('chantier/show.html.twig', [
            'chantier' => $chantier,
            'etapesParPoste' => $etapesParPoste,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_chantier_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Chantier $chantier,
        EntityManagerInterface $entityManager,
        EtapeRepository $etapeRepository,
        PosteRepository $posteRepository
    ): Response {
        $form = $this->createForm(ChantierType::class, $chantier);

        // Pré-remplir les valeurs des étapes existantes
        $etapesExistantes = [];
        foreach ($chantier->getChantierEtapes() as $chantierEtape) {
            $etapeId = $chantierEtape->getEtape()->getId();
            $etapesExistantes[$etapeId] = $chantierEtape;

            // Pré-remplir le formulaire avec les valeurs existantes
            $fieldName = 'etape_' . $etapeId;
            if ($form->has($fieldName)) {
                $etapeFormat = $chantierEtape->getEtape()->getEtapeFormat();
                $value = null;

                if ($etapeFormat) {
                    switch ($etapeFormat->getId()) {
                        case 1: // Oui, non, sans objet
                            if ($chantierEtape->isValBoolean() !== null) {
                                $value = $chantierEtape->isValBoolean() ? 'oui' : 'non';
                            } else {
                                $value = 'sans_objet';
                            }
                            break;
                        case 2: // Date
                            $value = $chantierEtape->getValDate();
                            break;
                        case 3: // Date et heure
                            $value = $chantierEtape->getValDateHeure();
                            break;
                        case 4: // Texte
                            $value = $chantierEtape->getValText();
                            break;
                    }
                }

                if ($value !== null) {
                    $form->get($fieldName)->setData($value);
                }
            }
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Supprimer les anciennes étapes
            foreach ($chantier->getChantierEtapes() as $chantierEtape) {
                $entityManager->remove($chantierEtape);
            }
            $entityManager->flush();

            // Traiter les étapes mises à jour
            $postes = $posteRepository->findBy(['archive' => 0], ['ordre' => 'ASC']);

            foreach ($postes as $poste) {
                $etapes = $etapeRepository->findBy([
                    'poste' => $poste,
                    'archive' => 0
                ]);

                foreach ($etapes as $etape) {
                    $fieldName = 'etape_' . $etape->getId();

                    if ($form->has($fieldName)) {
                        $value = $form->get($fieldName)->getData();

                        if ($value !== null && $value !== '') {
                            $chantierEtape = new ChantierEtape();
                            $chantierEtape->setChantier($chantier);
                            $chantierEtape->setEtape($etape);
                            $chantierEtape->setPoste($poste);

                            $etapeFormat = $etape->getEtapeFormat();
                            if ($etapeFormat) {
                                $this->setChantierEtapeValue($chantierEtape, $etapeFormat->getId(), $value);
                            } else {
                                $chantierEtape->setValText((string)$value);
                            }

                            $entityManager->persist($chantierEtape);
                        }
                    }
                }
            }

            $entityManager->flush();

            $this->addFlash('success', 'Le chantier a été modifié avec succès.');
            return $this->redirectToRoute('app_chantier_show', ['id' => $chantier->getId()]);
        }

        return $this->render('chantier/edit.html.twig', [
            'chantier' => $chantier,
            'form' => $form,
            'postes' => $posteRepository->findBy(['archive' => 0], ['ordre' => 'ASC']),
            'etapesExistantes' => $etapesExistantes,
        ]);
    }

    #[Route('/{id}', name: 'app_chantier_delete', methods: ['POST'])]
    public function delete(Request $request, Chantier $chantier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chantier->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($chantier);
            $entityManager->flush();

            $this->addFlash('success', 'Le chantier a été supprimé avec succès.');
        }

        return $this->redirectToRoute('app_chantier_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * Définir la valeur dans ChantierEtape selon le type d'EtapeFormat
     */
    private function setChantierEtapeValue(ChantierEtape $chantierEtape, int $etapeFormatId, mixed $value): void
    {
        match ($etapeFormatId) {
            1 => $chantierEtape->setValBoolean($value === 'oui'),  // Oui, non, sans objet
            2 => $chantierEtape->setValDate($value),               // Date
            3 => $chantierEtape->setValDateHeure($value),          // Date et heure
            4 => $chantierEtape->setValText((string)$value),       // Texte
            default => $chantierEtape->setValText((string)$value),
        };
    }
}
