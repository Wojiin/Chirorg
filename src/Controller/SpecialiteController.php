<?php

namespace App\Controller;

use App\Entity\Specialite;
use App\Form\SpecialiteType;
use App\Repository\SpecialiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/specialite')]
class SpecialiteController extends AbstractController
{
    #[Route('/', name: 'specialite_index', methods: ['GET'])]
    public function index(SpecialiteRepository $repo): Response
    {
        # Récupère toutes les spécialités depuis la base via le repository
        $specialites = $repo->findAll();

        # Envoie la liste des spécialités au template Twig pour affichage
        return $this->render('specialite/index.html.twig', [
            'specialites' => $specialites,
        ]);
    }

    #[Route('/new', name: 'specialite_new', methods: ['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        # Crée une nouvelle instance vide de Specialite
        $specialite = new Specialite();

        # Crée le formulaire lié à l'entité Specialite
        $form = $this->createForm(SpecialiteType::class, $specialite);

        # Associe la requête HTTP au formulaire (récupère les données POST si soumission)
        $form->handleRequest($request);

        # Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            # Prépare l'enregistrement de la spécialité en base
            $em->persist($specialite);

            # Exécute l'insertion en base
            $em->flush();

            # Redirige vers la liste des spécialités après création
            return $this->redirectToRoute('specialite_index');
        }

        # Affiche le formulaire (GET ou formulaire invalide)
        return $this->render('specialite/new.html.twig', [
            'specialite' => $specialite,
            # createView() est nécessaire pour afficher le formulaire dans Twig
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'specialite_show', methods: ['GET'])]
    public function show(Specialite $specialite): Response
    {
        # Affiche le détail d'une spécialité (Symfony injecte l'entité via l'id dans l'URL)
        return $this->render('specialite/show.html.twig', [
            'specialite' => $specialite,
        ]);
    }

    #[Route('/{id}/edit', name: 'specialite_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Specialite $specialite, EntityManagerInterface $em): Response
    {
        # Crée le formulaire d'édition pré-rempli avec les données de la spécialité existante
        $form = $this->createForm(SpecialiteType::class, $specialite);

        # Associe la requête HTTP au formulaire
        $form->handleRequest($request);

        # Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            # flush() suffit car l'entité est déjà gérée par Doctrine (pas besoin de persist)
            $em->flush();

            # Redirige vers la liste des spécialités après modification
            return $this->redirectToRoute('specialite_index');
        }

        # Affiche le formulaire d'édition (GET ou formulaire invalide)
        return $this->render('specialite/edit.html.twig', [
            'specialite' => $specialite,
            # createView() est nécessaire pour afficher le formulaire dans Twig
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'specialite_delete', methods: ['POST'])]
    public function delete(Request $request, Specialite $specialite, EntityManagerInterface $em): Response
    {
        # Vérifie le token CSRF pour sécuriser l'action de suppression
        if ($this->isCsrfTokenValid('delete'.$specialite->getId(), $request->request->get('_token'))) {
            # Marque la spécialité pour suppression
            $em->remove($specialite);

            # Exécute la suppression en base
            $em->flush();
        }

        # Redirige vers la liste après suppression (même si token invalide)
        return $this->redirectToRoute('specialite_index');
    }
}
