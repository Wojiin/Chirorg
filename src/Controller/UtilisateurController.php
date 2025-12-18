<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/utilisateur')]
class UtilisateurController extends AbstractController
{
    #[Route('/', name: 'utilisateur_index', methods: ['GET'])]
    public function index(UtilisateurRepository $repo): Response
    {
        # Récupère tous les utilisateurs depuis la base via le repository
        $utilisateurs = $repo->findAll();

        # Envoie la liste des utilisateurs au template Twig pour affichage
        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurs,
        ]);
    }

    #[Route('/new', name: 'utilisateur_new', methods: ['GET','POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        # Crée une nouvelle instance vide de Utilisateur
        $utilisateur = new Utilisateur();

        # Crée le formulaire de création et passe une option pour adapter le formulaire (mode création)
        $form = $this->createForm(UtilisateurType::class, $utilisateur, [
            'is_edit' => false,
        ]);

        # Associe la requête HTTP au formulaire (récupère les données POST si soumission)
        $form->handleRequest($request);

        # Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {

            # Récupère le mot de passe en clair depuis le champ du formulaire
            $plainPassword = $form->get('plainPassword')->getData();

            # Vérifie qu'un mot de passe a bien été saisi
            if ($plainPassword) {
                # Hash le mot de passe puis l'enregistre dans l'entité (jamais de stockage en clair)
                $utilisateur->setPassword(
                    $passwordHasher->hashPassword($utilisateur, $plainPassword)
                );
            }

            # Prépare l'enregistrement de l'utilisateur en base
            $em->persist($utilisateur);

            # Exécute l'insertion en base
            $em->flush();

            # Redirige vers la liste des utilisateurs après création
            return $this->redirectToRoute('utilisateur_index');
        }

        # Affiche le formulaire (GET ou formulaire invalide)
        return $this->render('utilisateur/new.html.twig', [
            'utilisateur' => $utilisateur,
            # createView() est nécessaire pour afficher le formulaire dans Twig
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'utilisateur_show', methods: ['GET'])]
    public function show(Utilisateur $utilisateur): Response
    {
        # Affiche le détail d'un utilisateur (Symfony injecte l'entité via l'id dans l'URL)
        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    #[Route('/{id}/edit', name: 'utilisateur_edit', methods: ['GET','POST'])]
    public function edit(
        Request $request,
        Utilisateur $utilisateur,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        # Crée le formulaire d'édition et passe une option pour adapter le formulaire (mode édition)
        $form = $this->createForm(UtilisateurType::class, $utilisateur, [
            'is_edit' => true,
        ]);

        # Associe la requête HTTP au formulaire
        $form->handleRequest($request);

        # Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {

            # Récupère le mot de passe en clair depuis le champ du formulaire
            $plainPassword = $form->get('plainPassword')->getData();

            # Vérifie si un nouveau mot de passe a été saisi
            # Si le champ est vide, on ne modifie pas le mot de passe existant
            if ($plainPassword) {
                # Hash le nouveau mot de passe puis l'enregistre dans l'entité
                $utilisateur->setPassword(
                    $passwordHasher->hashPassword($utilisateur, $plainPassword)
                );
            }

            # Enregistre les modifications en base
            $em->flush();

            # Redirige vers la liste des utilisateurs après modification
            return $this->redirectToRoute('utilisateur_index');
        }

        # Affiche le formulaire d'édition (GET ou formulaire invalide)
        return $this->render('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            # createView() est nécessaire pour afficher le formulaire dans Twig
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'utilisateur_delete', methods: ['POST'])]
    public function delete(Request $request, Utilisateur $utilisateur, EntityManagerInterface $em): Response
    {
        # Vérifie le token CSRF pour sécuriser l'action de suppression
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->request->get('_token'))) {
            # Marque l'utilisateur pour suppression
            $em->remove($utilisateur);

            # Exécute la suppression en base
            $em->flush();
        }

        # Redirige vers la liste après suppression (même si token invalide)
        return $this->redirectToRoute('utilisateur_index');
    }
}
