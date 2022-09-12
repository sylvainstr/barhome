<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, [
                "label" => "Votre nom* :",
                'attr' => ['placeholder' => "Exemple : Dupont"],
                'required' => true,
                'constraints' => [    
                    new NotBlank([
                        'message' => 'Veuillez renseigner ce champ',
                    ]),                
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre nom doit faire au minimum trois caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ])
                ],
            ])
            ->add('firstname',TextType::class, [
                "label" => "Votre prénom* :",
                'attr' => ['placeholder' => "Exemple : Marie"],
                'required' => true,
                'constraints' => [  
                    new NotBlank([
                        'message' => 'Veuillez renseigner ce champ',
                    ]),                  
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre nom doit faire au minimum trois caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ])
                ],
            ])
            ->add('email',EmailType::class, [
                "label" => "Votre adresse e-mail* :",
                'attr' => ['placeholder' => "Exemple : dupont.marie@mail.com"],
                'required' => true,
                'constraints' => [    
                    new NotBlank([
                        'message' => 'Veuillez renseigner ce champ',
                    ])
                ],
            ])
            ->add('phone',TextType::class, [
                "label" => "Numéro de téléphone :",
                'attr' => ['placeholder' => "Exemple : 0600000000"],
                'required' => false,
                'constraints' => [ 
                    new Regex(
                        [
                            'pattern' => '/^((\+)33|0)[1-9](\d{2}){4}$/',
                            'message' => 'Au moins dix chiffres entre 0 et 10'
                        ]
                    ),
                ],
                ])
            ->add('subject',TextType::class, [
                "label" => "Votre sujet* :",
                'attr' => ['placeholder' => "Exemple : Demande d'informations"],
                'required' => true,
                'constraints' => [  
                    new NotBlank([
                        'message' => 'Veuillez renseigner ce champ',
                    ]),                  
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre nom doit faire au minimum trois caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ])
                ],
                ])
            ->add('message', TextareaType::class, [
                "label" => "Votre message* :",
                'attr' => ['placeholder' => "Tapez votre message ici..."],
                'required' => true,
                'constraints' => [  
                    new NotBlank([
                        'message' => 'Veuillez renseigner ce champ',
                    ]),                  
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre nom doit faire au minimum trois caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
