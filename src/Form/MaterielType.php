<?php

namespace App\Form;

use App\Entity\ListeMateriel;
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
            ->add('intitule')
            ->add('type')
            ->add('adresse')
            ->add('classer', EntityType::class, [
                'class' => Specialite::class,
                'choice_label' => 'id',
            ])
            ->add('lister', EntityType::class, [
                'class' => ListeMateriel::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Materiel::class,
        ]);
    }
}
