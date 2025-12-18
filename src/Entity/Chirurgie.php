<?php

namespace App\Entity;

use App\Repository\ChirurgieRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChirurgieRepository::class)]
class Chirurgie
{
    # Identifiant unique de la chirurgie
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    # Intitulé de la chirurgie
    #[ORM\Column(length: 255)]
    private ?string $intitule = null;

    # Fiche technique détaillée de la chirurgie
    #[ORM\Column(type: Types::TEXT)]
    private ?string $fiche_technique = null;

    # Date et heure de la chirurgie
    #[ORM\Column]
    private ?\DateTime $date = null;

    # Salle dans laquelle se déroule la chirurgie
    #[ORM\Column(length: 50)]
    private ?string $salle = null;

    # Indique si la chirurgie est validée ou non
    #[ORM\Column]
    private ?bool $valide = null;

    # Utilisateur ayant créé ou organisé la chirurgie
    #[ORM\ManyToOne(inversedBy: 'organiser')]
    private ?Utilisateur $utilisateur = null;

    # Chirurgien qui opère la chirurgie
    #[ORM\ManyToOne(inversedBy: 'outiller')]
    private ?Chirurgien $operer = null;

    # Liste de matériel utilisée pour la chirurgie
    #[ORM\ManyToOne(inversedBy: 'chirurgies')]
    private ?ListeMateriel $outiller = null;

    # Retourne l'identifiant de la chirurgie
    public function getId(): ?int
    {
        return $this->id;
    }

    # Retourne l'intitulé de la chirurgie
    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    # Définit l'intitulé de la chirurgie
    public function setIntitule(string $intitule): static
    {
        $this->intitule = $intitule;
        return $this;
    }

    # Retourne la fiche technique de la chirurgie
    public function getFicheTechnique(): ?string
    {
        return $this->fiche_technique;
    }

    # Définit la fiche technique de la chirurgie
    public function setFicheTechnique(string $fiche_technique): static
    {
        $this->fiche_technique = $fiche_technique;
        return $this;
    }

    # Retourne la date de la chirurgie
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    # Définit la date de la chirurgie
    public function setDate(\DateTime $date): static
    {
        $this->date = $date;
        return $this;
    }

    # Retourne la salle de la chirurgie
    public function getSalle(): ?string
    {
        return $this->salle;
    }

    # Définit la salle de la chirurgie
    public function setSalle(string $salle): static
    {
        $this->salle = $salle;
        return $this;
    }

    # Indique si la chirurgie est validée
    public function isValide(): ?bool
    {
        return $this->valide;
    }

    # Définit l'état de validation de la chirurgie
    public function setValide(bool $valide): static
    {
        $this->valide = $valide;
        return $this;
    }

    # Retourne l'utilisateur associé à la chirurgie
    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    # Associe un utilisateur à la chirurgie
    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    # Retourne le chirurgien qui opère la chirurgie
    public function getOperer(): ?Chirurgien
    {
        return $this->operer;
    }

    # Associe un chirurgien à la chirurgie
    public function setOperer(?Chirurgien $operer): static
    {
        $this->operer = $operer;
        return $this;
    }

    # Retourne la liste de matériel associée à la chirurgie
    public function getOutiller(): ?ListeMateriel
    {
        return $this->outiller;
    }

    # Associe une liste de matériel à la chirurgie
    public function setOutiller(?ListeMateriel $outiller): static
    {
        $this->outiller = $outiller;
        return $this;
    }
}
