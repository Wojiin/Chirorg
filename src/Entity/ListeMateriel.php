<?php

namespace App\Entity;

use App\Repository\ListeMaterielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListeMaterielRepository::class)]
class ListeMateriel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'choisir')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chirurgien $chirurgien = null;

    #[ORM\ManyToOne(inversedBy: 'preparer')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chirurgie $chirurgie = null;

    /**
     * @var Collection<int, Materiel>
     */
    #[ORM\ManyToMany(targetEntity: Materiel::class, inversedBy: 'listeMateriels')]
    private Collection $lister;

    public function __construct()
    {
        $this->lister = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
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

    /**
     * @return Collection<int, Materiel>
     */
    public function getLister(): Collection
    {
        return $this->lister;
    }

    public function addLister(Materiel $lister): static
    {
        if (!$this->lister->contains($lister)) {
            $this->lister->add($lister);
        }

        return $this;
    }

    public function removeLister(Materiel $lister): static
    {
        $this->lister->removeElement($lister);

        return $this;
    }
}
