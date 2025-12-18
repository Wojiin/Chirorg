<?php

namespace App\Form;

use App\Entity\Chirurgien;
use App\Entity\Specialite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChirurgienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        # Construit les champs du formulaire Chirurgien
        $builder
            # Champ texte pour le prénom du chirurgien
            ->add('prenom', TextType::class, [
                # Texte affiché à côté du champ dans le formulaire
                'label' => 'Prénom',
            ])

            # Champ texte pour le nom du chirurgien
            ->add('nom', TextType::class, [
                # Texte affiché à côté du champ dans le formulaire
                'label' => 'Nom',
            ])

            # Champ de type EntityType pour sélectionner une spécialité existante en base
            ->add('specialiser', EntityType::class, [
                # Indique quelle entité Doctrine est utilisée pour alimenter la liste de choix
                'class' => Specialite::class,

                # Définit quel attribut de Specialite sera affiché dans la liste déroulante
                'choice_label' => 'intitule',

                # Ajoute un choix par défaut vide en haut de la liste
                'placeholder' => '— Choisir une spécialité —',

                # Rend le champ optionnel (le chirurgien peut ne pas avoir de spécialité)
                'required' => false,

                # Libellé affiché à côté du champ
                'label' => 'Spécialité',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        # Configure les options par défaut du formulaire
        $resolver->setDefaults([
            # Lie ce formulaire à la classe Chirurgien (mapping automatique des champs)
            'data_class' => Chirurgien::class,
        ]);
    }
}
