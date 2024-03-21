<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Address;
use App\Entity\Meeting;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MeetingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $currentUser = $options['user']; // Récupérer l'utilisateur actuel passé en option

        $builder
            ->add('reservedAt', null, [
                'widget' => 'single_text'
            ])
            ->add('description')
            ->add('floor_space')
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Nouveau RDV' => '1', 
                    'En attente de retour client' => '2',
                    'Pris en charge' => '3', 
                    'Intervention opérateur' => '4'
                ],
            ])
            ->add('selectedUser', EntityType::class, [
                'class' => Users::class,
                'label' => 'Utilisateur',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.job_title = :jobTitle')
                        ->setParameter('jobTitle', 'Null');
                },
                'choice_label' => function (Users $user) {
                    return sprintf('%s, %s', $user->getFirstname(), $user->getLastname());
                },
                'multiple' => false,
                'mapped' => false, // Indiquer que ce champ n'est pas mappé directement à une propriété de l'entité
            ])
            ->add('currentUser', HiddenType::class, [
                'mapped' => false,
                'data' => $currentUser->getId(), // Remplacez $currentUser par votre objet User actuel
            ])
            ->add('address', EntityType::class, [
                'class' => Address::class,
                'label' => 'Adresse du rendez-vous : ' ,
                'choice_label' => function (Address $address) {
                    return sprintf('%s, %s %s', $address->getStreet(), $address->getCity(), $address->getZipcode());
                },
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner une adresse.',
                    ]),
                ]
                ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Meeting::class,
            'user' => null,
        ]);
    }
}