<?php

// src/Form/MessageStreamType.php

namespace App\Form;

use App\Entity\MessageStream;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageStreamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // You can add other fields as needed
            ->add('content', TextareaType::class, [
                'label' => 'Message Content',
                'required' => true,
                'attr' => ['rows' => 5], // Adjust rows as needed
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MessageStream::class,
        ]);
    }
}
