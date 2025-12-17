<?php

namespace App\Entity;

use App\Repository\ChirurgieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChirurgieRepository::class)]
class Chirurgie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $intitule = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $ficheTechnique = null;

    #[ORM\ManyToOne(inversedBy: 'programmer')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProgrammeOperatoire $programmeOperatoire = null;

    #[ORM\ManyToOne(inversedBy: 'opérer')]
    private ?Chirurgien $chirurgien = null;

    /**
     * @var Collection<int, ListeMateriel>
     */
    #[ORM\OneToMany(targetEntity: ListeMateriel::class, mappedBy: 'chirurgie', orphanRemoval: true)]
    private Collection $preparer;

    public function __construct()
    {
        $this->preparer = new ArrayCollection();
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

    public function getFicheTechnique(): ?string
    {
        return $this->ficheTechnique;
    }

    public function setFicheTechnique(string $ficheTechnique): static
    {
        $this->ficheTechnique = $ficheTechnique;

        return $this;
    }

    public function getProgrammeOperatoire(): ?ProgrammeOperatoire
    {
        return $this->programmeOperatoire;
    }

    public function setProgrammeOperatoire(?ProgrammeOperatoire $programmeOperatoire): static
    {
        $this->programmeOperatoire = $programmeOperatoire;

        return $this;
    }

    public function getChirurgien(): ?Chirurgien
    {
        return $this->chirurgien;
    }

    public function setChirurgien(?Chirurgien $chirurgien): static
    {
        $this->chirurgien = $chirurgien;

        return $this;
    }

    /**
     * @return Collection<int, ListeMateriel>
     */
    public function getPreparer(): Collection
    {
        return $this->preparer;
    }

    public function addPreparer(ListeMateriel $preparer): static
    {
        if (!$this->preparer->contains($preparer)) {
            $this->preparer->add($preparer);
            $preparer->setChirurgie($this);
        }

        return $this;
    }

    public function removePreparer(ListeMateriel $preparer): static
    {
        if ($this->preparer->removeElement($preparer)) {
            // set the owning side to null (unless already changed)
            if ($preparer->getChirurgie() === $this) {
                $preparer->setChirurgie(null);
            }
        }

        return $this;
    }
}
