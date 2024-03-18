<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Meeting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\PasswordStrength;
use Symfony\Component\Validator\Constraints as Assert;

class EditAdminPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('password', PasswordType::class, [
            'label' => 'Entrez votre nouveau mot de passe',
            'attr' => [
                'class' => 'form-control'
            ], 
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 8]),
                new Assert\PasswordStrength([
                    'minScore' => PasswordStrength::STRENGTH_WEAK ,
                    'message' => 'Votre mot de passe n\'est pas suffisament sécurisé'
                ]) 
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
