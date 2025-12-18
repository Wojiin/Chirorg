<?php

namespace App\Controller;

use App\Entity\ListeMateriel;
use App\Entity\Materiel;
use App\Form\ListeMaterielType;
use App\Repository\ListeMaterielRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/liste-materiel')]
class ListeMaterielController extends AbstractController
{
    #[Route('/', name: 'liste_materiel_index', methods: ['GET'])]
    public function index(ListeMaterielRepository $repo): Response
    {
        # Récupère toutes les listes de matériel depuis la base via le repository
        $listes = $repo->findAll();

        # Envoie les listes au template Twig pour affichage
        return $this->render('liste_materiel/index.html.twig', [
            'listes' => $listes,
        ]);
    }

    #[Route('/new', name: 'liste_materiel_new', methods: ['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        # Crée une nouvelle instance vide de ListeMateriel
        $liste = new ListeMateriel();

        # Crée le formulaire lié à l'entité ListeMateriel
        $form = $this->createForm(ListeMaterielType::class, $liste);

        # Associe la requête HTTP au formulaire (récupère les données POST si soumission)
        $form->handleRequest($request);

        # Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {

            # Synchronise le owning side de la relation (Materiel) avec la liste courante
            # Utile si la relation ManyToMany est pilotée côté Materiel (addLister/removeLister)
            $this->syncMaterielsOwningSide($liste);

            # Prépare l'enregistrement de la liste en base
            $em->persist($liste);

            # Exécute l'insertion en base
            $em->flush();

            # Redirige vers la page index après création
            return $this->redirectToRoute('liste_materiel_index');
        }

        # Affiche le formulaire (GET ou formulaire invalide)
        return $this->render('liste_materiel/new.html.twig', [
            'liste' => $liste,
            # createView() est nécessaire pour afficher le formulaire dans Twig
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'liste_materiel_show', methods: ['GET'])]
    public function show(ListeMateriel $liste): Response
    {
        # Affiche le détail d'une liste (Symfony injecte l'entité via l'id dans l'URL)
        return $this->render('liste_materiel/show.html.twig', [
            'liste' => $liste,
        ]);
    }

    #[Route('/{id}/edit', name: 'liste_materiel_edit', methods: ['GET','POST'])]
    public function edit(Request $request, ListeMateriel $liste, EntityManagerInterface $em): Response
    {
        # Conserve la liste des matériels avant modification pour détecter ceux qui ont été retirés
        $oldMateriels = [];

        # Parcourt les matériels actuellement associés à la liste (avant soumission du formulaire)
        foreach ($liste->getMateriels() as $m) {
            # Stocke chaque matériel par son id pour pouvoir le retrouver facilement ensuite
            $oldMateriels[$m->getId()] = $m;
        }

        # Crée le formulaire d'édition (pré-rempli avec les données existantes)
        $form = $this->createForm(ListeMaterielType::class, $liste);

        # Associe la requête au formulaire
        $form->handleRequest($request);

        # Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {

            # Parcourt les matériels d'origine pour repérer ceux qui ne sont plus dans la collection
            foreach ($oldMateriels as $id => $materiel) {
                # Si le matériel d'origine n'est plus présent après modification, il a été retiré
                if (!$liste->getMateriels()->contains($materiel)) {
                    # Nettoie le owning side en retirant la liste du matériel
                    $materiel->removeLister($liste);
                }
            }

            # Synchronise le owning side pour tous les matériels encore présents dans la liste
            $this->syncMaterielsOwningSide($liste);

            # Enregistre les modifications en base
            $em->flush();

            # Redirige vers l'index après édition
            return $this->redirectToRoute('liste_materiel_index');
        }

        # Affiche le formulaire d'édition (GET ou formulaire invalide)
        return $this->render('liste_materiel/edit.html.twig', [
            'liste' => $liste,
            # createView() est nécessaire pour afficher le formulaire dans Twig
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'liste_materiel_delete', methods: ['POST'])]
    public function delete(Request $request, ListeMateriel $liste, EntityManagerInterface $em): Response
    {
        # Vérifie le token CSRF pour sécuriser la suppression
        if ($this->isCsrfTokenValid('delete'.$liste->getId(), $request->request->get('_token'))) {

            # Nettoie le owning side avant suppression pour éviter des liens orphelins
            # Parcourt tous les matériels associés à la liste
            foreach ($liste->getMateriels() as $m) {
                # Retire la liste du matériel (mise à jour du owning side)
                $m->removeLister($liste);
            }

            # Marque la liste pour suppression
            $em->remove($liste);

            # Exécute la suppression en base
            $em->flush();
        }

        # Redirige vers l'index après suppression (même si token invalide)
        return $this->redirectToRoute('liste_materiel_index');
    }

    private function syncMaterielsOwningSide(ListeMateriel $liste): void
    {
        # Parcourt tous les matériels actuellement sélectionnés dans la liste
        foreach ($liste->getMateriels() as $materiel) {
            # Indique à l'IDE que $materiel est bien une instance de Materiel
            /** @var Materiel $materiel */

            # Ajoute la liste sur le owning side (Materiel) pour garder la relation cohérente
            $materiel->addLister($liste);
        }
    }
}
