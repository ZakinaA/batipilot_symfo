<?php

namespace App\Entity;

use App\Repository\PosteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PosteRepository::class)]
class Poste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?int $ordre = null;

    #[ORM\Column(nullable: true)]
    private ?float $tva = null;

    #[ORM\Column]
    private ?int $archive = null;

    /**
     * @var Collection<int, Etape>
     */
    #[ORM\OneToMany(targetEntity: Etape::class, mappedBy: 'poste')]
    private Collection $etapes;

    /**
     * @var Collection<int, ChantierEtape>
     */
    #[ORM\OneToMany(targetEntity: ChantierEtape::class, mappedBy: 'poste')]
    private Collection $chantierEtapes;

    public function __construct()
    {
        $this->etapes = new ArrayCollection();
        $this->chantierEtapes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): static
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(?float $tva): static
    {
        $this->tva = $tva;

        return $this;
    }

    public function getArchive(): ?int
    {
        return $this->archive;
    }

    public function setArchive(int $archive): static
    {
        $this->archive = $archive;

        return $this;
    }

    /**
     * @return Collection<int, Etape>
     */
    public function getEtapes(): Collection
    {
        return $this->etapes;
    }

    public function addEtape(Etape $etape): static
    {
        if (!$this->etapes->contains($etape)) {
            $this->etapes->add($etape);
            $etape->setPoste($this);
        }

        return $this;
    }

    public function removeEtape(Etape $etape): static
    {
        if ($this->etapes->removeElement($etape)) {
            // set the owning side to null (unless already changed)
            if ($etape->getPoste() === $this) {
                $etape->setPoste(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ChantierEtape>
     */
    public function getChantierEtapes(): Collection
    {
        return $this->chantierEtapes;
    }

    public function addChantierEtape(ChantierEtape $chantierEtape): static
    {
        if (!$this->chantierEtapes->contains($chantierEtape)) {
            $this->chantierEtapes->add($chantierEtape);
            $chantierEtape->setPoste($this);
        }

        return $this;
    }

    public function removeChantierEtape(ChantierEtape $chantierEtape): static
    {
        if ($this->chantierEtapes->removeElement($chantierEtape)) {
            // set the owning side to null (unless already changed)
            if ($chantierEtape->getPoste() === $this) {
                $chantierEtape->setPoste(null);
            }
        }

        return $this;
    }
}
