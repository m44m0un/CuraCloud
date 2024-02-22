<?php

namespace App\Form;

use App\Entity\MedicalRecord;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class MedicalRecordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('medicalHistory', TextareaType::class, [
                'constraints' => new NotBlank(),
            ])
            ->add('surgicalHistory', TextareaType::class, [
                // Optional field, no constraints needed
            ])
            ->add('familyHistory', TextareaType::class, [
                // Optional field, no constraints needed
            ])
            ->add('allergies', TextType::class, [
                // Optional field, no constraints needed
            ])
            ->add('height', NumberType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Range(['min' => 0]), // Ensure height is positive
                ],
            ])
            ->add('weight', NumberType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Range(['min' => 0]), // Ensure weight is positive
                ],
            ])
            ->add('bloodType', ChoiceType::class, [
                'choices' => [
                    'A+' => 'A+',
                    'A-' => 'A-',
                    'B+' => 'B+',
                    'B-' => 'B-',
                    'AB+' => 'AB+',
                    'AB-' => 'AB-',
                    'O+' => 'O+',
                    'O-' => 'O-',
                ],
                'placeholder' => 'Select a blood type',
                'constraints' => new NotBlank(),
            ])
            ->add('diseases', TextareaType::class, [
                // Optional field, no constraints needed
            ])
            ->add('medications', TextareaType::class, [
                // Optional field, no constraints needed
            ])
            ->add('vaccines', TextareaType::class, [
                // Optional field, no constraints needed
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MedicalRecord::class,
        ]);
    }
}
