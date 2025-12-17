<?php

namespace App\Controller;

use App\Entity\Chirurgien;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ChirurgienController extends AbstractController
{
    #[Route('/chirurgien', name: 'app_chirurgien')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $chirurgiens = $entityManager->getRepository(Chirurgien::class)->findBy([], ['specialiser' => 'ASC']);
        return $this->render('chirurgien/index.html.twig', [
            'chirurgiens' => $chirurgiens
        ]);
    }
}
