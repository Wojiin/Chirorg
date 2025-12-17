<?php

namespace App\Form;

use App\Entity\ChirurgienChirurgieMateriel;
use App\Entity\Chirurgien;
use App\Entity\Chirurgie;
use App\Entity\Materiel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChirurgienChirurgieMaterielsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('chirurgien', EntityType::class, [
                'class' => Chirurgien::class,
                'choice_label' => fn($chirurgien) => $chirurgien->getNom() . ' ' . $chirurgien->getPrenom(),
            ])
            ->add('chirurgie', EntityType::class, [
                'class' => Chirurgie::class,
                'choice_label' => 'intitule',
            ])
            ->add('materiel', EntityType::class, [
                'class' => Materiel::class,
                'choice_label' => 'nom',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ChirurgienChirurgieMateriel::class,
        ]);
    }
}
