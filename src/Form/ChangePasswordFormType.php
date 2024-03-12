<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('newPassword', PasswordType::class, [
            'attr' => [
                'autocomplete' => 'new-password',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a password',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Your password should be at least {{ limit }} characters',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
            ],
            'label' => 'New password',
        ])
        ->add('confirmPassword', PasswordType::class, [
            'label' => 'Confirm Password',
            'constraints' => [
                new NotBlank([
                    'message' => 'Please confirm your password',
                ]),
                new Callback([$this, 'validatePasswordMatch']),
            ],
        ])
        ;
    }
    
    public function validatePasswordMatch($value, ExecutionContextInterface $context): void
    {
        $newPassword = $context->getRoot()->get('newPassword')->getData();
        if ($newPassword !== $value) {
            $context->buildViolation('The passwords do not match.')
                ->atPath('confirmPassword')
                ->addViolation();
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
