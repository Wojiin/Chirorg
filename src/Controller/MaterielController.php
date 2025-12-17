<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Form\MaterielType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/materiel')]
class MaterielController extends AbstractController
{
    #[Route('/', name: 'app_materiel', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $materiels = $em->getRepository(Materiel::class)
            ->createQueryBuilder('m')
            ->leftJoin('m.specialite', 's')
            ->addSelect('s')
            ->orderBy('s.intitule', 'ASC')
            ->addOrderBy('m.nom', 'ASC')
            ->getQuery()
            ->getResult();

        $materielsParSpecialite = [];
        foreach ($materiels as $materiel) {
            $nomSpecialite = $materiel->getSpecialite()?->getIntitule() ?? '—';
            $materielsParSpecialite[$nomSpecialite][] = $materiel;
        }

        return $this->render('materiel/index.html.twig', [
            'materielsParSpecialite' => $materielsParSpecialite,
        ]);
    }

    #[Route('/new', name: 'materiel_new', methods: ['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $materiel = new Materiel();
        $form = $this->createForm(MaterielType::class, $materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($materiel);
            $em->flush();
            $this->addFlash('success', 'Matériel ajouté avec succès !');
            return $this->redirectToRoute('app_materiel');
        }

        return $this->render('materiel/new.html.twig', [
            'materiel' => $materiel,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'materiel_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Materiel $materiel, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(MaterielType::class, $materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Matériel modifié avec succès !');
            return $this->redirectToRoute('app_materiel');
        }

        return $this->render('materiel/edit.html.twig', [
            'materiel' => $materiel,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/delete', name: 'materiel_delete', methods: ['POST'])]
    public function delete(Request $request, Materiel $materiel, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$materiel->getId(), $request->request->get('_token'))) {
            $em->remove($materiel);
            $em->flush();
            $this->addFlash('success', 'Matériel supprimé avec succès !');
        }

        return $this->redirectToRoute('app_materiel');
    }
}
