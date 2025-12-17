<?php

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

    /**
     * @var Collection<int, ProgrammeOperatoire>
     */
    #[ORM\OneToMany(targetEntity: ProgrammeOperatoire::class, mappedBy: 'assumer', orphanRemoval: true)]
    private Collection $programmeOperatoires;

    /**
     * @var Collection<int, Chirurgie>
     */
    #[ORM\OneToMany(targetEntity: Chirurgie::class, mappedBy: 'chirurgien')]
    private Collection $opérer;

    /**
     * @var Collection<int, ListeMateriel>
     */
    #[ORM\OneToMany(targetEntity: ListeMateriel::class, mappedBy: 'chirurgien', orphanRemoval: true)]
    private Collection $choisir;

    #[ORM\ManyToOne(inversedBy: 'chirurgiens')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Specialite $specialiser = null;

    public function __construct()
    {
        $this->programmeOperatoires = new ArrayCollection();
        $this->opérer = new ArrayCollection();
        $this->choisir = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

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
            // set the owning side to null (unless already changed)
            if ($programmeOperatoire->getAssumer() === $this) {
                $programmeOperatoire->setAssumer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Chirurgie>
     */
    public function getOpérer(): Collection
    {
        return $this->opérer;
    }

    public function addOpRer(Chirurgie $opRer): static
    {
        if (!$this->opérer->contains($opRer)) {
            $this->opérer->add($opRer);
            $opRer->setChirurgien($this);
        }

        return $this;
    }

    public function removeOpRer(Chirurgie $opRer): static
    {
        if ($this->opérer->removeElement($opRer)) {
            // set the owning side to null (unless already changed)
            if ($opRer->getChirurgien() === $this) {
                $opRer->setChirurgien(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ListeMateriel>
     */
    public function getChoisir(): Collection
    {
        return $this->choisir;
    }

    public function addChoisir(ListeMateriel $choisir): static
    {
        if (!$this->choisir->contains($choisir)) {
            $this->choisir->add($choisir);
            $choisir->setChirurgien($this);
        }

        return $this;
    }

    public function removeChoisir(ListeMateriel $choisir): static
    {
        if ($this->choisir->removeElement($choisir)) {
            // set the owning side to null (unless already changed)
            if ($choisir->getChirurgien() === $this) {
                $choisir->setChirurgien(null);
            }
        }

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
}
