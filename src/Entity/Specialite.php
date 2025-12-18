<?php

namespace App\Entity;

use App\Repository\SpecialiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecialiteRepository::class)]
class Specialite
{
    # Identifiant unique de la spécialité
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    # Intitulé de la spécialité (ex : Orthopédie, Cardiologie, etc.)
    #[ORM\Column(length: 255)]
    private ?string $intitule = null;

    # Liste des chirurgiens associés à cette spécialité
    # Relation OneToMany : une spécialité peut concerner plusieurs chirurgiens
    /**
     * @var Collection<int, Chirurgien>
     */
    #[ORM\OneToMany(targetEntity: Chirurgien::class, mappedBy: 'specialiser')]
    private Collection $chirurgiens;

    # Liste des matériels rattachés à cette spécialité
    # Relation OneToMany : une spécialité peut regrouper plusieurs matériels
    /**
     * @var Collection<int, Materiel>
     */
    #[ORM\OneToMany(targetEntity: Materiel::class, mappedBy: 'classer')]
    private Collection $materiels;

    public function __construct()
    {
        # Initialise les collections Doctrine
        $this->chirurgiens = new ArrayCollection();
        $this->materiels   = new ArrayCollection();
    }

    # Retourne l'identifiant de la spécialité
    public function getId(): ?int
    {
        return $this->id;
    }

    # Retourne l'intitulé de la spécialité
    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    # Définit l'intitulé de la spécialité
    public function setIntitule(string $intitule): static
    {
        $this->intitule = $intitule;
        return $this;
    }

    # Retourne la collection des chirurgiens liés à la spécialité
    /**
     * @return Collection<int, Chirurgien>
     */
    public function getChirurgiens(): Collection
    {
        return $this->chirurgiens;
    }

    # Ajoute un chirurgien à la spécialité
    # Met également à jour la relation côté Chirurgien
    public function addChirurgien(Chirurgien $chirurgien): static
    {
        if (!$this->chirurgiens->contains($chirurgien)) {
            $this->chirurgiens->add($chirurgien);
            $chirurgien->setSpecialiser($this);
        }

        return $this;
    }

    # Retire un chirurgien de la spécialité
    # Met la relation côté Chirurgien à null si nécessaire
    public function removeChirurgien(Chirurgien $chirurgien): static
    {
        if ($this->chirurgiens->removeElement($chirurgien)) {
            # Vérifie que le chirurgien est bien associé à cette spécialité
            if ($chirurgien->getSpecialiser() === $this) {
                $chirurgien->setSpecialiser(null);
            }
        }

        return $this;
    }

    # Retourne la collection des matériels liés à la spécialité
    /**
     * @return Collection<int, Materiel>
     */
    public function getMateriels(): Collection
    {
        return $this->materiels;
    }

    # Ajoute un matériel à la spécialité
    # Met également à jour la relation côté Materiel
    public function addMateriel(Materiel $materiel): static
    {
        if (!$this->materiels->contains($materiel)) {
            $this->materiels->add($materiel);
            $materiel->setClasser($this);
        }

        return $this;
    }

    # Retire un matériel de la spécialité
    # Met la relation côté Materiel à null si nécessaire
    public function removeMateriel(Materiel $materiel): static
    {
        if ($this->materiels->removeElement($materiel)) {
            # Vérifie que le matériel est bien associé à cette spécialité
            if ($materiel->getClasser() === $this) {
                $materiel->setClasser(null);
            }
        }

        return $this;
    }
}
