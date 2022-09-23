<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordStrength;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label_attr' => [
                    "class" => "form-label mt-4"
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('pseudo', TextType::class, [
                'label_attr' => [
                    "class" => "form-label mt-4"
                ],
                "attr" => [
                    'class' => 'form-control',
                    'minlength' => '4',
                    'minMessage' => 'Ton pseudo doit contenir {{ limit }} caracters',
                    // max length allowed by Symfony for security reasons
                    'maxlength' => '50',
                ],
            ])

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => "Termes d'utilisations",
                'constraints' => [
                    new IsTrue([
                        'message' => 'Tu dois accepter nos termes d\'utilisations.',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' =>'Les deux mots de passe ne correpondent pas ',
                'mapped' => false,
                
                'attr' => [
                    'autocomplete' => 'new-password' ],
                    'first_options' =>[
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
                    'second_options' =>[
                        
                        'constraints' => [
                            new NotBlank([
                                'message' =>'Merci de confirmer le mot de passe'
                            ])
                        ]
                    ]
                
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
