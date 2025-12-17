<?php

namespace App\Controller;

use App\Entity\ListeMateriel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ListeMaterielController extends AbstractController
{
    #[Route('/liste/materiel', name: 'app_liste_materiel')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $listes_materiel = $entityManager->getRepository(ListeMateriel::class)->findBy([], ['chirurgien' => 'ASC']);
        return $this->render('liste_materiel/index.html.twig', [
            'listes_materiel' => $listes_materiel,
        ]);
    }
}
