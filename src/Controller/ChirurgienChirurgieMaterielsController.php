<?php

namespace App\Controller;

use App\Entity\Chirurgien;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


final class ChirurgienChirurgieMaterielsController extends AbstractController
{
    #[Route('/chirurgien/chirurgie/materiels', name: 'app_chirurgien_chirurgie_materiels')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $chirurgiens = $entityManager->getRepository(Chirurgien::class)
            ->createQueryBuilder('c')
            ->leftJoin('c.chirurgienChirurgieMateriels', 'ccm')
            ->leftJoin('ccm.chirurgie', 'chirurgie')
            ->leftJoin('ccm.materiel', 'materiel')
            ->addSelect('ccm, chirurgie, materiel')
            ->getQuery()
            ->getResult();

        $data = [];

        foreach ($chirurgiens as $chirurgien) {
            $listeParChirurgie = [];

            foreach ($chirurgien->getChirurgienChirurgieMateriels() as $ccm) {
                $chirurgie = $ccm->getChirurgie();
                $materiel = $ccm->getMateriel();

                if ($chirurgie && $materiel) {
                    $nomChirurgie = $chirurgie->getIntitule();
                    $listeParChirurgie[$nomChirurgie][] = [
                        'materiel_nom' => $materiel->getNom(),
                        'materiel_adresse' => $materiel->getAdresse(), // <- changement ici
                    ];
                }
            }

            $data[] = [
                'chirurgien_id' => $chirurgien->getId(),
                'chirurgien_nom' => $chirurgien->getNom(),
                'chirurgien_prenom' => $chirurgien->getPrenom(),
                'chirurgies' => $listeParChirurgie,
            ];
        }

        return $this->render('chirurgien_chirurgie_materiels/index.html.twig', [
            'data' => $data,
        ]);
    }
}