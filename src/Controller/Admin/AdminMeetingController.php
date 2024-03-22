<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Entity\Address;
use App\Entity\Meeting;
use App\Form\MeetingFormType;
use App\Repository\UsersRepository;
use App\Repository\AddressRepository;
use App\Repository\MeetingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class AdminMeetingController extends DashboardController
{
    private $entityManager;
    private $userRepository;

    public function __construct(EntityManagerInterface $entityManager, UsersRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
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
    public function handleMeeting(Request $request, $id): Response
    {
        $meeting = $this->entityManager->getRepository(Meeting::class)->find($id);

        if (!$meeting) {
            throw $this->createNotFoundException('RDV non trouvé');
        }
        $user = $this->getUser();

        if (!$user instanceof Users) {
            throw new \RuntimeException('Aucun utilisateur connecté');
        }

        // Associer l'utilisateur au rendez-vous
        $meeting->addUser($user);
        $meeting->setStatus(3);
        $this->entityManager->flush();

        $this->addFlash('success', 'RDV pris en charge avec succès.');

        return $this->redirect('/admin?routeName=app_admin_meeting', 301);
    }

    #[Route('/admin/meeting/new/', name: 'app_admin_meeting_new', methods: ['GET', 'POST'])]
public function new(Request $request, Security $security): Response
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
        
        // Enregistrer le nouveau rendez-vous dans la base de données
        $this->entityManager->persist($meeting);
        
        // Ajouter les utilisateurs au rendez-vous
        $meeting->addUser($selectedUser);
        $meeting->addUser($currentUser);
        
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
    public function deleteMeeting(Request $request, $id): Response
    {
        $meeting = $this->entityManager->getRepository(Meeting::class)->find($id);

        if (!$meeting) {
            throw $this->createNotFoundException('RDV non trouvé.');
        }

        // Security check: Ensure that the user is allowed to delete the meeting.
        // This is a placeholder for your security logic, which might involve checking if the user has the right roles or permissions.
        // if (!$this->isUserAllowedToDeleteMeeting($meeting)) {
        //     throw new AccessDeniedException('You do not have permission to delete this meeting.');
        // }

        // CRSF token validation can also be added here for additional security

        // Delete the meeting from the database
        $this->entityManager->remove($meeting);
        $this->entityManager->flush();

        // Add a flash message to indicate success
        $this->addFlash('success', 'Rendez-vous supprimé avec succès.');

        // Redirect to the meeting index page
        return $this->redirect('/admin?routeName=app_admin_meeting', 301);
    }
}
