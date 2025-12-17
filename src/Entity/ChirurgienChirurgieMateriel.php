<?php

namespace App\Entity;

use App\Repository\ChirurgienChirurgieMaterielRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChirurgienChirurgieMaterielRepository::class)]
class ChirurgienChirurgieMateriel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'chirurgienChirurgieMateriels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chirurgien $chirurgien = null;

    #[ORM\ManyToOne(inversedBy: 'chirurgienChirurgieMateriels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chirurgie $chirurgie = null;

    #[ORM\ManyToOne(inversedBy: 'chirurgienChirurgieMateriels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Materiel $materiel = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChirurgien(): ?Chirurgien
    {
        return $this->chirurgien;
    }

    public function setChirurgien(?Chirurgien $chirurgien): static
    {
        $this->chirurgien = $chirurgien;
        return $this;
    }

    public function getChirurgie(): ?Chirurgie
    {
        return $this->chirurgie;
    }

    public function setChirurgie(?Chirurgie $chirurgie): static
    {
        $this->chirurgie = $chirurgie;
        return $this;
    }

    public function getMateriel(): ?Materiel
    {
        return $this->materiel;
    }

    public function setMateriel(?Materiel $materiel): static
    {
        $this->materiel = $materiel;
        return $this;
    }
}
