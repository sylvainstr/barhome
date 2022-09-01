<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, [
                "label" => "Votre nom* :",
                'attr' => ['placeholder' => "Exemple : Dupont"],
                'required' => true
            ])
            ->add('firstname',TextType::class, [
                "label" => "Votre prénom* :",
                'attr' => ['placeholder' => "Exemple : Marie"],
                'required' => true
            ])
            ->add('email',EmailType::class, [
                "label" => "Votre adresse e-mail* :",
                'attr' => ['placeholder' => "Exemple : dupont.marie@mail.com"],
                'required' => true
            ])
            ->add('phone',TextType::class, [
                "label" => "Numéro de téléphone :",
                'attr' => ['placeholder' => "Exemple : 0600000000"]
                ])
            ->add('subject',TextType::class, [
                "label" => "Votre sujet* :",
                'attr' => ['placeholder' => "Exemple : Demande de devis"],
                'required' => true
                ])
            ->add('message', TextareaType::class, [
                "label" => "Votre message* :",
                'attr' => ['placeholder' => "Tapez votre message ici..."],
                'required' => true
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
