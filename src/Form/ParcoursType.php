<?php

namespace App\Form;

use App\Entity\Parcours;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParcoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('datedeb', null, [
                'input' => 'datetime_immutable'
            ])
            ->add('datefin', null, [
                'input' => 'datetime_immutable'
            ])
            ->add('job', TextType::class, [
                "label" => "Poste",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('company', TextType::class, [
                "label" => "Entreprise",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('missions', TextareaType::class, [
                "label" => "Missions",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Parcours::class,
        ]);
    }
}
