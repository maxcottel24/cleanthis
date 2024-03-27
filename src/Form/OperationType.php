<?php

namespace App\Form;

use App\Entity\meeting;
use App\Entity\Operation;
use App\Entity\TypeOperation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class OperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('status', ChoiceType::class, [
            'choices' => [
                'En attente' => '1',
                'En cours' => '2',
                'Terminée' => '3',
                'Annulée' => '4'
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
            ->add('description', null, [
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('floor_space', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Surface en m² : ',
                'invalid_message' => 'Merci de renseigner un nombre.'
            ])
            ->add('cleanliness', ChoiceType::class, [
                'choices' => [
                    'Normal' => '1',
                    'Sale' => '2',
                    'Très sale' => '3'
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
        ]);
    }
}
