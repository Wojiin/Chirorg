<?php

namespace App\Form;

use App\Entity\ListeMateriel;
use App\Entity\Chirurgien;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ListeMaterielType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        # Construit les champs du formulaire ListeMateriel
        $builder
            # Champ texte pour l'intitulé de la liste de matériel
            ->add('intitule', TextType::class)

            # Champ relationnel pour sélectionner un chirurgien (chargé depuis la base)
            ->add('chirurgien', EntityType::class, [
                # Entité utilisée pour alimenter la liste déroulante
                'class' => Chirurgien::class,

                # Définit l'affichage de chaque choix (prenom + nom)
                'choice_label' => fn (Chirurgien $c) =>
                    $c->getPrenom().' '.$c->getNom(),

                # Texte affiché tant qu'aucun chirurgien n'est sélectionné
                'placeholder' => '— Choisir un chirurgien —'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        # Configure les options par défaut du formulaire
        $resolver->setDefaults([
            # Lie ce formulaire à la classe ListeMateriel (mapping automatique des champs)
            'data_class' => ListeMateriel::class,
        ]);
    }
}
