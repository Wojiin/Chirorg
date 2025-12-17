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

    /**
     * Récupère les chirurgies triées par spécialité
     *
     * @return array<string, Chirurgie[]>
     */
    public function findAllGroupedBySpecialite(): array
    {
        $chirurgies = $this->createQueryBuilder('c')
            ->leftJoin('c.specialite', 's')
            ->addSelect('s')
            ->orderBy('s.intitule', 'ASC')
            ->addOrderBy('c.intitule', 'ASC')
            ->getQuery()
            ->getResult();

        $chirurgiesParSpecialite = [];
        foreach ($chirurgies as $chirurgie) {
            $nomSpecialite = $chirurgie->getSpecialite()?->getIntitule() ?? '—';
            $chirurgiesParSpecialite[$nomSpecialite][] = $chirurgie;
        }

        return $chirurgiesParSpecialite;
    }

    /**
     * Supprime une chirurgie et ses relations
     */
    public function deleteChirurgie(Chirurgie $chirurgie, $entityManager): void
    {
        foreach ($chirurgie->getChirurgienChirurgieMateriels() as $ccm) {
            $entityManager->remove($ccm);
        }

        $entityManager->remove($chirurgie);
        $entityManager->flush();
    }
}

