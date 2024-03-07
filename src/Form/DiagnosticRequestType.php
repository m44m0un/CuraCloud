<?php

namespace App\Form;

use App\Entity\DiagnosticRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraint\NotBlank;

class DiagnosticRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

             ->add('type',ChoiceType::class, [
                'choices' => [
                'Analyse' => 'Analyse',
                'Radiologie' => 'Radiologie',
                 ],
                    'expanded' => true, // Utilisez cette option pour afficher les boutons radio
                     'label' => 'Type',
        ])

            ->add('analyseType', ChoiceType::class, [
                'choices' => [
                    'Blood test' => 'Blood test',
                    'Urinalysis' => 'Urinalysis',
                    'Biopsy' => 'Biopsy',
                    'Genetic analysis' => 'Genetic analysis',
                    'Pulmonary function test' => 'Pulmonary function test',
                    'Thyroid function test' => 'Thyroid function test',
                    'Drug monitoring' => 'Drug monitoring',
                    'Hormone analysis' => 'Hormone analysis',
                    'Tumor marker analysis' => 'Tumor marker analysis',
                    'Blood gas analysis' => 'Blood gas analysis',
                    'Allergy tests' => 'Allergy tests',

                ],
                'placeholder' => 'Choose a type of analysis', // Optionnel : ajoutez une option par défaut
                'label' => 'Analyse Type', // Optionnel : ajoutez un libellé pour le champ
            ])

            ->add('radioType', TextType::class, [ // Ajoutez ce champ avec le type TextType
                'label' => 'Radio Type',
                'required' => false,
            ])
            ->add('doctorNotes', TextType::class, [ // Ajoutez ce champ avec le type TextType
                'label' => 'Doctor Notes',
                'required' => false,
            ])
         

            ->add('status', TextType::class, [
                'disabled' => true, // Désactivez le champ
                'label' => 'status',
        
            ])



            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Pending' => 'Pending',
                    'In Progress' => 'In Progress',
                    'Completed' => 'Completed',
    
                ],
                'placeholder' => 'Choose a status', // Optionnel : ajoutez une option par défaut
                'label' => 'Status', // Optionnel : ajoutez un libellé pour le champ
            ])

            ->add('creationDate', DateType::class, [
                'disabled' => true, // Désactivez le champ
                'label' => 'Creation Date',
        
            ])

          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DiagnosticRequest::class,
        ]);
    }
}
