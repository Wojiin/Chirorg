<?php

namespace App\Controller;

use App\Entity\Chirurgie;
use App\Form\ChirurgieType;
use App\Repository\ChirurgieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

#[Route('/chirurgie')]
class ChirurgieController extends AbstractController
{
    #[Route('/', name: 'app_chirurgie', methods: ['GET'])]
    public function index(ChirurgieRepository $chirurgieRepository): Response
    {
        $chirurgiesParSpecialite = $chirurgieRepository->findAllGroupedBySpecialite();

        return $this->render('chirurgie/index.html.twig', [
            'chirurgiesParSpecialite' => $chirurgiesParSpecialite,
        ]);
    }

    #[Route('/new', name: 'chirurgie_new', methods: ['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $chirurgie = new Chirurgie();
        $form = $this->createForm(ChirurgieType::class, $chirurgie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($chirurgie);
            $em->flush();

            $this->addFlash('success', 'Chirurgie ajoutée avec succès !');

            return $this->redirectToRoute('app_chirurgie');
        }

        return $this->render('chirurgie/new.html.twig', [
            'chirurgie' => $chirurgie,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'chirurgie_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Chirurgie $chirurgie, EntityManagerInterface $em): Response
    {
        /* var_dump($chirurgie); die(); */
        $form = $this->createForm(ChirurgieType::class, $chirurgie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Chirurgie modifiée avec succès !');

            return $this->redirectToRoute('app_chirurgie');
        }

        return $this->render('chirurgie/edit.html.twig', [
            'chirurgie' => $chirurgie,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/delete', name: 'chirurgie_delete', methods: ['POST'])]
    public function delete(Request $request, Chirurgie $chirurgie, ChirurgieRepository $chirurgieRepository, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chirurgie->getId(), $request->request->get('_token'))) {
            $chirurgieRepository->deleteChirurgie($chirurgie, $em);
            $this->addFlash('success', 'Chirurgie supprimée avec succès !');
        }

        return $this->redirectToRoute('app_chirurgie');
    }
}
