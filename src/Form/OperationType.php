<?php

namespace App\Form;

use App\Entity\meeting;
use App\Entity\Operation;
use App\Entity\TypeOperation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

/**
 * @author Nacim <nacim.ouldrabah@gmail.com>
 */

class OperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('status', ChoiceType::class, [
            'choices' => [
                'form.label.operation.one' => '1',
                'form.label.operation.two' => '2',
                'form.label.operation.four' => '4'
            ],
            'attr' => [
                'class' => 'form-control',
            ],
        ])
            ->add('discount', ChoiceType::class, [
                'choices' => [
                    '0%' => '1',
                    '5%' => '0.95',
                    '10%' => '0.90',
                    '15%' => '0.85',
                    '20%' => '0.80'
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('intervention', DateTimeType::class, [
                'attr' => ['id' => 'meeting_reservedAt'],
                'widget' => 'single_text',
                'label' => 'form.label.reservedAt' ,
            ])
            ->add('description', null, [
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('floor_space', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'form.label.floorSpace',
                'invalid_message' => 'Merci de renseigner un nombre.'
            ])
            ->add('cleanliness', ChoiceType::class, [
                'choices' => [
                    'form.label.cleanliness.one' => '1',
                    'form.label.cleanliness.two' => '2',
                    'form.label.cleanliness.three' => '3'
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Operation::class,
            'translation_domain' => 'messages'
        ]);
    }
}
