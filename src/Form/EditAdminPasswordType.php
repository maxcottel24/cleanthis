<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Meeting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\PasswordStrength;

/**
 * @author Florent <bflorent53170@gmail.com>
 * @author Nacim <nacim.ouldrabah@gmail.com>
 * @author Efflam <cefflam@gmail.com>
 */

class EditAdminPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => [
                'label' => 'Nouveau mot de passe : ',
                'label_attr' => ['class' => 'form-label'],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => '1 maj, 1 min, 1 chiffre, 1 caractère spécial'
                ]
            ],
            'second_options' => [
                'label' => 'Confirmation du nouveau mot de passe : ',
                'label_attr' => ['class' => 'form-label'],
                'attr' => ['class' => 'form-control']
            ],
            'invalid_message' => 'Les nouveaux mots de passe ne correspondent pas.',
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 8]),
                new Assert\PasswordStrength([
                    'minScore' => PasswordStrength::STRENGTH_WEAK ,
                    'message' => 'Votre mot de passe n\'est pas suffisament sécurisé'
                ]) 
            ]
                ]); 
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
