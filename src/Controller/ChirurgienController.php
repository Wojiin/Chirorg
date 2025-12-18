<?php

namespace App\Controller;

use App\Entity\Chirurgien;
use App\Form\ChirurgienType;
use App\Repository\ChirurgienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/chirurgien')]
class ChirurgienController extends AbstractController
{
    #[Route('/', name: 'chirurgien_index', methods: ['GET'])]
    public function index(ChirurgienRepository $repo): Response
    {
        # Récupère tous les chirurgiens depuis la base de données via le repository
        $chirurgiens = $repo->findAll();

        # Envoie la liste des chirurgiens au template Twig pour affichage
        return $this->render('chirurgien/index.html.twig', [
            'chirurgiens' => $chirurgiens,
        ]);
    }

    #[Route('/new', name: 'chirurgien_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        # Crée une nouvelle instance vide de Chirurgien
        $chirurgien = new Chirurgien();

        # Crée le formulaire lié à l'entité Chirurgien
        $form = $this->createForm(ChirurgienType::class, $chirurgien);

        # Associe la requête HTTP au formulaire (récupère les données POST si le formulaire est soumis)
        $form->handleRequest($request);

        # Vérifie si le formulaire est soumis et que les données sont valides
        if ($form->isSubmitted() && $form->isValid()) {
            # Prépare l'enregistrement du nouveau chirurgien en base
            $em->persist($chirurgien);
            # Exécute l'insertion en base de données
            $em->flush();

            # Redirige vers la liste des chirurgiens après création
            return $this->redirectToRoute('chirurgien_index');
        }

        # Affiche le formulaire (GET ou formulaire invalide)
        return $this->render('chirurgien/new.html.twig', [
            'chirurgien' => $chirurgien,
            # createView() est nécessaire pour afficher le formulaire dans Twig
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'chirurgien_show', methods: ['GET'])]
    public function show(Chirurgien $chirurgien): Response
    {
        # Affiche le détail d'un chirurgien (Symfony injecte l'entité grâce à l'id dans l'URL)
        return $this->render('chirurgien/show.html.twig', [
            'chirurgien' => $chirurgien,
        ]);
    }

    #[Route('/{id}/edit', name: 'chirurgien_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chirurgien $chirurgien, EntityManagerInterface $em): Response
    {
        # Crée le formulaire pré-rempli avec les données du chirurgien existant
        $form = $this->createForm(ChirurgienType::class, $chirurgien);

        # Associe la requête HTTP au formulaire
        $form->handleRequest($request);

        # Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            # flush() suffit car l'entité est déjà gérée par Doctrine (pas besoin de persist)
            $em->flush();

            # Redirige vers la liste des chirurgiens après modification
            return $this->redirectToRoute('chirurgien_index');
        }

        # Affiche le formulaire d'édition (GET ou formulaire invalide)
        return $this->render('chirurgien/edit.html.twig', [
            'chirurgien' => $chirurgien,
            # createView() est nécessaire pour afficher le formulaire dans Twig
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'chirurgien_delete', methods: ['POST'])]
    public function delete(Request $request, Chirurgien $chirurgien, EntityManagerInterface $em): Response
    {
        # Vérifie le token CSRF pour sécuriser l'action de suppression
        if ($this->isCsrfTokenValid('delete' . $chirurgien->getId(), $request->request->get('_token'))) {
            # Marque le chirurgien pour suppression
            $em->remove($chirurgien);
            # Exécute la suppression en base de données
            $em->flush();
        }

        # Redirige vers la liste après la suppression (même si le token est invalide)
        return $this->redirectToRoute('chirurgien_index');
    }
}
