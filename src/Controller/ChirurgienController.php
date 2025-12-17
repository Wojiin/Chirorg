<?php

namespace App\Controller;

use App\Entity\Chirurgien;
use App\Form\ChirurgienType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/chirurgien')]
class ChirurgienController extends AbstractController
{
    // =====================================================
    // Index
    // =====================================================
#[Route('/', name: 'app_chirurgien', methods: ['GET'])]
public function index(EntityManagerInterface $em): Response
{
    $chirurgiens = $em->getRepository(Chirurgien::class)
        ->createQueryBuilder('c')
        ->leftJoin('c.specialiser', 's')
        ->addSelect('s')
        ->orderBy('s.intitule', 'ASC')
        ->addOrderBy('c.nom', 'ASC')
        ->getQuery()
        ->getResult();

    // Grouper par spécialité
    $chirurgiensParSpecialite = [];
    foreach ($chirurgiens as $chirurgien) {
        $specialite = $chirurgien->getSpecialiser()?->getIntitule() ?? '—';
        $chirurgiensParSpecialite[$specialite][] = $chirurgien;
    }

    return $this->render('chirurgien/index.html.twig', [
        'chirurgiensParSpecialite' => $chirurgiensParSpecialite,
    ]);
}


    // =====================================================
    // Ajouter
    // =====================================================
    #[Route('/new', name: 'app_chirurgien_new', methods: ['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $chirurgien = new Chirurgien();
        $form = $this->createForm(ChirurgienType::class, $chirurgien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($chirurgien);
            $em->flush();
            $this->addFlash('success', 'Chirurgien ajouté avec succès !');
            return $this->redirectToRoute('app_chirurgien');
        }

        return $this->render('chirurgien/new.html.twig', [
            'chirurgien' => $chirurgien,
            'form' => $form->createView(),
        ]);
    }

    // =====================================================
    // Modifier
    // =====================================================
    #[Route('/{id}/edit', name: 'app_chirurgien_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Chirurgien $chirurgien, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ChirurgienType::class, $chirurgien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Chirurgien modifié avec succès !');
            return $this->redirectToRoute('app_chirurgien');
        }

        return $this->render('chirurgien/edit.html.twig', [
            'chirurgien' => $chirurgien,
            'form' => $form->createView(),
        ]);
    }

    // =====================================================
    // Supprimer
    // =====================================================
    #[Route('/{id}/delete', name: 'app_chirurgien_delete', methods: ['POST'])]
    public function delete(Request $request, Chirurgien $chirurgien, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chirurgien->getId(), $request->request->get('_token'))) {
            $em->remove($chirurgien);
            $em->flush();
            $this->addFlash('success', 'Chirurgien supprimé avec succès !');
        }

        return $this->redirectToRoute('app_chirurgien');
    }
}
