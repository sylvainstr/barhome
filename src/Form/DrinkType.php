<?php

namespace App\Form;

use App\Entity\Drink;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DrinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('category',TextType::class, [
            "label" => "Catégorie de la boisson",
            'required' => true
        ])
        ->add('type',TextType::class, [
            "label" => "Rouge/Rosé/Blanc",
            'required' => false
        ])
        ->add('name',TextType::class, [
            "label" => "Nom de la boisson",
            'required' => true
        ])
        ->add('year',IntegerType::class, [
            "label" => "Année",
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