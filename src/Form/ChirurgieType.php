<?php

namespace App\Form;

use App\Entity\Chirurgie;
use App\Entity\Chirurgien;
use App\Entity\ListeMateriel;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChirurgieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // 🔹 Intitulé existant
            ->add('intitule_existant', ChoiceType::class, [
                'label' => 'Intitulé existant',
                'mapped' => false,
                'required' => false,
                'choices' => $options['intitules_existants'],
                'placeholder' => '— Choisir un intitulé existant —'
            ])

            // 🔹 Nouvel intitulé
            ->add('intitule', TextType::class, [
                'label' => 'Nouvel intitulé',
                'required' => false
            ])

            ->add('fiche_technique', TextareaType::class)
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('salle', TextType::class)
            ->add('valide', CheckboxType::class, [
                'required' => false
            ])

            ->add('utilisateur', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => fn (Utilisateur $u) =>
                    $u->getPrenom().' '.$u->getNom(),
                'placeholder' => '— Choisir un utilisateur —'
            ])

            ->add('operer', EntityType::class, [
                'class' => Chirurgien::class,
                'choice_label' => fn (Chirurgien $c) =>
                    $c->getPrenom().' '.$c->getNom(),
                'placeholder' => '— Choisir un chirurgien —'
            ])

            ->add('outiller', EntityType::class, [
                'class' => ListeMateriel::class,
                'choice_label' => 'intitule',
                'placeholder' => '— Choisir une liste de matériel —'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chirurgie::class,
            'intitules_existants' => [],
        ]);
    }
}
