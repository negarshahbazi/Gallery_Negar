<?php

namespace App\Form;

use App\Entity\Messages;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('messages', TextareaType::class, [
                'label' => ' ',
                'attr' => [
                    'class' => 'custom-textarea', // Ajoutez une classe CSS personnalisée
                    'style' => 'width: 90%;background-color: rgba(255, 255, 255, 0.6);color: white;', // Définissez la largeur de la zone de texte
                    'placeholder' => 'Enter your message here...', // Ajoutez un texte de rappel (placeholder)

                  
                ],
            ])
            // ->add('createdAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('name', TextType::class, [
            //     'label' => 'Your Name',
            // ])
            // ->add('paint', EntityType::class, [
            //     'class' => Paint::class,
            //     'choice_label' => 'id',
            // ])
            //  ->add('user', HiddenType::class, [
            //     'mapped' => false,
            //  ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Messages::class,
        ]);
    }
}
