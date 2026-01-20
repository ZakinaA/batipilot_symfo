<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipeRepository::class)]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(nullable: true)]
    private ?float $montantMo = null;

    #[ORM\Column]
    private ?int $indice = null;

    /**
     * @var Collection<int, ChantierPresta>
     */
    #[ORM\OneToMany(targetEntity: ChantierPresta::class, mappedBy: 'equipe')]
    private Collection $chantiers;

    public function __construct()
    {
        $this->chantiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getMontantMo(): ?float
    {
        return $this->montantMo;
    }

    public function setMontantMo(?float $montantMo): static
    {
        $this->montantMo = $montantMo;

        return $this;
    }

    public function getIndice(): ?int
    {
        return $this->indice;
    }

    public function setIndice(int $indice): static
    {
        $this->indice = $indice;

        return $this;
    }

    /**
     * @return Collection<int, ChantierPresta>
     */
    public function getChantiers(): Collection
    {
        return $this->chantiers;
    }

    public function addChantier(ChantierPresta $chantier): static
    {
        if (!$this->chantiers->contains($chantier)) {
            $this->chantiers->add($chantier);
            $chantier->setEquipe($this);
        }

        return $this;
    }

    public function removeChantier(ChantierPresta $chantier): static
    {
        if ($this->chantiers->removeElement($chantier)) {
            // set the owning side to null (unless already changed)
            if ($chantier->getEquipe() === $this) {
                $chantier->setEquipe(null);
            }
        }

        return $this;
    }
}
