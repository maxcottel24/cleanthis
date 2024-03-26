<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Entity\Address;
use App\Entity\Meeting;
use App\Entity\Operation;
use App\Entity\TypeOperation;
use App\Form\MeetingFormType;
use App\Service\SendMailService;
use App\Form\MeetingUpdateTypeForm;
use App\Repository\UsersRepository;
use App\Repository\AddressRepository;
use App\Repository\MeetingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class AdminMeetingController extends DashboardController
{
    private $entityManager;
    private $userRepository;
    private $meetingRepository;

    public function __construct(EntityManagerInterface $entityManager, MeetingRepository $meetingRepository, UsersRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->meetingRepository = $meetingRepository;
    }

    #[Route('/admin/meeting', name: 'app_admin_meeting')]
    public function index(): Response
    {
        $meetings = $this->entityManager->getRepository(Meeting::class)->findAll();

        //Permets d'inscrire le nom de l'opérateur
        $operatorNames = [];
        foreach ($meetings as $meeting) {
            $operatorNames[$meeting->getId()] = $meeting->getStatus() == 3 ? $this->getUser()->__toString() : null;
        }

        return $this->render('admin/meeting/index.html.twig', [
            'meetings' => $meetings,
            'operatorNames' => $operatorNames,
        ]);
    }

    #[Route('/admin/meeting/handle/{id}', name: 'app_admin_meeting_handle', methods: ['POST'])]
    public function handleMeeting(Request $request, $id, SendMailService $mail): Response
    {
        $meeting = $this->entityManager->getRepository(Meeting::class)->find($id);

        if (!$meeting) {
            throw $this->createNotFoundException('RDV non trouvé');
        }

        $user = $this->getUser();

        // Loop through users associated with the meeting
        foreach ($meeting->getUsers() as $customer) {
            // Check if the customer's job title is "Null"
            if ($customer->getJobTitle() == "Null") {
                $context = [
                    'userId' => $user->getId(),
                    'user' => $user,
                    'meeting' => $meeting,
                ];

                // Send email to the customer whose job title is "Null"
                $mail->send(
                    'acleanthis@gmail.com',
                    $customer->getEmail(), // Send email to the customer
                    'Votre rendez-vous est confirmé',
                    'confirmation_meeting_admin',
                    $context,
                );
            }
        }

        // Check if the current user is an instance of Users
        if (!$user instanceof Users) {
            throw new \RuntimeException('Aucun utilisateur connecté');
        }

        // Remove the old user with the job_title "Opérateur"
        foreach ($meeting->getUsers() as $currentUser) {
            if ($currentUser->getJobTitle() === "Opérateur") {
                $meeting->removeUser($currentUser);
            }
        }

        // Associate the current user with the meeting if not already associated
        if (!$meeting->getUsers()->contains($user)) {
            $meeting->addUser($user);
        }

        // Update the status of the meeting
        $meeting->setStatus(3); // Assume that 3 is the status for "Pris en charge"

        $this->entityManager->flush();

        $this->addFlash('success', 'RDV pris en charge avec succès.');

        return $this->redirect('/admin?routeName=app_admin_meeting', 301);
    }
    #[Route('/admin/meeting/new/', name: 'app_admin_meeting_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Security $security, SendMailService $mail ): Response
    {
        $meeting = new Meeting();

        // Récupérer tous les utilisateurs et leurs adresses
        $users = $this->userRepository->findAllWithAddresses();

        // Formater les données pour les utilisateurs et les adresses
        $userData = [];
        foreach ($users as $user) {
            $userAddresses = [];
            foreach ($user->getAddresses() as $address) {
                $userAddresses[] = [
                    'id' => $address->getId(),
                    'text' => $address->getStreet() . ', ' . $address->getCity() . ' ' . $address->getZipcode(),
                ];
            }
            $userData[$user->getId()] = [
                'id' => $user->getId(),
                'text' => $user->getFirstname() . ' ' . $user->getLastname(),
                'addresses' => $userAddresses,
            ];
        }

        $form = $this->createForm(MeetingFormType::class, $meeting, [
            'userData' => $userData, // Passer les données utilisateur au formulaire
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer l'utilisateur sélectionné dans le formulaire
            $selectedUserId = $form->get('selectedUser')->getData();
            $selectedUser = $this->userRepository->find($selectedUserId);

            // Récupérer l'utilisateur courant
            $currentUser = $security->getUser();
            $meetingStatus = $meeting->getStatus(); // Suppose que getStatus() renvoie le statut actuel du rendez-vous
            $currentUser = $this->getUser();
            if ($currentUser && ($meetingStatus == 3)) {
                $meeting->addUser($currentUser);
            }
            // Enregistrer le nouveau rendez-vous dans la base de données
            $this->entityManager->persist($meeting);

            // Ajouter les utilisateurs au rendez-vous
            $meeting->addUser($selectedUser);
             // Loop through users associated with the meeting
        foreach ($meeting->getUsers() as $customer) {
            // Check if the customer's job title is "Null"
            if ($customer->getJobTitle() == "Null") {
                $context = [
                    'userId' => $user->getId(),
                    'user' => $user,
                    'meeting' => $meeting,
                ];
                if ($meeting->getStatus() == 3) {
                    $mail->send(
                    'acleanthis@gmail.com',
                    $customer->getEmail(), // Send email to the customer
                    'Votre rendez-vous est confirmé',
                    'confirmation_meeting_admin',
                    $context,
                );
                }elseif ($meeting->getStatus() == 1) {
                    $mail->send(
                        'acleanthis@gmail.com',
                        $customer->getEmail(), // Send email to the customer
                        'Vous avez un nouveau rendez-vous',
                        'nouveau_rdv',
                        $context,
                    );
                }elseif ($meeting->getStatus() == 2) {
                    $mail->send(
                        'acleanthis@gmail.com',
                        $customer->getEmail(), // Send email to the customer
                        'Merci, de confirmer votre rendez-vous',
                        'update_rdv',
                        $context,
                    );
                }elseif ($meeting->getStatus() == 4) {
                    $mail->send(
                        'acleanthis@gmail.com',
                        $customer->getEmail(), // Send email to the customer
                        'Votre rendez-vous est en attente de traitement un de nos opérateurs',
                        'en_attente_rdv',
                        $context,
                    );
                }

                // Send email to the customer whose job title is "Null"
                
            }
        }

            // Enregistrer le rendez-vous avec les utilisateurs
            $this->entityManager->flush();

            // Ajoutez un message flash pour indiquer le succès de l'opération
            $this->addFlash('success', 'Le rendez-vous a été créé avec succès.');

            // Redirigez vers une autre page, par exemple la liste des rendez-vous
            return $this->redirect('/admin?routeName=app_admin_meeting', 301);
        }

        return $this->render('admin/meeting/new.html.twig', [
            'form' => $form->createView(),
            'userData' => $userData,
        ]);
    }

    #[Route('/admin/meeting/delete/{id}', name: 'app_admin_meeting_delete', methods: ['POST'])]
    public function deleteMeeting(Request $request, $id, SendMailService $mail): Response
    {
        $meeting = $this->entityManager->getRepository(Meeting::class)->find($id);

        if (!$meeting) {
            throw $this->createNotFoundException('RDV non trouvé.');
        }
        $user = $this->getUser();
        foreach ($meeting->getUsers() as $customer) {
            // Check if the customer's job title is "Null"
            if ($customer->getJobTitle() == "Null") {
                $context = [
                    'userId' => $user->getId(),
                    'user' => $user,
                    'meeting' => $meeting,
                ];

                // Send email to the customer whose job title is "Null"
                $mail->send(
                    'acleanthis@gmail.com',
                    $customer->getEmail(), // Send email to the customer
                    'Votre rendez-vous a été annulé',
                    'delete_meeting',
                    $context,
                );
            }
        }

        $this->entityManager->remove($meeting);
        $this->entityManager->flush();

        $this->addFlash('success', 'Rendez-vous supprimé avec succès.');
        return $this->redirect('/admin?routeName=app_admin_meeting', 301);
    }


    #[Route('/admin/meeting/update/{id}', name: 'app_admin_meeting_update', methods: ['GET', 'POST'])]
    public function update(Request $request, $id, SendMailService $mail): Response
    {
        $meeting = $this->meetingRepository->find($id);
    
        if (!$meeting) {
            throw $this->createNotFoundException('Meeting not found');
        }
    
        $form = $this->createForm(MeetingUpdateTypeForm::class, $meeting);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarder l'utilisateur sélectionné temporairement
            $selectedOperator = $form->get('selectedOperator')->getData();
    
            // Envoyer un email uniquement à l'utilisateur avec job_title "Null"
            foreach ($meeting->getUsers() as $user) {
                if ($user->getJobTitle() === "Null") {
                    $context = [
                        'userId' => $user->getId(),
                        'user' => $user,
                        'meeting' => $meeting,
                    ];
                    if ($meeting->getStatus() == 3) {
                        $mail->send(
                            'acleanthis@gmail.com',
                            $user->getEmail(), // Send email to the customer
                            'Votre rendez-vous est confirmé',
                            'confirmation_meeting_admin',
                            $context,
                        );
                    } elseif ($meeting->getStatus() == 2) {
                        $mail->send(
                            'acleanthis@gmail.com',
                            $user->getEmail(), // Send email to the customer
                            'Merci, de confirmer votre rendez-vous',
                            'update_rdv',
                            $context,
                        );
                    } elseif ($meeting->getStatus() == 4) {
                        $mail->send(
                            'acleanthis@gmail.com',
                            $user->getEmail(), // Send email to the customer
                            'Votre rendez-vous est en attente de traitement un de nos opérateurs',
                            'en_attente_rdv',
                            $context,
                        );
                    }
                }
            }
    
            // Vérifier si l'utilisateur sélectionné n'est pas déjà associé à la réunion
            if ($selectedOperator && !$meeting->getUsers()->contains($selectedOperator)) {
                // Ajouter l'utilisateur sélectionné à la fin du processus
                $meeting->addUser($selectedOperator);
            }
    
            $this->entityManager->flush();
    
            $this->addFlash('success', 'Meeting updated successfully.');
            return $this->redirect('/admin?routeName=app_admin_meeting', 301);
        }
    
        return $this->render('admin/meeting/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/admin/meeting/validate/{id}', name: 'admin_meeting_validate')]
public function validateMeeting(Request $request, EntityManagerInterface $entityManager, $id): Response
{
    $meeting = $entityManager->getRepository(Meeting::class)->find($id);

    if (!$meeting) {
        throw $this->createNotFoundException('Le meeting n\'a pas été trouvé.');
    }

    // Modifier le statut du meeting
    $meeting->setStatus(5); // Assumons que 5 signifie "Terminé"
    $surface = $meeting-> getFloorSpace();
    $typeOperationRepo = $entityManager->getRepository(TypeOperation::class);
    // Créer une nouvelle opération
    $operation = new Operation();
    $operation->setMeeting($meeting);
    if ($surface <= 50) {
        $typeOperation = $typeOperationRepo->findOneBy(['label' => 'Petite']);
    } elseif ($surface > 50 && $surface <= 100) {
        $typeOperation = $typeOperationRepo->findOneBy(['label' => 'Moyenne']);
    } elseif ($surface > 100 && $surface <= 150) {
        $typeOperation = $typeOperationRepo->findOneBy(['label' => 'Grande']);
    } else {
        // Gérer le cas où la surface ne correspond à aucun critère défini
        $typeOperation = null; // ou définissez une valeur par défaut
    }
    $operation->setTypeOperation($typeOperation);
    $operation->setStatus(2);
    $operation->setIsValid(false); 
    $operation->setDescription($meeting->getDescription());
    $operation->setFloorSpace($meeting->getFloorSpace()); 

    $entityManager->persist($operation);
    $entityManager->flush();

    // Rediriger l'utilisateur ou envoyer une réponse
    return $this->redirectToRoute('admin');
}

}
