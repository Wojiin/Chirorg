<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
# Contrainte d'unicité sur l'email en base de données
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
# Contrainte de validation Symfony pour éviter les doublons d'email
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    # Identifiant unique de l'utilisateur
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    # Adresse email de l'utilisateur (identifiant de connexion)
    #[ORM\Column(length: 180)]
    private ?string $email = null;

    # Rôles de l'utilisateur (ROLE_USER, ROLE_ADMIN, etc.)
    /**
     * @var list<string>
     */
    #[ORM\Column]
    private array $roles = [];

    # Mot de passe hashé de l'utilisateur
    #[ORM\Column]
    private ?string $password = null;

    # Prénom de l'utilisateur
    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    # Nom de l'utilisateur
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    # Chirurgies organisées ou créées par l'utilisateur
    # Relation OneToMany : un utilisateur peut organiser plusieurs chirurgies
    /**
     * @var Collection<int, Chirurgie>
     */
    #[ORM\OneToMany(targetEntity: Chirurgie::class, mappedBy: 'utilisateur')]
    private Collection $organiser;

    public function __construct()
    {
        # Initialise la collection des chirurgies organisées
        $this->organiser = new ArrayCollection();
    }

    # Retourne l'identifiant de l'utilisateur
    public function getId(): ?int
    {
        return $this->id;
    }

    # Retourne l'email de l'utilisateur
    public function getEmail(): ?string
    {
        return $this->email;
    }

    # Définit l'email de l'utilisateur
    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    # Identifiant visuel utilisé par Symfony Security (email)
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    # Retourne les rôles de l'utilisateur
    # Garantit la présence du rôle ROLE_USER
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    # Définit les rôles de l'utilisateur
    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    # Retourne le mot de passe hashé
    public function getPassword(): ?string
    {
        return $this->password;
    }

    # Définit le mot de passe hashé
    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    # Sécurise la sérialisation de l'utilisateur en session
    # Le mot de passe n'est jamais stocké en clair
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    # Méthode requise par Symfony Security
    # Dépréciée à partir de Symfony 7.x
    #[\Deprecated]
    public function eraseCredentials(): void
    {
        # Aucun secret temporaire à supprimer
    }

    # Retourne le prénom de l'utilisateur
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    # Définit le prénom de l'utilisateur
    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

    # Retourne le nom de l'utilisateur
    public function getNom(): ?string
    {
        return $this->nom;
    }

    # Définit le nom de l'utilisateur
    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    # Retourne les chirurgies organisées par l'utilisateur
    /**
     * @return Collection<int, Chirurgie>
     */
    public function getOrganiser(): Collection
    {
        return $this->organiser;
    }

    # Associe une chirurgie à l'utilisateur
    # Met à jour la relation côté Chirurgie
    public function addOrganiser(Chirurgie $organiser): static
    {
        if (!$this->organiser->contains($organiser)) {
            $this->organiser->add($organiser);
            $organiser->setUtilisateur($this);
        }

        return $this;
    }

    # Retire une chirurgie associée à l'utilisateur
    # Met la relation côté Chirurgie à null si nécessaire
    public function removeOrganiser(Chirurgie $organiser): static
    {
        if ($this->organiser->removeElement($organiser)) {
            if ($organiser->getUtilisateur() === $this) {
                $organiser->setUtilisateur(null);
            }
        }

        return $this;
    }
}
