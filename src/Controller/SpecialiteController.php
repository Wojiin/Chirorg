<?php

namespace App\Controller;

use App\Entity\Specialite;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class SpecialiteController extends AbstractController
{
    #[Route('/specialite', name: 'app_specialite')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $specialites = $entityManager->getRepository(Specialite::class)->findAll();
        return $this->render('specialite/index.html.twig', [
            'specialites' => $specialites,
        ]);
    }
}
