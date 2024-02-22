<?php

namespace App\Form;

use App\Entity\Appointment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\DateTime;

class AppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Scheduled' => 'scheduled',
                    'Completed' => 'completed',
                    'Cancelled' => 'cancelled',
                ],
                'placeholder' => 'Choose an option',
                'constraints' => [
                    new NotBlank(),
                ],
                'attr' => ['class' => 'form-select'],
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add('startDate', DateTimeType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank(),
                    new DateTime(),
                ],
                'attr' => ['class' => 'form-control datetimepicker'],
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add('endDate', DateTimeType::class, [
                'widget' => 'single_text',
                // Assuming end date can be optional, remove NotBlank if it's mandatory
                'constraints' => [
                    new DateTime(),
                ],
                'attr' => ['class' => 'form-control datetimepicker'],
                'label_attr' => ['class' => 'form-label'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }
}