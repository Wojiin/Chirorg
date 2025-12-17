<?php

namespace App\Controller;

use App\Entity\Materiel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class MaterielController extends AbstractController
{
    #[Route('/materiel', name: 'app_materiel')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $materiels = $entityManager->getRepository(Materiel::class)->findBy([], ["type" => "ASC"]);
        return $this->render('materiel/index.html.twig', [
            'materiels' => $materiels,
        ]);
    }
}
