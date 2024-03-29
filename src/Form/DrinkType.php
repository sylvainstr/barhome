<?php

namespace App\Form;

use App\Entity\Drink;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class DrinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('category',TextType::class, [
            "label" => "Catégorie de la boisson*",
            'attr' => ['placeholder' => "Veuillez renseigner la boisson"],
            'constraints' => [ 
                new Regex(
                    [
                        'pattern' => '/^[\s\p{Ll}À-ÖØ-öø-ÿ-]+$/',
                        'message' => 'Votre texte doit être en minuscule'
                    ]
                ),
            ],
            'required' => true
        ])        
        ->add('name',TextType::class, [
            "label" => "Nom de la boisson*",
            'attr' => ['placeholder' => "Veuillez renseigner le nom"],
            'constraints' => [ 
                new Regex(
                    [
                        'pattern' => '/^[\s\d\p{Ll}À-ÖØ-öø-ÿ-]+$/',
                        'message' => 'Votre texte doit être en minuscule'
                    ]
                ),
            ],
            'required' => true
        ])
        ->add('year',IntegerType::class, [
            "label" => "Année",
            'attr' => ['placeholder' => "Veuillez renseigner l'année"],
            'constraints' => [ 
                new Regex(
                    [
                        'pattern' => '/^\d{4}$/',
                        'message' => 'Votre date doit contenir 4 chiffres'
                    ]
                ),
            ],
            'required' => false
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Drink::class,
        ]);
    }
}
