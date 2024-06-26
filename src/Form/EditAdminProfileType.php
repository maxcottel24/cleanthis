<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;


/**
 * @author Florent <bflorent53170@gmail.com>
 * @author Nacim <nacim.ouldrabah@gmail.com>
 * @author Efflam <cefflam@gmail.com>
 */

class EditAdminProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'form.label.firstname'
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'form.label.lastname:'
            ])
            ->add('date_of_birthday', BirthdayType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'form.label.birthday:'
            ])
            ->add('phone_number', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'form.label.phone:'
            ])
            // ->add('email', EmailType::class,[
            //     'attr' => [
            //         'class' => 'form-control'
            //     ],
            //     'label' => 'E-mail :'
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
            'translation_domain' => 'messages'
        ]);
    }
}
