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
    private ?string $intitule = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\ManyToOne(inversedBy: 'materiels')]
    private ?Specialite $classer = null;

    /**
     * @var Collection<int, ListeMateriel>
     */
    #[ORM\ManyToMany(targetEntity: ListeMateriel::class, inversedBy: 'materiels')]
    private Collection $lister;

    public function __construct()
    {
        $this->lister = new ArrayCollection();
    }

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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

    public function getClasser(): ?Specialite
    {
        return $this->classer;
    }

    public function setClasser(?Specialite $classer): static
    {
        $this->classer = $classer;

        return $this;
    }

    /**
     * @return Collection<int, ListeMateriel>
     */
    public function getLister(): Collection
    {
        return $this->lister;
    }

    public function addLister(ListeMateriel $lister): static
    {
        if (!$this->lister->contains($lister)) {
            $this->lister->add($lister);
        }

        return $this;
    }

    public function removeLister(ListeMateriel $lister): static
    {
        $this->lister->removeElement($lister);

        return $this;
    }
}
