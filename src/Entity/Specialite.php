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

    /**
     * @var Collection<int, Chirurgie>
     */
    #[ORM\OneToMany(targetEntity: Chirurgie::class, mappedBy: 'specialite')]
    private Collection $chirurgies;

    /**
     * @var Collection<int, Materiel>
     */
    #[ORM\OneToMany(targetEntity: Materiel::class, mappedBy: 'specialite')]
    private Collection $materiels;

    public function __construct()
    {
        $this->chirurgiens = new ArrayCollection();
        $this->chirurgies = new ArrayCollection();
        $this->materiels = new ArrayCollection();
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

    /**
     * @return Collection<int, Chirurgie>
     */
    public function getChirurgies(): Collection
    {
        return $this->chirurgies;
    }

    public function addChirurgy(Chirurgie $chirurgy): static
    {
        if (!$this->chirurgies->contains($chirurgy)) {
            $this->chirurgies->add($chirurgy);
            $chirurgy->setSpecialite($this);
        }

        return $this;
    }

    public function removeChirurgy(Chirurgie $chirurgy): static
    {
        if ($this->chirurgies->removeElement($chirurgy)) {
            // set the owning side to null (unless already changed)
            if ($chirurgy->getSpecialite() === $this) {
                $chirurgy->setSpecialite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Materiel>
     */
    public function getMateriels(): Collection
    {
        return $this->materiels;
    }

    public function addMateriel(Materiel $materiel): static
    {
        if (!$this->materiels->contains($materiel)) {
            $this->materiels->add($materiel);
            $materiel->setSpecialite($this);
        }

        return $this;
    }

    public function removeMateriel(Materiel $materiel): static
    {
        if ($this->materiels->removeElement($materiel)) {
            // set the owning side to null (unless already changed)
            if ($materiel->getSpecialite() === $this) {
                $materiel->setSpecialite(null);
            }
        }

        return $this;
    }
}
