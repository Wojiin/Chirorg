<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Form\MaterielType;
use App\Repository\MaterielRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/materiel')]
class MaterielController extends AbstractController
{
    #[Route('/', name: 'materiel_index', methods: ['GET'])]
    public function index(MaterielRepository $repo): Response
    {
        # Récupère les matériels regroupés par spécialité via une méthode personnalisée du repository
        # findGroupedBySpecialite() doit retourner une structure exploitable par le template Twig
        $materielsGrouped = $repo->findGroupedBySpecialite();

        # Envoie les matériels au template Twig pour affichage
        return $this->render('materiel/index.html.twig', [
            'materiels' => $materielsGrouped,
        ]);
    }

    #[Route('/new', name: 'materiel_new', methods: ['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        # Crée une nouvelle instance vide de Materiel
        $materiel = new Materiel();

        # Crée le formulaire lié à l'entité Materiel
        $form = $this->createForm(MaterielType::class, $materiel);

        # Associe la requête HTTP au formulaire (récupère les données POST si soumission)
        $form->handleRequest($request);

        # Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            # Prépare l'enregistrement du nouveau matériel en base
            $em->persist($materiel);

            # Exécute l'insertion en base
            $em->flush();

            # Redirige vers la liste des matériels après création
            return $this->redirectToRoute('materiel_index');
        }

        # Affiche le formulaire (GET ou formulaire invalide)
        return $this->render('materiel/new.html.twig', [
            'materiel' => $materiel,
            # createView() est nécessaire pour afficher le formulaire dans Twig
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'materiel_show', methods: ['GET'])]
    public function show(Materiel $materiel): Response
    {
        # Affiche le détail d'un matériel (Symfony injecte l'entité via l'id dans l'URL)
        return $this->render('materiel/show.html.twig', [
            'materiel' => $materiel,
        ]);
    }

    #[Route('/{id}/edit', name: 'materiel_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Materiel $materiel, EntityManagerInterface $em): Response
    {
        # Crée le formulaire d'édition pré-rempli avec les données du matériel existant
        $form = $this->createForm(MaterielType::class, $materiel);

        # Associe la requête HTTP au formulaire
        $form->handleRequest($request);

        # Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            # flush() suffit car l'entité est déjà gérée par Doctrine (pas besoin de persist)
            $em->flush();

            # Redirige vers la liste des matériels après modification
            return $this->redirectToRoute('materiel_index');
        }

        # Affiche le formulaire d'édition (GET ou formulaire invalide)
        return $this->render('materiel/edit.html.twig', [
            'materiel' => $materiel,
            # createView() est nécessaire pour afficher le formulaire dans Twig
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'materiel_delete', methods: ['POST'])]
    public function delete(Request $request, Materiel $materiel, EntityManagerInterface $em): Response
    {
        # Vérifie le token CSRF pour sécuriser l'action de suppression
        if ($this->isCsrfTokenValid('delete' . $materiel->getId(), $request->request->get('_token'))) {
            # Marque le matériel pour suppression
            $em->remove($materiel);

            # Exécute la suppression en base
            $em->flush();
        }

        # Redirige vers la liste après suppression (même si token invalide)
        return $this->redirectToRoute('materiel_index');
    }
}
