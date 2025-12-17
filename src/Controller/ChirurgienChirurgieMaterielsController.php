<?php

namespace App\Controller;

use App\Entity\Chirurgien;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ChirurgienChirurgieMateriel;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ChirurgienChirurgieMaterielsType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/chirurgien/chirurgie/materiels')]
class ChirurgienChirurgieMaterielsController extends AbstractController
{
    // =====================================================
    // Index
    // =====================================================
    #[Route('/', name: 'app_chirurgien_chirurgie_materiels', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $chirurgiens = $em->getRepository(Chirurgien::class)
            ->createQueryBuilder('c')
            ->leftJoin('c.chirurgienChirurgieMateriels', 'ccm')
            ->leftJoin('ccm.chirurgie', 'chirurgie')
            ->leftJoin('ccm.materiel', 'materiel')
            ->addSelect('ccm, chirurgie, materiel')
            ->getQuery()
            ->getResult();

        $data = [];
        foreach ($chirurgiens as $chirurgien) {
            $listeParChirurgie = [];
            foreach ($chirurgien->getChirurgienChirurgieMateriels() as $ccm) {
                $chirurgie = $ccm->getChirurgie();
                $materiel = $ccm->getMateriel();
                if ($chirurgie && $materiel) {
                    $nomChirurgie = $chirurgie->getIntitule();
                    $listeParChirurgie[$nomChirurgie][] = [
                        'id' => $ccm->getId(),
                        'materiel_nom' => $materiel->getNom(),
                        'materiel_adresse' => $materiel->getAdresse(),
                    ];
                }
            }
            $data[] = [
                'chirurgien_id' => $chirurgien->getId(),
                'chirurgien_nom' => $chirurgien->getNom(),
                'chirurgien_prenom' => $chirurgien->getPrenom(),
                'chirurgien_specialite' => $chirurgien->getSpecialiser()?->getIntitule(),
                'chirurgies' => $listeParChirurgie,
            ];
        }

        return $this->render('chirurgien_chirurgie_materiels/index.html.twig', [
            'data' => $data,
        ]);
    }

    // =====================================================
    // Ajouter
    // =====================================================
    #[Route('/new', name: 'app_chirurgien_chirurgie_materiels_new', methods: ['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $ccm = new ChirurgienChirurgieMateriel();
        $form = $this->createForm(ChirurgienChirurgieMaterielsType::class, $ccm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($ccm);
            $em->flush();
            $this->addFlash('success', 'Association ajoutée avec succès !');
            return $this->redirectToRoute('app_chirurgien_chirurgie_materiels');
        }

        return $this->render('chirurgien_chirurgie_materiels/new.html.twig', [
            'ccm' => $ccm,
            'form' => $form->createView(),
        ]);
    }

    // =====================================================
    // Modifier
    // =====================================================
    #[Route('/{id}/edit', name: 'app_chirurgien_chirurgie_materiels_edit', methods: ['GET','POST'])]
    public function edit(Request $request, ChirurgienChirurgieMateriel $ccm, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ChirurgienChirurgieMaterielsType::class, $ccm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Association modifiée avec succès !');
            return $this->redirectToRoute('app_chirurgien_chirurgie_materiels');
        }

        return $this->render('chirurgien_chirurgie_materiels/edit.html.twig', [
            'ccm' => $ccm,
            'form' => $form->createView(),
        ]);
    }

    // =====================================================
    // Supprimer
    // =====================================================
    #[Route('/{id}/delete', name: 'app_chirurgien_chirurgie_materiels_delete', methods: ['POST'])]
    public function delete(Request $request, ChirurgienChirurgieMateriel $ccm, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ccm->getId(), $request->request->get('_token'))) {
            $em->remove($ccm);
            $em->flush();
            $this->addFlash('success', 'Association supprimée avec succès !');
        }

        return $this->redirectToRoute('app_chirurgien_chirurgie_materiels');
    }
}
