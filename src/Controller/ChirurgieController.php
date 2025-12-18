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
        # Récupère toutes les chirurgies depuis la base de données
        $chirurgies = $chirurgieRepository->findAll();

        # Tableau final qui contiendra les données regroupées par spécialité > chirurgien > salle
        $grouped = [];

        # Parcourt toutes les chirurgies une par une
        foreach ($chirurgies as $chirurgie) {

            # Récupère le chirurgien associé à la chirurgie (relation "operer")
            $chirurgienEntity = $chirurgie->getOperer();

            # Récupère la spécialité du chirurgien (relation "specialiser")
            # L'opérateur ?-> évite une erreur si $chirurgienEntity vaut null
            $specialiteEntity = $chirurgienEntity?->getSpecialiser();

            # Vérifie que le chirurgien ET la spécialité existent avant de continuer
            # Si l'un des deux est null, on ignore cette chirurgie (continue passe au tour suivant)
            if (!$chirurgienEntity || !$specialiteEntity) {
                continue;
            }

            # Récupère l'id de la spécialité pour l'utiliser comme clé de regroupement
            $specialiteId = $specialiteEntity->getId();

            # Récupère le libellé (intitulé) de la spécialité pour l'affichage
            $specialiteLabel = $specialiteEntity->getIntitule();

            # Récupère l'id du chirurgien pour l'utiliser comme clé de regroupement
            $chirurgienId = $chirurgienEntity->getId();

            # Construit le nom complet du chirurgien pour l'affichage
            $chirurgienLabel = $chirurgienEntity->getPrenom().' '.$chirurgienEntity->getNom();

            # Récupère la salle liée à la chirurgie, ou met une valeur par défaut si elle est absente
            $salle = $chirurgie->getSalle() ?? 'Salle inconnue';

            # Vérifie si la spécialité n'existe pas encore dans $grouped
            # !isset(...) permet de savoir si la clé n'a pas encore été créée
            if (!isset($grouped[$specialiteId])) {
                # Crée l'entrée de la spécialité avec son label et un tableau vide de chirurgiens
                $grouped[$specialiteId] = [
                    'label' => $specialiteLabel,
                    'chirurgiens' => [],
                ];
            }

            # Vérifie si le chirurgien n'existe pas encore dans cette spécialité
            # Si absent, on l'initialise avec son label et un tableau vide de salles
            if (!isset($grouped[$specialiteId]['chirurgiens'][$chirurgienId])) {
                $grouped[$specialiteId]['chirurgiens'][$chirurgienId] = [
                    'label' => $chirurgienLabel,
                    'salles' => [],
                ];
            }

            # Vérifie si la salle n'existe pas encore pour ce chirurgien
            # Si absent, on initialise la salle avec un tableau vide de chirurgies
            if (!isset($grouped[$specialiteId]['chirurgiens'][$chirurgienId]['salles'][$salle])) {
                $grouped[$specialiteId]['chirurgiens'][$chirurgienId]['salles'][$salle] = [];
            }

            # Ajoute la chirurgie courante dans la salle correspondante
            $grouped[$specialiteId]['chirurgiens'][$chirurgienId]['salles'][$salle][] = $chirurgie;
        }

        # Envoie le tableau regroupé au template Twig
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
        # Crée une nouvelle instance vide de Chirurgie
        $chirurgie = new Chirurgie();

        # Récupère la liste des intitulés existants (distincts) pour proposer un choix dans le formulaire
        $intitulesExistants = $chirurgieRepository
            ->createQueryBuilder('c')
            ->select('DISTINCT c.intitule')
            ->orderBy('c.intitule', 'ASC')
            ->getQuery()
            ->getSingleColumnResult();

        # Crée le formulaire en lui passant la liste des intitulés existants (clé => valeur)
        $form = $this->createForm(ChirurgieType::class, $chirurgie, [
            'intitules_existants' => array_combine($intitulesExistants, $intitulesExistants),
        ]);

        # Associe la requête HTTP au formulaire (récupère les données POST si elles existent)
        $form->handleRequest($request);

        # Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {

            # Récupère l'intitulé sélectionné dans le champ "intitule_existant"
            $intituleExistant = $form->get('intitule_existant')->getData();

            # Si un intitulé existant a été choisi, on l'applique à l'entité
            if ($intituleExistant) {
                $chirurgie->setIntitule($intituleExistant);
            }

            # Prépare l'enregistrement en base
            $em->persist($chirurgie);
            # Exécute l'insertion en base
            $em->flush();

            # Redirige vers la page de liste
            return $this->redirectToRoute('chirurgie_index');
        }

        # Affiche le formulaire (GET ou formulaire invalide)
        return $this->render('chirurgie/new.html.twig', [
            'chirurgie' => $chirurgie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'chirurgie_show', methods: ['GET'])]
    public function show(Chirurgie $chirurgie): Response
    {
        # Affiche le détail d'une chirurgie
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
        # Récupère la liste des intitulés existants (distincts) pour proposer un choix dans le formulaire
        $intitulesExistants = $chirurgieRepository
            ->createQueryBuilder('c')
            ->select('DISTINCT c.intitule')
            ->orderBy('c.intitule', 'ASC')
            ->getQuery()
            ->getSingleColumnResult();

        # Crée le formulaire d'édition avec la même logique de choix d'intitulés
        $form = $this->createForm(ChirurgieType::class, $chirurgie, [
            'intitules_existants' => array_combine($intitulesExistants, $intitulesExistants),
        ]);

        # Récupère les données envoyées si le formulaire est soumis
        $form->handleRequest($request);

        # Vérifie si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {

            # Récupère l'intitulé existant éventuellement sélectionné
            $intituleExistant = $form->get('intitule_existant')->getData();

            # Si un intitulé existant est choisi, on le force dans l'entité
            if ($intituleExistant) {
                $chirurgie->setIntitule($intituleExistant);
            }

            # Enregistre les modifications en base (pas besoin de persist car l'entité est déjà gérée)
            $em->flush();

            # Redirige vers la liste
            return $this->redirectToRoute('chirurgie_index');
        }

        # Affiche le formulaire d'édition
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
        # Vérifie le token CSRF pour sécuriser la suppression
        if ($this->isCsrfTokenValid('delete' . $chirurgie->getId(), $request->request->get('_token'))) {
            # Marque l'entité pour suppression
            $em->remove($chirurgie);
            # Exécute la suppression en base
            $em->flush();
        }

        # Redirige vers la liste après la suppression
        return $this->redirectToRoute('chirurgie_index');
    }
}
