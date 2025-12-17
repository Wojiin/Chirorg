<?php

namespace App\Controller;

use App\Entity\Specialite;
use App\Form\SpecialiteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/specialite')]
class SpecialiteController extends AbstractController
{
    // =====================================================
    // Index
    // =====================================================
    #[Route('/', name: 'app_specialite', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $specialites = $em->getRepository(Specialite::class)
            ->createQueryBuilder('s')
            ->orderBy('s.intitule', 'ASC')
            ->getQuery()
            ->getResult();

        return $this->render('specialite/index.html.twig', [
            'specialites' => $specialites,
        ]);
    }

    // =====================================================
    // Ajouter
    // =====================================================
    #[Route('/new', name: 'app_specialite_new', methods: ['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $specialite = new Specialite();
        $form = $this->createForm(SpecialiteType::class, $specialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($specialite);
            $em->flush();
            $this->addFlash('success', 'Spécialité ajoutée avec succès !');
            return $this->redirectToRoute('app_specialite');
        }

        return $this->render('specialite/new.html.twig', [
            'specialite' => $specialite,
            'form' => $form->createView(),
        ]);
    }

    // =====================================================
    // Modifier
    // =====================================================
    #[Route('/{id}/edit', name: 'app_specialite_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Specialite $specialite, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(SpecialiteType::class, $specialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Spécialité modifiée avec succès !');
            return $this->redirectToRoute('app_specialite');
        }

        return $this->render('specialite/edit.html.twig', [
            'specialite' => $specialite,
            'form' => $form->createView(),
        ]);
    }

    // =====================================================
    // Supprimer
    // =====================================================
    #[Route('/{id}/delete', name: 'app_specialite_delete', methods: ['POST'])]
    public function delete(Request $request, Specialite $specialite, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$specialite->getId(), $request->request->get('_token'))) {
            $em->remove($specialite);
            $em->flush();
            $this->addFlash('success', 'Spécialité supprimée avec succès !');
        }

        return $this->redirectToRoute('app_specialite');
    }
}
