<?php

namespace App\Form;

use App\Entity\Gender;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('email')
            // ->add('roles')
            // ->add('password')
            ->add('firstName')
            ->add('lastName')
            ->add('address')
            ->add('tel')
            ->add('methodPayment', ChoiceType::class, [
                'choices' => [
                    'Paypal' => 'paypal',
                    'Stripe' => 'stripe',
                ],
           
                'label' => 'Payment Method',
                'attr' => [
                    'class' => 'bg-transparent w-100 border-2 text-light fs-5 optional'
                ]
            ]);
            // ->add('gender', EntityType::class, [
            //     'class' => Gender::class,
            //     'choice_label' => 'id',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
