<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        if ($request->isMethod('POST')) {

           
            $plainPassword = $request->request->get('password');
            $firstName = strtolower(trim($request->request->get('first_name')));
            $lastName  = strtolower(trim($request->request->get('last_name')));

           
            if (!$plainPassword || !$firstName || !$lastName) {
                $this->addFlash('error', 'Tous les champs sont obligatoires.');
                return $this->redirectToRoute('app_register');
            }

            
            $baseUsername = $lastName . '.' . $firstName;
            $username = $baseUsername;
            $i = 1;

           
            while ($entityManager->getRepository(User::class)->findOneBy(['username' => $username])) {
                $username = $baseUsername . $i;
                $i++;
            }

          
            $user = new User();
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setUsername($username);
            $user->setRoles(['ROLE_USER']);

           
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plainPassword
            );
            $user->setPassword($hashedPassword);

           
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/register.html.twig');
    }
}
