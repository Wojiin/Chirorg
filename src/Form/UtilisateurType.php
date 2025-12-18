<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        # Construit les champs du formulaire Utilisateur
        $builder
            # Champ email pour l'adresse email de l'utilisateur
            ->add('email', EmailType::class)

            # Champ texte pour le prénom de l'utilisateur
            ->add('prenom', TextType::class)

            # Champ texte pour le nom de l'utilisateur
            ->add('nom', TextType::class)

            # Champ de choix pour les rôles de l'utilisateur
            ->add('roles', ChoiceType::class, [
                # Liste des rôles disponibles (libellé => valeur stockée)
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                ],

                # Autorise la sélection de plusieurs rôles
                'multiple' => true,

                # expanded => true affiche des cases à cocher au lieu d'une liste déroulante
                'expanded' => true,

                # Champ optionnel
                'required' => false,
            ])

            # Champ mot de passe non mappé directement à l'entité
            ->add('plainPassword', PasswordType::class, [
                # Libellé affiché pour le champ
                'label' => 'Mot de passe',

                # mapped => false signifie que ce champ n'est pas automatiquement enregistré
                # Le hash et l'enregistrement sont gérés dans le contrôleur
                'mapped' => false,

                # Champ optionnel (utile notamment en mode édition)
                'required' => false,

                # Texte d'aide différent selon le mode (création ou édition)
                'help' => $options['is_edit']
                    ? 'Laisse vide pour conserver le mot de passe actuel.'
                    : null,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        # Configure les options par défaut du formulaire
        $resolver->setDefaults([
            # Lie ce formulaire à la classe Utilisateur (mapping automatique des champs)
            'data_class' => Utilisateur::class,

            # Option personnalisée permettant de distinguer création et édition
            'is_edit' => false,
        ]);

        # Impose que l'option is_edit soit obligatoirement de type booléen
        $resolver->setAllowedTypes('is_edit', 'bool');
    }
}
