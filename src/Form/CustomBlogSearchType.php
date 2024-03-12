<?php


// src/Form/CustomBlogSearchType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomBlogSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('search', TextType::class, [
                'label' => false,
                'required' => false, // Allow an empty search term
                'attr' => [
                    'placeholder' => 'Search by Title, Subject, Author',
                    'class' => 'form-control', // Add Bootstrap or your preferred styling class
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Set your form options here if needed
        ]);
    }
}

