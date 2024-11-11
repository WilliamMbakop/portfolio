<?php

namespace App\Form;

use App\Entity\Presentation;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PresentationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom & Prénom",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                "label" => "Photo",
                'required' => true,
                "attr" => [
                    "class" => "form-control"
                ]

            ])
            ->add('job', TextType::class, [
                "label" => "Profession",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('passion', TextType::class, [
                "label" => "Passion",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('localization', TextType::class, [
                "label" => "Localisation",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('tel', TextType::class, [
                "label" => "Téléphone",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('email', TextType::class, [
                "label" => "Email",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Presentation::class,
        ]);
    }
}
