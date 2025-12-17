<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProgrammeOperatoireController extends AbstractController
{
    #[Route('/programme/operatoire', name: 'app_programme_operatoire')]
    public function index(): Response
    {
        return $this->render('programme_operatoire/index.html.twig', [
            'controller_name' => 'ProgrammeOperatoireController',
        ]);
    }
}
