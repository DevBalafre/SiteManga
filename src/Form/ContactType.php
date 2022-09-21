<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'attr' => [
                    'maxLenth' => 100
                    ]
            ])
            ->add('sujet',ChoiceType::class,[
                
                    'choices' => [
                    '-- sélectionner --' =>'', 
                      'signaler un bug ' => 'bug',
                      'lien mort' => 'lien mort',
                      'signaler un utilisateur' => 'signaler un utilisateur',
                      'autre' => 'autre'
                                                                                                                              
                ]
            ])
            ->add('message',TextareaType::class,[
                'attr' => [
                    'minLength' => 25,
                    'maxLength' => 2000
                ]
            ])
            ->add('fichier', FileType::class,[
                'required' => false,
                'help' => 'image ou document PDF - 2mo maximum',
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'maxSizeMessage' => 'Le fichier est trop volumineux ({{ size}} {{ suffix }}). La taille maximale autorisée est de {{limite}} {{ suffix}}',
                        
                    ])
                ]
            ])
            //Si cocher refuser envoi du formulaire car bot
            ->add('honeypot',HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
