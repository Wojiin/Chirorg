<?php

namespace App\Repository;

use App\Entity\Chirurgie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ChirurgieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chirurgie::class);
    }

    public function findGroupedBySpecialiteAndChirurgien(): array
    {
        return $this->createQueryBuilder('c')
            ->join('c.operer', 'ch')
            ->join('ch.specialiser', 's')
            ->addSelect('ch', 's')
            ->orderBy('s.intitule', 'ASC')
            ->addOrderBy('ch.prenom', 'ASC')
            ->addOrderBy('ch.nom', 'ASC')
            ->addOrderBy('c.intitule', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
