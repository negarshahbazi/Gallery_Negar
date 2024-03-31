<?php

namespace App\Form;

use App\Entity\Gender;
use App\Entity\Profile;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', null, [
                'label' => ' ',
                'attr' => [
                    'placeholder' => 'First Name',
                ],
            ])
            ->add('lastName', null, [
                'label' => ' ',
                'attr' => [
                    'placeholder' => 'Last Name',
                ],
            ])
            ->add('address', null, [
                'label' => ' ',
                'attr' => [
                    'placeholder' => 'Address',
                ],
            ])
            ->add('tel', null, [
                'label' => ' ',
                'attr' => [
                    'placeholder' => 'Phone Number',
                ],
            ])
            ->add('gender', EntityType::class, [
                'placeholder' => 'Gender ', // Placeholder vide
                'class' => Gender::class,
                'choice_label' => 'gender',
                'label' => ' ',
                'label_attr' => [
                    'class' => 'active',
                ],
            ])
            // ->add('user', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'user',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
