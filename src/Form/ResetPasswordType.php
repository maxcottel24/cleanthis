<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\PasswordStrength;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password' , RepeatedType::class , [

                'type' => PasswordType::class ,
                'first_options' => [
                   'label' => 'Entrez votre nouveau mot de passe *',
                   'attr' => [
                       'class'=> 'form-control'
                   ]
                ],
                'second_options' => [
                   'label' =>'Confirmation du mot de passe *',
                   'attr' => [
                       'class'=> 'form-control'
                   ] 
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas.', 
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 8]),
                    // new Assert\PasswordStrength([
                    //     'minScore' => PasswordStrength::STRENGTH_WEAK ,
                    //     'Votre mot de passe n\'est pas suffisament sécurisé'
                    // ]) 
                ]
               ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}