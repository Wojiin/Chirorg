<?php

namespace App\Form;

use App\Entity\Materiel;
use App\Entity\ListeMateriel;
use App\Entity\Specialite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterielType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        # Construit les champs du formulaire Materiel
        $builder
            # Champ texte pour l'intitulé du matériel
            ->add('intitule', TextType::class, [
                # Libellé affiché à côté du champ
                'label' => 'Intitulé',
            ])

            # Champ texte pour le type de matériel (ex: instrument, consommable, appareil)
            ->add('type', TextType::class, [
                # Libellé affiché à côté du champ
                'label' => 'Type',

                # Texte d'aide affiché sous le champ
                'help' => 'Ex: Instrument, Consommable, Appareil...',
            ])

            # Champ texte pour indiquer l'emplacement / l'adresse de stockage
            ->add('adresse', TextType::class, [
                # Libellé affiché à côté du champ
                'label' => 'Adresse',

                # Texte d'aide affiché sous le champ
                'help' => 'Ex: Armoire A3, Stock bloc...',
            ])

            # Champ relationnel pour associer une spécialité (optionnel)
            ->add('classer', EntityType::class, [
                # Entité utilisée pour alimenter la liste déroulante
                'class' => Specialite::class,

                # Attribut affiché dans la liste
                'choice_label' => 'intitule',

                # Texte affiché tant qu'aucune spécialité n'est choisie
                'placeholder' => '— Choisir une spécialité —',

                # Rend le champ optionnel
                'required' => false,

                # Libellé affiché à côté du champ
                'label' => 'Spécialité',
            ])

            # Champ relationnel pour associer le matériel à une ou plusieurs listes de matériel
            ->add('lister', EntityType::class, [
                # Entité utilisée pour alimenter la liste
                'class' => ListeMateriel::class,

                # Attribut affiché dans la liste
                'choice_label' => 'intitule',

                # multiple => true permet de sélectionner plusieurs valeurs
                'multiple' => true,

                # Rend le champ optionnel
                'required' => false,

                # Libellé affiché à côté du champ
                'label' => 'Listes de matériel',

                # Texte d'aide affiché sous le champ
                'help' => 'Tu peux sélectionner plusieurs listes (Ctrl/Cmd + clic).',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        # Configure les options par défaut du formulaire
        $resolver->setDefaults([
            # Lie ce formulaire à la classe Materiel (mapping automatique des champs)
            'data_class' => Materiel::class,
        ]);
    }
}
