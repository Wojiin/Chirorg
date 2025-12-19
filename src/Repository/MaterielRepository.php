<?php

namespace App\Repository;

use App\Entity\Materiel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MaterielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        # Appelle le constructeur parent en indiquant l'entité gérée par ce repository
        parent::__construct($registry, Materiel::class);
    }

    public function findGroupedBySpecialite(): array
    {
        # Construit une requête Doctrine pour récupérer les matériels
        # en les associant à leur spécialité si elle existe
        return $this->createQueryBuilder('m')
            # Jointure LEFT avec la spécialité liée au matériel
            # LEFT JOIN permet d'inclure les matériels sans spécialité
            ->leftJoin('m.classer', 's')

            # Ajoute la spécialité au SELECT pour éviter des requêtes supplémentaires (N+1)
            ->addSelect('s')

            # Trie les résultats par intitulé de spécialité (ordre alphabétique)
            ->orderBy('s.intitule', 'ASC')

            # Trie ensuite les matériels par leur intitulé
            ->addOrderBy('m.intitule', 'ASC')

            # Transforme le QueryBuilder en requête exécutable
            ->getQuery()

            # Exécute la requête et retourne un tableau d'objets Materiel
            ->getResult();
    }

    
}
