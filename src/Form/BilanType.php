<?php

namespace App\Form;

use App\Entity\Bilan;
use App\Entity\DiagnosticRequest;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BilanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('realisationDate')
            ->add('result')
            ->add('labComment')
            ->add('submissionDate')
            ->add('price')

           
            ->add('diagnosticRequest', EntityType::class, [
                'label' => 'Diagnostic Request',
                'class' => DiagnosticRequest::class,
                'choice_label' => 'id', // You can change this to another field of DiagnosticRequest
                'placeholder' => 'Select a Diagnostic Request',
                'required' => true,
            ])

            
        
            ->add('imageFile', FileType::class,[
                'label'=> 'Image(JPEG or PNG file)',
                'required'=> false,
                'data_class'=> null,
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bilan::class,

        ]);
    }

   
}
