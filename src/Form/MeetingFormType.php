<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Meeting;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;

class MeetingFormType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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
                'query_builder' => function ($er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.job_title = :jobTitle')
                        ->setParameter('jobTitle', 'Null');
                },
                'choice_label' => function (Users $user) {
                    return sprintf('%s, %s', $user->getFirstname(), $user->getLastname());
                },
                'multiple' => false,
                'mapped' => false,
            ])
            ->add('currentUser', HiddenType::class, [
                'mapped' => false,
                'data' => $options['user'] ? $options['user']->getId() : null,
            ])
            ->add('address', ChoiceType::class, [
                'choices' => $options['userData'], // Use userData passed as option
                'choice_label' => function ($address) {
                    if (is_array($address) && isset($address['street']) && isset($address['city']) && isset($address['zipcode'])) {
                        return sprintf('%s, %s %s', $address['street'], $address['city'], $address['zipcode']);
                    } else {
                        return 'Address information is missing';
                    }
                },
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please select an address.',
                    ]),
                ],
            ]);

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                // This initializes the address field without specific choices
                $form = $event->getForm();
                $this->addAddressField($form);
            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                // This updates the address field based on the selected user
                $data = $event->getData();
                $form = $event->getForm();

                $userId = $data['selectedUser'] ?? null;
                if ($userId) {
                    $user = $this->entityManager->getRepository(Users::class)->find($userId);
                    if ($user) {
                        $this->addAddressField($form, $user);
                    }
                } else {
                    // Reset the address field if no user is selected
                    $this->addAddressField($form);
                }
            }
        );
    }

    private function addAddressField(FormInterface $form, Users $user = null)
    {
        $addresses = $user ? $user->getAddresses() : [];

        $form->add('address', EntityType::class, [
            'class' => Address::class,
            'placeholder' => 'Select an address',
            'choices' => $addresses,
            'label' => 'Address',
            'choice_label' => function (Address $address) {
                return sprintf('%s, %s %s', $address->getStreet(), $address->getCity(), $address->getZipcode());
            },
            'constraints' => [
                new NotBlank([
                    'message' => 'Please select an address.',
                ]),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Meeting::class,
            'user' => null,
            'userData' => null, // Add userData option
        ]);
    }
}
