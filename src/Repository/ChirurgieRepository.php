<?php

namespace App\Repository;

use App\Entity\Chirurgie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ChirurgieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        # Appelle le constructeur parent en indiquant l'entité gérée par ce repository
        parent::__construct($registry, Chirurgie::class);
    }

    public function findGroupedBySpecialiteAndChirurgien(): array
    {
        # Construit une requête Doctrine pour récupérer les chirurgies avec leurs relations
        return $this->createQueryBuilder('c')
            # Jointure avec le chirurgien lié à la chirurgie (relation operer)
            ->join('c.operer', 'ch')

            # Jointure avec la spécialité du chirurgien (relation specialiser)
            ->join('ch.specialiser', 's')

            # Ajoute le chirurgien et la spécialité dans le SELECT pour éviter des requêtes supplémentaires
            ->addSelect('ch', 's')

            # Trie d'abord par spécialité (ordre alphabétique)
            ->orderBy('s.intitule', 'ASC')

            # Trie ensuite par prénom du chirurgien
            ->addOrderBy('ch.prenom', 'ASC')

            # Puis par nom du chirurgien
            ->addOrderBy('ch.nom', 'ASC')

            # Puis par intitulé de la chirurgie
            ->addOrderBy('c.intitule', 'ASC')

            # Transforme le QueryBuilder en requête exécutable
            ->getQuery()

            # Exécute la requête et retourne un tableau de résultats (liste d'objets Chirurgie)
            ->getResult();
    }
}
