<?php

namespace App\Entity;

use App\Repository\ChirurgieRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChirurgieRepository::class)]
class Chirurgie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    private ?string $intitule = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $fiche_technique = null;

    #[ORM\Column]
    private ?\DateTime $date = null;

    #[ORM\Column(length: 50)]
    private ?string $salle = null;

    #[ORM\Column]
    private ?bool $valide = null;

    #[ORM\ManyToOne(inversedBy: 'organiser')]
    private ?Utilisateur $utilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'outiller')]
    private ?Chirurgien $operer = null;

    #[ORM\ManyToOne(inversedBy: 'chirurgies')]
    private ?ListeMateriel $outiller = null;

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): static
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getFicheTechnique(): ?string
    {
        return $this->fiche_technique;
    }

    public function setFicheTechnique(string $fiche_technique): static
    {
        $this->fiche_technique = $fiche_technique;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getSalle(): ?string
    {
        return $this->salle;
    }

    public function setSalle(string $salle): static
    {
        $this->salle = $salle;

        return $this;
    }

    public function isValide(): ?bool
    {
        return $this->valide;
    }

    public function setValide(bool $valide): static
    {
        $this->valide = $valide;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getOperer(): ?Chirurgien
    {
        return $this->operer;
    }

    public function setOperer(?Chirurgien $operer): static
    {
        $this->operer = $operer;

        return $this;
    }

    public function getOutiller(): ?ListeMateriel
    {
        return $this->outiller;
    }

    public function setOutiller(?ListeMateriel $outiller): static
    {
        $this->outiller = $outiller;

        return $this;
    }
}
