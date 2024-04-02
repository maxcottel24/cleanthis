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
                   'label' => 'form.label.password.request',
                   'attr' => [
                       'class'=> 'form-control'
                   ]
                ],
                'second_options' => [
                   'label' =>'form.label.password.confirm',
                   'attr' => [
                       'class'=> 'form-control'
                   ] 
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas.', 
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 8]),
                ]
               ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'translation_domain' => 'messages'
        ]);
    }
}