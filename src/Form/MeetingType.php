<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Meeting;
use App\Entity\Users;
use App\Repository\AddressRepository;
use Doctrine\DBAL\Types\DecimalType;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeetingType extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];
        $builder
            ->add('reservedAt', null, [
                'widget' => 'single_text',
                'label' => 'Date et Heure du RDV souhaitez : ' ,
            ])
            ->add('description')
            ->add('floor_space' , NumberType::class , [
                'label' => 'surface en cm²' ,
                'invalid_message' => 'Vous devez rentré un nombre.'
            ])
            ->add('address', EntityType::class, [
                'class' => Address::class,
                'label' => 'Adresse' ,
                'choice_label' => function (Address $address) {
                    return sprintf('%s, %s %s', $address->getStreet(), $address->getCity(), $address->getZipcode());
                },
                'query_builder' => function (AddressRepository $ar) use ($user) {
                    return $ar->createQueryBuilder('a')
                        ->where('a.user = :user') 
                        ->setParameter('user', $user)
                        ->orderBy('a.is_primary', 'DESC');
                },
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => 'Confirmer' ,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Meeting::class,
            'user' => null,
        ]);
    }
}
