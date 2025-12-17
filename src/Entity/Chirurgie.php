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

    /**
     * @var Collection<int, ChirurgienChirurgieMateriel>
     */
    #[ORM\OneToMany(targetEntity: ChirurgienChirurgieMateriel::class, mappedBy: 'chirurgie')]
    private Collection $chirurgienChirurgieMateriels;

    public function __construct()
    {
        $this->chirurgienChirurgieMateriels = new ArrayCollection();
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
            $ccm->setChirurgie($this);
        }
        return $this;
    }

    public function removeChirurgienChirurgieMateriel(ChirurgienChirurgieMateriel $ccm): static
    {
        if ($this->chirurgienChirurgieMateriels->removeElement($ccm)) {
            if ($ccm->getChirurgie() === $this) {
                $ccm->setChirurgie(null);
            }
        }
        return $this;
    }
}
