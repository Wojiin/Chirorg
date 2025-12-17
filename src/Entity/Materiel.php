<?php

namespace App\Entity;

use App\Repository\MaterielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaterielRepository::class)]
class Materiel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    /**
     * @var Collection<int, ListeMateriel>
     */
    #[ORM\ManyToMany(targetEntity: ListeMateriel::class, mappedBy: 'lister')]
    private Collection $listeMateriels;

    public function __construct()
    {
        $this->listeMateriels = new ArrayCollection();
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, ListeMateriel>
     */
    public function getListeMateriels(): Collection
    {
        return $this->listeMateriels;
    }

    public function addListeMateriel(ListeMateriel $listeMateriel): static
    {
        if (!$this->listeMateriels->contains($listeMateriel)) {
            $this->listeMateriels->add($listeMateriel);
            $listeMateriel->addLister($this);
        }

        return $this;
    }

    public function removeListeMateriel(ListeMateriel $listeMateriel): static
    {
        if ($this->listeMateriels->removeElement($listeMateriel)) {
            $listeMateriel->removeLister($this);
        }

        return $this;
    }
}
