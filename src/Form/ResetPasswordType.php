<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

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
                'invalid_message' => 'Les mots de passe ne correspondent pas.'
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