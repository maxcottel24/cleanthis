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
                'label' => 'Mot de passe actuel : ',
                'label_attr' => ['class' => 'form-label'],
                'constraints' =>  [
                    new NotBlank(),
                ]
            ])
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Nouveau mot de passe : (8 caractères minimum)',
                    'label_attr' => ['class' => 'form-label'],
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => '* 1 maj, 1 min, 1 chiffre, 1 caractère spécial'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmation du nouveau mot de passe : ',
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
                'label' => 'Confirmer',
            ]);
    }
}
