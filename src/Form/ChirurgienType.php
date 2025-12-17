<?php

namespace App\Form;

use App\Entity\Chirurgien;
use App\Entity\Specialite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChirurgienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('specialiser', EntityType::class, [
                'class' => Specialite::class,
                'choice_label' => 'intitule',
                'placeholder' => 'Sélectionner une spécialité',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chirurgien::class,
        ]);
    }
}
