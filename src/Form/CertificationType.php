<?php

namespace App\Form;

use App\Entity\Certification;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CertificationType extends AbstractType
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
            ->add('description', TextareaType::class, [
                "label" => "Description",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('dateobtention', null, [
                'widget' => 'single_text',
                "label" => "Date d'obtention",
            ])
            ->add('url', TextType::class, [
                "label" => "Url",
                "attr" => [
                    "class" => "form-control"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Certification::class,
        ]);
    }
}
