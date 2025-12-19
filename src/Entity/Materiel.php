<?php

namespace App\Entity;

use App\Repository\MaterielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaterielRepository::class)]
class Materiel
{
    # Identifiant unique du matériel
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    # Intitulé du matériel
    #[ORM\Column(length: 255)]
    private ?string $intitule = null;

    # Type de matériel (ex : Instrument, Consommable, Appareil)
    #[ORM\Column(length: 50)]
    private ?string $type = null;

    # Adresse ou emplacement du matériel (ex : Armoire A3, Stock bloc)
    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    # Spécialité à laquelle le matériel est rattaché
    # Relation ManyToOne : plusieurs matériels peuvent appartenir à une même spécialité
    #[ORM\ManyToOne(inversedBy: 'materiels')]
    #[ORM\JoinColumn(nullable: true, onDelete: "SET NULL")]
    private ?Specialite $classer = null;

    # Listes de matériel auxquelles ce matériel appartient
    # Relation ManyToMany : un matériel peut être présent dans plusieurs listes
    /**
     * @var Collection<int, ListeMateriel>
     */
    #[ORM\ManyToMany(targetEntity: ListeMateriel::class, inversedBy: 'materiels')]
    private Collection $lister;

    public function __construct()
    {
        # Initialise la collection des listes de matériel
        $this->lister = new ArrayCollection();
    }

    # Retourne l'identifiant du matériel
    public function getId(): ?int
    {
        return $this->id;
    }

    # Retourne l'intitulé du matériel
    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    # Définit l'intitulé du matériel
    public function setIntitule(string $intitule): static
    {
        $this->intitule = $intitule;
        return $this;
    }

    # Retourne le type du matériel
    public function getType(): ?string
    {
        return $this->type;
    }

    # Définit le type du matériel
    public function setType(string $type): static
    {
        $this->type = $type;
        return $this;
    }

    # Retourne l'adresse ou l'emplacement du matériel
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    # Définit l'adresse ou l'emplacement du matériel
    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;
        return $this;
    }

    # Retourne la spécialité associée au matériel
    public function getClasser(): ?Specialite
    {
        return $this->classer;
    }

    # Associe une spécialité au matériel
    public function setClasser(?Specialite $classer): static
    {
        $this->classer = $classer;
        return $this;
    }

    # Retourne les listes de matériel associées à ce matériel
    /**
     * @return Collection<int, ListeMateriel>
     */
    public function getLister(): Collection
    {
        return $this->lister;
    }

    # Ajoute le matériel à une liste de matériel
    public function addLister(ListeMateriel $lister): static
    {
        if (!$this->lister->contains($lister)) {
            $this->lister->add($lister);
        }

        return $this;
    }

    # Retire le matériel d'une liste de matériel
    public function removeLister(ListeMateriel $lister): static
    {
        $this->lister->removeElement($lister);
        return $this;
    }
}
