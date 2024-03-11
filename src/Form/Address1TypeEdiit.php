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
            ->add('zipcode', TextType::class, array ('attr' => array ('readonly' => true) ,
            'constraints' => [
                new NotBlank()
               ]))
            ->add('city', TextType::class, array ('attr' => array ('readonly' => true) ,
            'constraints' => [
                new NotBlank()
               ]))
            ->add('street', null, [
                'attr' => ['id' => 'form_street',
                 'class' => 'custom-class',
                  'placeholder' => 'Adresse' ],
            ])
            ->add('is_primary', CheckboxType::class, [
                'label'    => 'Définir comme adresse principale     ',
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
        ]);
    }
}
