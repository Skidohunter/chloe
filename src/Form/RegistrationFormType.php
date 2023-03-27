<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('plainPassword',RepeatedType::class, [
                'type' => PasswordType::class,
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'invalid_message' => 'Les deux mdp ne sont pas identiques',
                'required' => true,
                'first_options' => [
                    'label' => 'mdp',
                    'attr' => [
                        'placeholder' => 'Renseignez votre mdp'
                    ]
                ],
                'second_options' => [
                    'label' => 'confirm mdp',
                    'attr' => [
                        'placeholder' => 'Retapez votre mdp'
                    ]
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un mdp'
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Taille minimum 8',
                        'max' => 4096,
                        'maxMessage' => 'Taille max 4096'
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,4096}$/',
                        'message' => 'votre mdp doit contenir au moins une miniscule une majuscule un chiffre et au mini 8 caractère'
                    ])
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
