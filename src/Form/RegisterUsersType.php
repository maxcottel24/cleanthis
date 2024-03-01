<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterUsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname' , TextType::class ,  [
                'attr' =>[
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlength' => '50',
                ],            
               'label' => 'Prénom' , 
               'label_attr' => [
                'class' => 'form_label'
               ],
               'constraints' => [
                new Length(['min' => 2]),
                new NotBlank(),
               ]
            ])
            ->add('lastname', TextType::class ,  [
                'attr' =>[
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlength' => '50',
                ],            
               'label' => 'Nom' , 
               'label_attr' => [
                'class' => 'form_label'
               ],
               'constraints' => [
                new Length(['min' => 2]),
                new NotBlank(),
               ]
            ])
            ->add('date_of_birthday', BirthdayType::class ,[
                'placeholder'=> [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
            ])
            ->add('phone_number' , TextType::class ,  [
                'attr' =>[
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlength' => '50',
                ],            
               'label' => 'Numéro de Telephone' , 
               'label_attr' => [
                'class' => 'form_label'
               ],
               'constraints' => [
                new Length(['min' => 10 , 'max' => 10]),
                new NotBlank(),
               ]
               ])
            ->add('email' , EmailType::class ,[
                'attr' =>[
                    'class' => 'form-control',
                    'minlenght' => '5',
                    'maxlength' => '255',
                ],
                'label' => 'Email' , 
               'label_attr' => [
                'class' => 'form_label'
               ],
               'constraints' => [
                new Length(['min' => 3]),
                new NotBlank(),
                new Email(),
               ],
               ])
            ->add('password' , RepeatedType::class , [

             'type' => PasswordType::class ,
             'first_options' => [
                'label' => 'Mot de passe',
                'attr' => [
                    'class'=> 'form-control'
                ]
             ],
             'second_options' => [
                'label' =>'Confirmation du mot de passe',
                'attr' => [
                    'class'=> 'form-control'
                ] 
             ],
             'invalid_message' => 'Les mots de passe ne correspondent pas.'
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
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