<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Meeting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MeetingUpdateTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('reservedAt', null, [
            'widget' => 'single_text', 
            'attr' => [
                'class' => 'form-control',
            ], 
            'label' => 'Sélectionner la date et l\'heure du rendez-vous',
            'constraints' => [
                new NotBlank(),
            ]
        ])
        ->add('floor_space', NumberType::class, [
            'attr' => [
                'class' => 'form-control',
            ],
            'label' => 'Surface en m² : ',
            'invalid_message' => 'Merci de renseigner un nombre.'
        ])
        ->add('description', null, [
            'attr' => [
                'class' => 'form-control',
            ],
            'label' => 'Description : '
        ])
            
        ->add('status', ChoiceType::class, [
            'choices' => [
                'Nouveau RDV' => '1',
                'En attente de retour client' => '2',
                'Intervention opérateur' => '4'
            ],
            'attr' => [
                'class' => 'form-control',
            ],
        ])
            ->add('selectedOperator', EntityType::class, [
                'class' => Users::class,
                'label' => 'Opérateur',
                'query_builder' => function ($er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.job_title = :jobTitle')
                        ->setParameter('jobTitle', 'Opérateur');
                },
                'choice_label' => function (Users $user) {
                    return sprintf('%s, %s', $user->getFirstname(), $user->getLastname());
                },
                'multiple' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Meeting::class,
        ]);

    }
}
