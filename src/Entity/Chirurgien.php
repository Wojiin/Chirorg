<?php

namespace App\Entity;

use App\Repository\ChirurgienRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChirurgienRepository::class)]
class Chirurgien
{
    # Identifiant unique du chirurgien
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    # Prénom du chirurgien
    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    # Nom du chirurgien
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    # Liste des chirurgies réalisées par ce chirurgien
    # Relation OneToMany (un chirurgien peut réaliser plusieurs chirurgies)
    /**
     * @var Collection<int, Chirurgie>
     */
    #[ORM\OneToMany(targetEntity: Chirurgie::class, mappedBy: 'operer')]
    private Collection $chirurgies;

    # Spécialité associée au chirurgien
    # Relation ManyToOne (plusieurs chirurgiens peuvent avoir la même spécialité)
    #[ORM\ManyToOne(inversedBy: 'chirurgiens')]
    #[ORM\JoinColumn(nullable: true, onDelete: "SET NULL")]
    private ?Specialite $specialiser = null;

    public function __construct()
    {
        # Initialise la collection des chirurgies
        $this->chirurgies = new ArrayCollection();
    }

    # Retourne l'identifiant du chirurgien
    public function getId(): ?int
    {
        return $this->id;
    }

    # Retourne le prénom du chirurgien
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    # Définit le prénom du chirurgien
    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

    # Retourne le nom du chirurgien
    public function getNom(): ?string
    {
        return $this->nom;
    }

    # Définit le nom du chirurgien
    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    # Retourne la collection des chirurgies du chirurgien
    /**
     * @return Collection<int, Chirurgie>
     */
    public function getChirurgies(): Collection
    {
        return $this->chirurgies;
    }

    # Ajoute une chirurgie à la collection du chirurgien
    # Synchronise également la relation côté Chirurgie
    public function addChirurgies(Chirurgie $chirurgies): static
    {
        if (!$this->chirurgies->contains($chirurgies)) {
            $this->chirurgies->add($chirurgies);
            $chirurgies->setOperer($this);
        }

        return $this;
    }

    # Retire une chirurgie de la collection du chirurgien
    # Met la relation côté Chirurgie à null si nécessaire
    public function removeChirurgies(Chirurgie $chirurgies): static
    {
        if ($this->chirurgies->removeElement($chirurgies)) {
            # Vérifie que la chirurgie est bien associée à ce chirurgien
            if ($chirurgies->getOperer() === $this) {
                $chirurgies->setOperer(null);
            }
        }

        return $this;
    }

    # Retourne la spécialité du chirurgien
    public function getSpecialiser(): ?Specialite
    {
        return $this->specialiser;
    }

    # Associe une spécialité au chirurgien
    public function setSpecialiser(?Specialite $specialiser): static
    {
        $this->specialiser = $specialiser;
        return $this;
    }
}
