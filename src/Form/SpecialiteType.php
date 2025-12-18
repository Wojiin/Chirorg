<?php

namespace App\Form;

use App\Entity\Specialite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecialiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        # Construit les champs du formulaire Specialite
        $builder
            # Champ texte pour l'intitulé de la spécialité
            ->add('intitule', TextType::class, [
                # Libellé affiché à côté du champ
                'label' => 'Intitulé',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        # Configure les options par défaut du formulaire
        $resolver->setDefaults([
            # Lie ce formulaire à la classe Specialite (mapping automatique des champs)
            'data_class' => Specialite::class,
        ]);
    }
}
