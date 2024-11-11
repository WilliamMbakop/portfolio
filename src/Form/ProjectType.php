<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Techno;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom",
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
            ->add('resume', TextareaType::class, [
                "label" => "Résumé",
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
            ->add('url', TextType::class, [
                "label" => "Url",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('techno', EntityType::class, [
                'class' => Techno::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
