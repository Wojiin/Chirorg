<?php

namespace App\Entity;

use App\Repository\ChirurgienRepository;
use App\Entity\ListeMateriel;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChirurgienRepository::class)]
class Chirurgien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Chirurgie>
     */
    #[ORM\OneToMany(targetEntity: Chirurgie::class, mappedBy: 'operer')]
    private Collection $chirurgies;

    #[ORM\ManyToOne(inversedBy: 'chirurgiens')]
    private ?Specialite $specialiser = null;

    public function __construct()
    {
        $this->chirurgies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
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

    /**
     * @return Collection<int, Chirurgie>
     */
    public function getChirurgies(): Collection
    {
        return $this->chirurgies;
    }

    public function addChirurgies(Chirurgie $chirurgies): static
    {
        if (!$this->chirurgies->contains($chirurgies)) {
            $this->chirurgies->add($chirurgies);
            $chirurgies->setOperer($this);
        }

        return $this;
    }

    public function removeChirurgies(Chirurgie $chirurgies): static
    {
        if ($this->chirurgies->removeElement($chirurgies)) {
            // set the owning side to null (unless already changed)
            if ($chirurgies->getOperer() === $this) {
                $chirurgies->setOperer(null);
            }
        }

        return $this;
    }

    public function getSpecialiser(): ?Specialite
    {
        return $this->specialiser;
    }

    public function setSpecialiser(?Specialite $specialiser): static
    {
        $this->specialiser = $specialiser;

        return $this;
    }
}
