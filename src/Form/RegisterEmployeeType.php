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
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\PasswordStrength;

/**
 * @author Florent <bflorent53170@gmail.com>
 * @author Nacim <nacim.ouldrabah@gmail.com>
 * @author Efflam <cefflam@gmail.com>
 */

class RegisterEmployeeType extends AbstractType
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
                'label' => 'form.label.firstname',
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
                'label' => 'form.label.lastname',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                'constraints' => [
                    new Length(['min' => 2]),
                    new NotBlank(),
                ]
            ])

            ->add('date_of_birthday', BirthdayType::class, [
                'label' => 'form.label.birthday',
                'label_attr' => [
                    'class' => 'form_dateofbirthday'
                ],
                'placeholder' => [

                    'year' => 'form.label.birthday.year', 'month' => 'form.label.birthday.month', 'day' => 'form.label.birthday.day',
                ],
            ])
            ->add('phone_number', TextType::class,  [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlength' => '50',

                ],
                'label' => 'form.label.phone',
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

                'label' => 'form.label.email',
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
                    'label' => 'form.label.password',
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'form.label.password.help'
                    ]
                ],
                'second_options' => [
                    'label' => 'form.label.password.confirm',
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ],
                'invalid_message' => 'form.label.password.invalid', 
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 8]),
                    new Assert\PasswordStrength([
                        'minScore' => PasswordStrength::STRENGTH_WEAK ,
                        'message' => 'Votre mot de passe n\'est pas suffisament sécurisé'
                    ]) 
                ]
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
            'translation_domain' => 'messages'
        ]);
    }
}
