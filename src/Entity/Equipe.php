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

    #[ORM\Column(nullable: true)]
    private ?float $indice = null;

    /**
     * 🔹 Une équipe possède plusieurs chantiers
     */
    #[ORM\OneToMany(
        mappedBy: 'equipe',
        targetEntity: Chantier::class
    )]
    private Collection $chantiers;

    /**
     * 🔹 Relation avec ChantierPresta
     */
    #[ORM\OneToMany(
        mappedBy: 'equipe',
        targetEntity: ChantierPresta::class
    )]
    private Collection $chantiersPresta;

    public function __construct()
    {
        $this->chantiers = new ArrayCollection();
        $this->chantiersPresta = new ArrayCollection();
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

    public function getIndice(): ?float
    {
        return $this->indice;
    }

    public function setIndice(?float $indice): static
    {
        $this->indice = $indice;
        return $this;
    }

    /**
     * 🔹 Chantiers
     */
    public function getChantiers(): Collection
    {
        return $this->chantiers;
    }

    public function addChantier(Chantier $chantier): static
    {
        if (!$this->chantiers->contains($chantier)) {
            $this->chantiers->add($chantier);
            $chantier->setEquipe($this);
        }

        return $this;
    }

    public function removeChantier(Chantier $chantier): static
    {
        if ($this->chantiers->removeElement($chantier)) {
            if ($chantier->getEquipe() === $this) {
                $chantier->setEquipe(null);
            }
        }

        return $this;
    }

    /**
     * 🔹 ChantierPresta
     */
    public function getChantiersPresta(): Collection
    {
        return $this->chantiersPresta;
    }

    public function addChantierPresta(ChantierPresta $chantierPresta): static
    {
        if (!$this->chantiersPresta->contains($chantierPresta)) {
            $this->chantiersPresta->add($chantierPresta);
            $chantierPresta->setEquipe($this);
        }

        return $this;
    }

    public function removeChantierPresta(ChantierPresta $chantierPresta): static
    {
        if ($this->chantiersPresta->removeElement($chantierPresta)) {
            if ($chantierPresta->getEquipe() === $this) {
                $chantierPresta->setEquipe(null);
            }
        }

        return $this;
    }
}
