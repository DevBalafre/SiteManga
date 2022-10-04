<?php

namespace App\Form;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordStrength;



class UserPasswordType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe actuel',
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password'
                ]
            ])
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe ne correpondent pas ',
                'mapped' => false,

                'attr' => [
                    'autocomplete' => 'new-password'

                ],
                'first_options' => [
                    'label' => 'Nouveau mot de passe',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Vous devez entrer un mot de passe',
                        ]),
                        new PasswordStrength([
                            'minLength' => 8,
                            'tooShortMessage' => 'Le mot de passe doit contenir au moins 8 carctères',
                            'minStrength' => 4,
                            'message' => 'Le mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial',
                        ])
                    ],
                ],
                'second_options' => [
                    'label' => 'Confimez votre mot de passe',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Merci de confirmer le mot de passe'
                        ])
                    ]
                ]

            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Validez votre mot de passe',
                'attr' => [
                    'class' => 'aButton'
                ]
                

            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
