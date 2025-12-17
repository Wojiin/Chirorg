<?php

namespace App\Controller;

use App\Entity\Chirurgie;
use App\Form\ChirurgieType;
use App\Repository\ChirurgieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/chirurgie')]
class ChirurgieController extends AbstractController
{
    #[Route('/', name: 'chirurgie_index', methods: ['GET'])]
    public function index(ChirurgieRepository $chirurgieRepository): Response
    {
        $chirurgies = $chirurgieRepository->findAll();

        $grouped = [];

        foreach ($chirurgies as $chirurgie) {

            if (
                !$chirurgie->getOperer() ||
                !$chirurgie->getOperer()->getSpecialiser()
            ) {
                continue;
            }

            $specialite = $chirurgie
                ->getOperer()
                ->getSpecialiser()
                ->getIntitule();

            $chirurgien = $chirurgie
                ->getOperer()
                ->getNom()
                . ' ' .
                $chirurgie
                ->getOperer()
                ->getPrenom();

            $salle = $chirurgie->getSalle() ?? 'Salle inconnue';

            if (!isset($grouped[$specialite])) {
                $grouped[$specialite] = [];
            }

            if (!isset($grouped[$specialite][$chirurgien])) {
                $grouped[$specialite][$chirurgien] = [];
            }

            if (!isset($grouped[$specialite][$chirurgien][$salle])) {
                $grouped[$specialite][$chirurgien][$salle] = [];
            }

            $grouped[$specialite][$chirurgien][$salle][] = $chirurgie;
        }

        return $this->render('chirurgie/index.html.twig', [
            'grouped_chirurgies' => $grouped
        ]);
    }

    #[Route('/new', name: 'chirurgie_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $em,
        ChirurgieRepository $chirurgieRepository
    ): Response {
        $chirurgie = new Chirurgie();

        $intitulesExistants = $chirurgieRepository
            ->createQueryBuilder('c')
            ->select('DISTINCT c.intitule')
            ->orderBy('c.intitule', 'ASC')
            ->getQuery()
            ->getSingleColumnResult();

        $form = $this->createForm(ChirurgieType::class, $chirurgie, [
            'intitules_existants' => array_combine($intitulesExistants, $intitulesExistants),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $intituleExistant = $form->get('intitule_existant')->getData();

            if ($intituleExistant) {
                $chirurgie->setIntitule($intituleExistant);
            }

            $em->persist($chirurgie);
            $em->flush();

            return $this->redirectToRoute('chirurgie_index');
        }

        return $this->render('chirurgie/new.html.twig', [
            'chirurgie' => $chirurgie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'chirurgie_show', methods: ['GET'])]
    public function show(Chirurgie $chirurgie): Response
    {
        return $this->render('chirurgie/show.html.twig', [
            'chirurgie' => $chirurgie,
        ]);
    }

    #[Route('/{id}/edit', name: 'chirurgie_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Chirurgie $chirurgie,
        EntityManagerInterface $em,
        ChirurgieRepository $chirurgieRepository
    ): Response {
        $intitulesExistants = $chirurgieRepository
            ->createQueryBuilder('c')
            ->select('DISTINCT c.intitule')
            ->orderBy('c.intitule', 'ASC')
            ->getQuery()
            ->getSingleColumnResult();

        $form = $this->createForm(ChirurgieType::class, $chirurgie, [
            'intitules_existants' => array_combine($intitulesExistants, $intitulesExistants),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $intituleExistant = $form->get('intitule_existant')->getData();

            if ($intituleExistant) {
                $chirurgie->setIntitule($intituleExistant);
            }

            $em->flush();

            return $this->redirectToRoute('chirurgie_index');
        }

        return $this->render('chirurgie/edit.html.twig', [
            'chirurgie' => $chirurgie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'chirurgie_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Chirurgie $chirurgie,
        EntityManagerInterface $em
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $chirurgie->getId(), $request->request->get('_token'))) {
            $em->remove($chirurgie);
            $em->flush();
        }

        return $this->redirectToRoute('chirurgie_index');
    }
}
