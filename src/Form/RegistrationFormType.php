<?php

namespace App\Form;

use App\Entity\Gender;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', null, [
                'label' => ' ',
                'attr' => [
                    'style' => 'width: 400px; border-radius: 30px; margin-bottom: 5px; background-color: rgba(255, 255, 255, 0.5); height: 50px; opacity:0.5',
                    'placeholder' => 'Enter your first name',
                ],
            ])
            ->add('lastName', null, [
                'label' => ' ',
                'attr' => [
                    'style' => 'width: 400px; border-radius: 30px; margin-bottom: 5px; background-color: rgba(255, 255, 255, 0.5); height: 50px;opacity:0.5',
                    'placeholder' => 'Enter your last name',
                ],
            ])
            ->add('address', null, [
                'label' => ' ',
                'attr' => [
                    'style' => 'width: 400px; border-radius: 30px; margin-bottom: 5px; background-color: rgba(255, 255, 255, 0.5); height: 50px;opacity:0.5',
                    'placeholder' => 'Enter your address',
                ],
            ])
            ->add('tel', null, [
                'label' => ' ',
                'attr' => [
                    'style' => 'width: 400px;border-radius: 30px; margin-bottom: 5px; background-color: rgba(255, 255, 255, 0.5); height: 50px;opacity:0.5',
                    'placeholder' => 'Enter your telephone number',
                ],
            ])
            ->add('gender', EntityType::class, [
                'label' => ' ',
                'class' => Gender::class,
                'choice_label' => 'gender',
                'attr' => [
                    'class' => 'gender-field',
                    'id' => 'gender-field',
                    'style' => 'width: 400px; border-radius: 30px; margin-bottom: 5px; background-color: rgba(255, 255, 255, 0.5); height: 50px;opacity:0.5',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => ' ',
                'attr' => [
                    'placeholder' => 'Enter your email',
                    'style' => 'width: 400px; color: white; border-radius: 30px; margin-bottom: 5px; background-color: rgba(255, 255, 255, 0.5); height: 50px;opacity:0.5',
                ],
            ])
        
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'I agree to the terms and conditions',
                'attr' => [
                    'style' => ' margin: 10px; color:#EEE2DE',

                ],
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                        
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => ' ',
                'attr' => [
                    'placeholder' => 'Enter your password',
                    'style' => 'width: 400px; color: white; border-radius: 30px; margin-bottom: 5px; background-color: rgba(255, 255, 255, 0.5); height: 50px;opacity:0.5',
                ],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
                ],
            ]);
    }
      

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
