<?php

namespace App\Form;

use App\Entity\Meeting;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType ;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UsersType extends AbstractType
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
        ->add('phone_number' , TextType::class ,  [
            'attr' =>[
                'class' => 'form-control',
                'minlenght' => '2',
                'maxlength' => '50',
            ],            
           'label' => 'Numéro de téléphone' , 
           'label_attr' => [
            'class' => 'form_label'
           ],
           'constraints' => [
            new Length(['min' => 10 , 'max' => 10]),
            new NotBlank(),
           ]
           ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => 'Modifier' , 
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
