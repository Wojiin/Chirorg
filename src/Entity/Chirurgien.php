<?php

namespace App\Entity;

use App\Repository\ChirurgienRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

namespace App\Entity;

use App\Repository\ChirurgienRepository;
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

    #[ORM\Column(length: 150)]
    private ?string $nom = null;

    #[ORM\Column(length: 150)]
    private ?string $prenom = null;

    #[ORM\ManyToOne(inversedBy: 'chirurgiens')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Specialite $specialiser = null;

    /**
     * @var Collection<int, ProgrammeOperatoire>
     */
    #[ORM\OneToMany(targetEntity: ProgrammeOperatoire::class, mappedBy: 'assumer', orphanRemoval: true)]
    private Collection $programmeOperatoires;

    /**
     * @var Collection<int, ChirurgienChirurgieMateriel>
     */
    #[ORM\OneToMany(targetEntity: ChirurgienChirurgieMateriel::class, mappedBy: 'chirurgien')]
    private Collection $chirurgienChirurgieMateriels;

    public function __construct()
    {
        $this->programmeOperatoires = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;
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

    /**
     * @return Collection<int, ProgrammeOperatoire>
     */
    public function getProgrammeOperatoires(): Collection
    {
        return $this->programmeOperatoires;
    }

    public function addProgrammeOperatoire(ProgrammeOperatoire $programmeOperatoire): static
    {
        if (!$this->programmeOperatoires->contains($programmeOperatoire)) {
            $this->programmeOperatoires->add($programmeOperatoire);
            $programmeOperatoire->setAssumer($this);
        }
        return $this;
    }

    public function removeProgrammeOperatoire(ProgrammeOperatoire $programmeOperatoire): static
    {
        if ($this->programmeOperatoires->removeElement($programmeOperatoire)) {
            if ($programmeOperatoire->getAssumer() === $this) {
                $programmeOperatoire->setAssumer(null);
            }
        }
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
            $ccm->setChirurgien($this);
        }
        return $this;
    }

    public function removeChirurgienChirurgieMateriel(ChirurgienChirurgieMateriel $ccm): static
    {
        if ($this->chirurgienChirurgieMateriels->removeElement($ccm)) {
            if ($ccm->getChirurgien() === $this) {
                $ccm->setChirurgien(null);
            }
        }
        return $this;
    }
}
