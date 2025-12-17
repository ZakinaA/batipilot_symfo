<?php

namespace App\Entity;

use App\Repository\ChantierEtapeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChantierEtapeRepository::class)]
class ChantierEtape
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'chantierEtapes')]
    private ?Poste $poste = null;

    #[ORM\ManyToOne(inversedBy: 'chantierEtapes')]
    private ?Etape $etape = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $valText = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $valDate = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $valDateHeure = null;

    #[ORM\Column(nullable: true)]
    private ?bool $valBoolean = null;

    #[ORM\Column(nullable: true)]
    private ?float $dateDecimal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoste(): ?Poste
    {
        return $this->poste;
    }

    public function setPoste(?Poste $poste): static
    {
        $this->poste = $poste;

        return $this;
    }

    public function getEtape(): ?Etape
    {
        return $this->etape;
    }

    public function setEtape(?Etape $etape): static
    {
        $this->etape = $etape;

        return $this;
    }

    public function getValText(): ?string
    {
        return $this->valText;
    }

    public function setValText(?string $valText): static
    {
        $this->valText = $valText;

        return $this;
    }

    public function getValDate(): ?\DateTime
    {
        return $this->valDate;
    }

    public function setValDate(?\DateTime $valDate): static
    {
        $this->valDate = $valDate;

        return $this;
    }

    public function getValDateHeure(): ?\DateTime
    {
        return $this->valDateHeure;
    }

    public function setValDateHeure(?\DateTime $valDateHeure): static
    {
        $this->valDateHeure = $valDateHeure;

        return $this;
    }

    public function isValBoolean(): ?bool
    {
        return $this->valBoolean;
    }

    public function setValBoolean(?bool $valBoolean): static
    {
        $this->valBoolean = $valBoolean;

        return $this;
    }

    public function getDateDecimal(): ?float
    {
        return $this->dateDecimal;
    }

    public function setDateDecimal(?float $dateDecimal): static
    {
        $this->dateDecimal = $dateDecimal;

        return $this;
    }
}
