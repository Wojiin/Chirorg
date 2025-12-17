<?php

namespace App\Form;

use App\Entity\Materiel;
use App\Entity\Specialite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterielType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('type')
            ->add('adresse')
            ->add('specialite', EntityType::class, [
                'class' => Specialite::class,
                'choice_label' => 'intitule',
                'required' => false,
                'placeholder' => 'Sélectionner une spécialité',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Materiel::class,
        ]);
    }
}
