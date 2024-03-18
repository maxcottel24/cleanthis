<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\PasswordStrength;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterUsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class,  [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlength' => '50',
                ],
                'label' => 'Prénom *',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                'constraints' => [
                    new Length(['min' => 2]),
                    new NotBlank(),
                ]
            ])
            ->add('lastname', TextType::class,  [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlength' => '50',
                ],
                'label' => 'Nom *',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                'constraints' => [
                    new Length(['min' => 2]),
                    new NotBlank(),
                ]
            ])

            ->add('date_of_birthday', BirthdayType::class, [
                'label' => 'Date de naissance *',
                'label_attr' => [
                    'class' => 'form_dateofbirthday'
                ],
                'placeholder' => [

                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
            ])
            ->add('phone_number', TextType::class,  [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlength' => '50',

                ],
                'label' => 'Numéro de téléphone *',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                'constraints' => [
                    new Length(['min' => 10, 'max' => 10]),
                    new NotBlank(),
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [

                    'class' => 'form-control',
                    'minlenght' => '5',
                    'maxlength' => '255',
                ],

                'label' => 'E-mail *',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                'constraints' => [
                    new Length(['min' => 3]),
                    new NotBlank(),
                    new Email(),
                ],
            ])
            ->add('password', RepeatedType::class, [


                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Mot de passe : (8 caractères minimum)',
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => '1 maj, 1 min, 1 chiffre, 1 caractère spécial'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmer mot de passe *',
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas.', 
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 8]),
                    new Assert\PasswordStrength([
                        'minScore' => PasswordStrength::STRENGTH_WEAK ,
                        'message' => 'Votre mot de passe n\'est pas suffisament sécurisé'
                    ]) 
                ]
            ])
            ->add('Continuer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
