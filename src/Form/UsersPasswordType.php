<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\PasswordStrength;

class UsersPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface  $builder, array $options): void
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'form.label.password.old',
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'form.label.password.new',
                    'label_attr' => ['class' => 'form-label'],
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'form.label.password.help'
                    ]
                ],
                'second_options' => [
                    'label' => 'form.label.password.confirm',
                    'label_attr' => ['class' => 'form-label'],
                    'attr' => ['class' => 'form-control']
                ],
                'invalid_message' => 'Les nouveaux mots de passe ne correspondent pas.',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 8]),
                    new Assert\PasswordStrength([
                        'minScore' => PasswordStrength::STRENGTH_WEAK ,
                        'message' => 'Votre mot de passe n\'est pas suffisament sécurisé'
                    ]) 
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary mt-4', 'id' => 'btn-confirm'],
                'label' => 'form.label.submit',
            ]);
    }
}
