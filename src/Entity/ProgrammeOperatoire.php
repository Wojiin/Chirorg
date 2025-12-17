<?php

namespace App\Entity;

use App\Repository\ProgrammeOperatoireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgrammeOperatoireRepository::class)]
class ProgrammeOperatoire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 3)]
    private ?string $salle = null;

    #[ORM\Column]
    private ?\DateTime $date = null;

    #[ORM\ManyToOne(inversedBy: 'programmeOperatoires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $organiser = null;

    #[ORM\ManyToOne(inversedBy: 'programmeOperatoires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chirurgien $assumer = null;

    /**
     * @var Collection<int, Chirurgie>
     */
    #[ORM\OneToMany(targetEntity: Chirurgie::class, mappedBy: 'programmeOperatoire')]
    private Collection $programmer;

    /**
     * @var Collection<int, Chirurgien>
     */
    #[ORM\OneToMany(targetEntity: Chirurgien::class, mappedBy: 'operer')]
    private Collection $chirurgiens;

    public function __construct()
    {
        $this->programmer = new ArrayCollection();
        $this->chirurgiens = new ArrayCollection();
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

    public function getSalle(): ?string
    {
        return $this->salle;
    }

    public function setSalle(string $salle): static
    {
        $this->salle = $salle;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getOrganiser(): ?Utilisateur
    {
        return $this->organiser;
    }

    public function setOrganiser(?Utilisateur $organiser): static
    {
        $this->organiser = $organiser;

        return $this;
    }

    public function getAssumer(): ?Chirurgien
    {
        return $this->assumer;
    }

    public function setAssumer(?Chirurgien $assumer): static
    {
        $this->assumer = $assumer;

        return $this;
    }

    /**
     * @return Collection<int, Chirurgie>
     */
    public function getProgrammer(): Collection
    {
        return $this->programmer;
    }

    public function addProgrammer(Chirurgie $programmer): static
    {
        if (!$this->programmer->contains($programmer)) {
            $this->programmer->add($programmer);
            $programmer->setProgrammeOperatoire($this);
        }

        return $this;
    }

    public function removeProgrammer(Chirurgie $programmer): static
    {
        if ($this->programmer->removeElement($programmer)) {
            // set the owning side to null (unless already changed)
            if ($programmer->getProgrammeOperatoire() === $this) {
                $programmer->setProgrammeOperatoire(null);
            }
        }

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
            $chirurgien->setOperer($this);
        }

        return $this;
    }

    public function removeChirurgien(Chirurgien $chirurgien): static
    {
        if ($this->chirurgiens->removeElement($chirurgien)) {
            // set the owning side to null (unless already changed)
            if ($chirurgien->getOperer() === $this) {
                $chirurgien->setOperer(null);
            }
        }

        return $this;
    }
}
