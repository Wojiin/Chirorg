<?php

namespace App\Form;

use App\Entity\Chirurgie;
use App\Entity\Chirurgien;
use App\Entity\ListeMateriel;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChirurgieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        # Construit les champs du formulaire Chirurgie
        $builder
            # Champ permettant de sélectionner un intitulé déjà existant
            # mapped => false signifie que ce champ n'est pas automatiquement enregistré dans l'entité Chirurgie
            ->add('intitule_existant', ChoiceType::class, [
                # Libellé affiché pour le champ
                'label' => 'Intitulé existant',

                # Indique que le champ n'est pas lié directement à une propriété de l'entité
                'mapped' => false,

                # Champ optionnel (l'utilisateur peut ne rien choisir)
                'required' => false,

                # Liste des choix fournie par le contrôleur via l'option intitules_existants
                'choices' => $options['intitules_existants'],

                # Texte affiché tant qu'aucun choix n'est sélectionné
                'placeholder' => '— Choisir un intitulé existant —'
            ])

            # Champ texte pour saisir un nouvel intitulé
            # Champ optionnel car on peut soit choisir un intitulé existant, soit en saisir un nouveau
            ->add('intitule', TextType::class, [
                # Libellé affiché pour le champ
                'label' => 'Nouvel intitulé',

                # Rend le champ non obligatoire
                'required' => false
            ])

            # Champ texte long pour la fiche technique de la chirurgie
            ->add('fiche_technique', TextareaType::class)

            # Champ date/heure de la chirurgie
            # widget single_text affiche un input HTML5 de type datetime-local
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text'
            ])

            # Champ texte pour la salle
            ->add('salle', TextType::class)

            # Case à cocher pour indiquer si la chirurgie est validée
            # required => false permet de laisser la case décochée sans erreur de validation
            ->add('valide', CheckboxType::class, [
                'required' => false
            ])

            # Champ relationnel pour sélectionner un utilisateur (EntityType charge les données depuis la base)
            ->add('utilisateur', EntityType::class, [
                # Entité utilisée pour construire la liste
                'class' => Utilisateur::class,

                # Définit l'affichage de chaque choix (prenom + nom)
                'choice_label' => fn (Utilisateur $u) =>
                    $u->getPrenom().' '.$u->getNom(),

                # Texte affiché tant qu'aucun utilisateur n'est sélectionné
                'placeholder' => '— Choisir un utilisateur —'
            ])

            # Champ relationnel pour sélectionner un chirurgien
            ->add('operer', EntityType::class, [
                # Entité utilisée pour construire la liste
                'class' => Chirurgien::class,

                # Définit l'affichage de chaque choix (prenom + nom)
                'choice_label' => fn (Chirurgien $c) =>
                    $c->getPrenom().' '.$c->getNom(),

                # Texte affiché tant qu'aucun chirurgien n'est sélectionné
                'placeholder' => '— Choisir un chirurgien —'
            ])

            # Champ relationnel pour sélectionner une liste de matériel
            ->add('outiller', EntityType::class, [
                # Entité utilisée pour construire la liste
                'class' => ListeMateriel::class,

                # Attribut affiché dans la liste déroulante
                'choice_label' => 'intitule',

                # Texte affiché tant qu'aucune liste n'est sélectionnée
                'placeholder' => '— Choisir une liste de matériel —'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        # Configure les options par défaut du formulaire
        $resolver->setDefaults([
            # Lie ce formulaire à la classe Chirurgie (mapping automatique des champs)
            'data_class' => Chirurgie::class,

            # Option personnalisée utilisée pour alimenter le champ "intitule_existant"
            # Elle est fournie depuis le contrôleur lors du createForm(...)
            'intitules_existants' => [],
        ]);
    }
}
