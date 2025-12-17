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
        $builder
            ->add('intitule', TextType::class)
            ->add('chirurgien', EntityType::class, [
                'class' => Chirurgien::class,
                'choice_label' => fn (Chirurgien $c) =>
                    $c->getPrenom().' '.$c->getNom(),
                'placeholder' => '— Choisir un chirurgien —'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ListeMateriel::class,
        ]);
    }
}
