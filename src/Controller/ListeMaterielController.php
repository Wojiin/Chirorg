<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ListeMaterielController extends AbstractController
{
    #[Route('/liste/materiel', name: 'app_liste_materiel')]
    public function index(): Response
    {
        return $this->render('liste_materiel/index.html.twig', [
            'controller_name' => 'ListeMaterielController',
        ]);
    }
}
