<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'label_attr'=>[
                    "class" => "form-label mt-4"
                ],
                'attr' =>[
                    'class' => 'form-control',
                ],
            ])
            ->add('pseudo', TextType::class,[
                'label_attr'=>[
                    "class" => "form-label mt-4"
                ],
                "attr"=>[
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
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label_attr'=>[
                    "class" => "form-label mt-4"
                ],
                'attr' => ['autocomplete' => 'new-password',
                'class' => 'form-control',
            ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Ton mot de passe doit contenir au moins {{ limit }} caracters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
