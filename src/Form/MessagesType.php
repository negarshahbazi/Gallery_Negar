<?php

namespace App\Form;

use App\Entity\Messages;
use App\Entity\Paint;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('messages', TextareaType::class, [
                'label' => 'Your Comment',
            ])
            // ->add('createdAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('name', TextType::class, [
            //     'label' => 'Your Name',
            // ])
            ->add('paint', EntityType::class, [
                'class' => Paint::class,
                'choice_label' => 'id',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Messages::class,
        ]);
    }
}
