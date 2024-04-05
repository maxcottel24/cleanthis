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

/**
 * @author Nacim <nacim.ouldrabah@gmail.com>
 */


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
            'label' => 'form.label.reservedAt',
            'constraints' => [
                new NotBlank(),
            ]
        ])
        ->add('floor_space', NumberType::class, [
            'attr' => [
                'class' => 'form-control',
            ],
            'label' => 'form.label.floorSpace',
            'invalid_message' => 'Merci de renseigner un nombre.'
        ])
        ->add('description', null, [
            'attr' => [
                'class' => 'form-control',
            ],
            'label' => 'form.label.description'
        ])
            
        ->add('status', ChoiceType::class, [
            'choices' => [
                'form.label.meeting.one' => '1',
                'form.label.meeting.two' => '2',
                'form.label.meeting.four' => '4'
            ],
            'attr' => [
                'class' => 'form-control',
            ],
        ])
            ->add('selectedOperator', EntityType::class, [
                'class' => Users::class,
                'label' => 'form.label.employee',
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
            'translation_domain' => 'messages'
        ]);

    }
}
