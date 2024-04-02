<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class Address1TypeEdit extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('zipcode', TextType::class, array(
                'attr' => [
                    'readonly' => true,
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank()
                ],
                'label' => 'form.label.zipcode'
            ))
            ->add('city', TextType::class, array(
                'attr' => [
                    'readonly' => true,
                    'class' => 'form-control'
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
                    'placeholder' => 'Adresse'
                ],
                'label' => 'form.label.street'
            ])
            ->add('is_primary', CheckboxType::class, [
                'label'    => 'form.label.primary',
                'required' => false,
            ])
            //             ->add('user', EntityType::class, [
            //                 'class' => users::class,
            // 'choice_label' => 'id',
            //             ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
            'translation_domain' => 'messages'
        ]);
    }
}
