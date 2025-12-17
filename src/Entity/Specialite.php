<?php

namespace App\Entity;

use App\Repository\SpecialiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecialiteRepository::class)]
class Specialite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $intitule = null;

    /**
     * @var Collection<int, Chirurgien>
     */
    #[ORM\OneToMany(targetEntity: Chirurgien::class, mappedBy: 'specialiser')]
    private Collection $chirurgiens;

    public function __construct()
    {
        $this->chirurgiens = new ArrayCollection();
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

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): static
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * @return Collection<int, Chirurgien>
     */
    public function getChirurgiens(): Collection
    {
        return $this->chirurgiens;
    }

    public function addChirurgien(Chirurgien $chirurgien): static
    {
        if (!$this->chirurgiens->contains($chirurgien)) {
            $this->chirurgiens->add($chirurgien);
            $chirurgien->setSpecialiser($this);
        }

        return $this;
    }

    public function removeChirurgien(Chirurgien $chirurgien): static
    {
        if ($this->chirurgiens->removeElement($chirurgien)) {
            // set the owning side to null (unless already changed)
            if ($chirurgien->getSpecialiser() === $this) {
                $chirurgien->setSpecialiser(null);
            }
        }

        return $this;
    }
}
