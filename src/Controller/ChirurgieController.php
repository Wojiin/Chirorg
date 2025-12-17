<?php

namespace App\Controller;

use App\Entity\Chirurgie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ChirurgieController extends AbstractController
{
    #[Route('/chirurgie', name: 'app_chirurgie')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $chirurgies = $entityManager->getRepository(Chirurgie::class)->findAll();

        return $this->render('chirurgie/index.html.twig', [
            'chirurgies' => $chirurgies
        ]);
    }
}
