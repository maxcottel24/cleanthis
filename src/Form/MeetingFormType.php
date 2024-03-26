<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Address;
use App\Entity\Meeting;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

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
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Sélectionner la date et l\'heure du rendez-vous',
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('description', null, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Description : '
            ])
            ->add('floor_space', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Surface en m² : ',
                'invalid_message' => 'Merci de renseigner un nombre.'
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Nouveau RDV' => '1',
                    'En attente de retour client' => '2',
                    'Pris en charge' => '3',
                    'Intervention opérateur' => '4'
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('selectedUser', EntityType::class, [
                'class' => Users::class,
                'label' => 'Client',
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
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('address', EntityType::class, [
                'class' => Address::class, // Spécifiez la classe de l'entité Address
                'label' => 'Adresse',
                'choice_label' => function ($address) {
                    return sprintf('%s, %s %s', $address->getStreet(), $address->getCity(), $address->getZipcode());
                },
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner une adresse.',
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
        $addresses = [];
        if ($user) {
            foreach ($user->getAddresses() as $address) {
                // Utilisez l'entité Address directement dans le choix
                $addresses[$address->getStreet() . ', ' . $address->getCity() . ' ' . $address->getZipcode()] = $address;
            }
        }

        $form->add('address', EntityType::class, [
            'class' => Address::class, // Spécifiez la classe de l'entité Address
            'label' => 'Adresse',
            'choices' => $addresses,
            'choice_label' => function ($address) {
                return sprintf('%s, %s %s', $address->getStreet(), $address->getCity(), $address->getZipcode());
            },
            'attr' => [
                'class' => 'form-control',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez sélectionner une adresse.',
                ]),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Meeting::class,
            'userData' => [],
        ]);
    }
}
