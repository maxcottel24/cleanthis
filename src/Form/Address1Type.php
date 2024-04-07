<?php

namespace App\Form;

use App\Entity\users;
use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;



class Address1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('zipcode', TextType::class, array(
                'attr' => [
                    'readonly' => true,
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank()
                ],
                'label' => 'form.label.zipcode',
            ))
            ->add('city', TextType::class, array(
                'attr' => [
                    'readonly' => true,
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank()
                ],
                'label' => 'form.label.city',
            ))
            ->add('street', null, [
                'attr' => [
                    'id' => 'form_street',
                    'class' => 'form-control',
                    'placeholder' => '* veuillez entrer votre adresse ici'
                ],
                'label' => 'form.label.street'
            ])
            ->add('Valider', SubmitType::class, [
                'label'    => 'form.label.submit',
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ]
            ]);
        //             ->add('user', EntityType::class, [
        //                 'class' => users::class,
        // 'choice_label' => 'id',
        //             ])
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
            'translation_domain' => 'messages'
        ]);
    }
}
