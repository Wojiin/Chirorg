<?php

namespace App\Form;

use App\Entity\Chirurgie;
use App\Entity\ProgrammeOperatoire;
use App\Entity\Specialite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChirurgieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intitule')
            ->add('ficheTechnique')
            ->add('specialite', EntityType::class, [
                'class' => Specialite::class,
                'choice_label' => 'intitule',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chirurgie::class,
        ]);
    }
}
