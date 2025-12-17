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
     * @var Collection<int, ChirurgienChirurgieMateriel>
     */
    #[ORM\OneToMany(targetEntity: ChirurgienChirurgieMateriel::class, mappedBy: 'materiel')]
    private Collection $chirurgienChirurgieMateriels;

    #[ORM\ManyToOne(inversedBy: 'materiels')]
    private ?Specialite $specialite = null;

    public function __construct()
    {
        $this->chirurgienChirurgieMateriels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, ChirurgienChirurgieMateriel>
     */
    public function getChirurgienChirurgieMateriels(): Collection
    {
        return $this->chirurgienChirurgieMateriels;
    }

    public function addChirurgienChirurgieMateriel(ChirurgienChirurgieMateriel $ccm): static
    {
        if (!$this->chirurgienChirurgieMateriels->contains($ccm)) {
            $this->chirurgienChirurgieMateriels->add($ccm);
            $ccm->setMateriel($this);
        }
        return $this;
    }

    public function removeChirurgienChirurgieMateriel(ChirurgienChirurgieMateriel $ccm): static
    {
        if ($this->chirurgienChirurgieMateriels->removeElement($ccm)) {
            if ($ccm->getMateriel() === $this) {
                $ccm->setMateriel(null);
            }
        }
        return $this;
    }

    public function getSpecialite(): ?Specialite
    {
        return $this->specialite;
    }

    public function setSpecialite(?Specialite $specialite): static
    {
        $this->specialite = $specialite;

        return $this;
    }
}