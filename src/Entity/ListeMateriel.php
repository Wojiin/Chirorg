<?php

namespace App\Entity;

use App\Repository\ListeMaterielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListeMaterielRepository::class)]
class ListeMateriel
{
    # Identifiant unique de la liste de matériel
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    # Intitulé de la liste de matériel
    #[ORM\Column(length: 255)]
    private ?string $intitule = null;

    # Chirurgien associé à la liste de matériel
    # Relation ManyToOne : plusieurs listes peuvent appartenir au même chirurgien
    #[ORM\ManyToOne(inversedBy: 'listesMateriel')]
    #[ORM\JoinColumn(nullable: true, onDelete: "SET NULL")]
    private ?Chirurgien $chirurgien = null;

    # Liste des chirurgies utilisant cette liste de matériel
    # Relation OneToMany : une liste peut être utilisée pour plusieurs chirurgies
    /**
     * @var Collection<int, Chirurgie>
     */
    #[ORM\OneToMany(targetEntity: Chirurgie::class, mappedBy: 'outiller')]
    private Collection $chirurgies;

    # Liste des matériels contenus dans cette liste
    # Relation ManyToMany : un matériel peut appartenir à plusieurs listes
    /**
     * @var Collection<int, Materiel>
     */
    #[ORM\ManyToMany(targetEntity: Materiel::class, mappedBy: 'lister')]
    private Collection $materiels;

    public function __construct()
    {
        # Initialise les collections Doctrine
        $this->chirurgies = new ArrayCollection();
        $this->materiels  = new ArrayCollection();
    }

    # Retourne l'identifiant de la liste de matériel
    public function getId(): ?int
    {
        return $this->id;
    }

    # Retourne l'intitulé de la liste de matériel
    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    # Définit l'intitulé de la liste de matériel
    public function setIntitule(string $intitule): static
    {
        $this->intitule = $intitule;
        return $this;
    }

    # Retourne le chirurgien associé à la liste
    public function getChirurgien(): ?Chirurgien
    {
        return $this->chirurgien;
    }

    # Associe un chirurgien à la liste de matériel
    public function setChirurgien(?Chirurgien $chirurgien): static
    {
        $this->chirurgien = $chirurgien;
        return $this;
    }

    # Retourne la collection des chirurgies utilisant cette liste
    /**
     * @return Collection<int, Chirurgie>
     */
    public function getChirurgies(): Collection
    {
        return $this->chirurgies;
    }

    # Retourne la collection des matériels contenus dans la liste
    /**
     * @return Collection<int, Materiel>
     */
    public function getMateriels(): Collection
    {
        return $this->materiels;
    }
}
