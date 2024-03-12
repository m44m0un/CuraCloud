<?php

namespace App\Form;
use App\Entity\User;
use App\Entity\Appointment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class AppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class, [
      
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Scheduled' => 'scheduled',
                ],
                'attr' => ['class' => 'form-select d-none'], // Use Bootstrap's d-none class to hide
                'label_attr' => ['class' => 'form-label d-none'],
                'disabled' => true, // This will prevent the field from being changed by the user
            ])
            
            ->add('startDate', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control datetimepicker'],
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add('endDate', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control datetimepicker'],
                'label_attr' => ['class' => 'form-label'],
            ])

            ->add('rating')
            
            ->add('id_doctor', HiddenType::class, [
                // Assuming you're passing the doctor ID as an option to your form
                'data' => (isset($options['doctor_id']) ? $options['doctor_id'] : null),
                'mapped' => false, // Assuming you handle the doctor entity association manually
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