<?php

namespace App\Entity;

use App\Repository\ChantierRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChantierRepository::class)]
class Chantier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $copos = null;

    #[ORM\Column(length: 80)]
    private ?string $ville = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $datePrevue = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateDemarrage = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateFin = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateReception = null;

    #[ORM\Column(nullable: true)]
    private ?int $distanceDepot = null;

    #[ORM\Column(nullable: true)]
    private ?int $tempsTrajet = null;

    #[ORM\Column(nullable: true)]
    private ?float $surfaceMaison = null;

    #[ORM\Column(nullable: true)]
    private ?float $surfaceCombles = null;

    #[ORM\Column]
    private ?int $archive = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCopos(): ?string
    {
        return $this->copos;
    }

    public function setCopos(?string $copos): static
    {
        $this->copos = $copos;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getDatePrevue(): ?\DateTime
    {
        return $this->datePrevue;
    }

    public function setDatePrevue(?\DateTime $datePrevue): static
    {
        $this->datePrevue = $datePrevue;

        return $this;
    }

    public function getDateDemarrage(): ?\DateTime
    {
        return $this->dateDemarrage;
    }

    public function setDateDemarrage(?\DateTime $dateDemarrage): static
    {
        $this->dateDemarrage = $dateDemarrage;

        return $this;
    }

    public function getDateFin(): ?\DateTime
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTime $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getDateReception(): ?\DateTime
    {
        return $this->dateReception;
    }

    public function setDateReception(?\DateTime $dateReception): static
    {
        $this->dateReception = $dateReception;

        return $this;
    }

    public function getDistanceDepot(): ?int
    {
        return $this->distanceDepot;
    }

    public function setDistanceDepot(?int $distanceDepot): static
    {
        $this->distanceDepot = $distanceDepot;

        return $this;
    }

    public function getTempsTrajet(): ?int
    {
        return $this->tempsTrajet;
    }

    public function setTempsTrajet(?int $tempsTrajet): static
    {
        $this->tempsTrajet = $tempsTrajet;

        return $this;
    }

    public function getSurfaceMaison(): ?float
    {
        return $this->surfaceMaison;
    }

    public function setSurfaceMaison(?float $surfaceMaison): static
    {
        $this->surfaceMaison = $surfaceMaison;

        return $this;
    }

    public function getSurfaceCombles(): ?float
    {
        return $this->surfaceCombles;
    }

    public function setSurfaceCombles(?float $surfaceCombles): static
    {
        $this->surfaceCombles = $surfaceCombles;

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
}
