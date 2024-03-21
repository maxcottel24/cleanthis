<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Entity\Meeting;
use App\Form\MeetingFormType;
use App\Repository\MeetingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminMeetingController extends AbstractController
{
    private $entityManager;
    private $meetingRepository;

    public function __construct(EntityManagerInterface $entityManager, MeetingRepository $meetingRepository)
    {
        $this->entityManager = $entityManager;
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
    public function handleMeeting(Request $request, $id,): Response
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

        return $this->redirectToRoute('admin');
    }


    #[Route('/admin/meeting/new/', name: 'app_admin_meeting_new', methods: ['GET', 'POST'])]
public function new(Request $request): Response
{
    // Créer une nouvelle instance de Meeting
    $meeting = new Meeting();

    // Créer un formulaire pour le nouveau rendez-vous
    $formMeeting = $this->createForm(MeetingFormType::class, $meeting, [
        'user' => $this->getUser(),
    ]);

    // Traiter la requête
    $formMeeting->handleRequest($request);

    // Vérifier si le formulaire a été soumis et est valide
    if ($formMeeting->isSubmitted() && $formMeeting->isValid()) {
        // Récupérer l'utilisateur sélectionné dans le formulaire
        $selectedUser = $formMeeting->get('selectedUser')->getData();

        // Ajouter l'utilisateur sélectionné au rendez-vous
        if ($selectedUser) {
            $meeting->addUser($selectedUser);
        }

        // Ajouter l'utilisateur connecté (opérateur) au rendez-vous
        $currentUser = $this->getUser();
        if ($currentUser) {
            $meeting->addUser($currentUser);
        }

        // Sauvegarder le nouveau rendez-vous en base de données
        $this->entityManager->persist($meeting);
        $this->entityManager->flush();

        // Ajouter un message flash pour indiquer que le rendez-vous a été créé avec succès
        $this->addFlash('success', 'Nouveau rendez-vous créé avec succès.');

        

        // Rediriger vers la page de liste des rendez-vous
        return $this->redirect('/admin?routeName=app_admin_meeting', 301);
    }

    $users = $this->entityManager->getRepository(Users::class)->findAll();
    $userData = [];
    foreach ($users as $user) {
        $addresses = $user->getAddresses(); // Cela renvoie une collection d'adresses
    
        // Vous pouvez choisir la première adresse, par exemple
        $address = $addresses->first(); // Assurez-vous qu'une adresse existe
    
        if ($address) {
            $userData[$user->getId()] = [
                'name' => $user->getFirstname() . ' ' . $user->getLastname(),
                'address' => [
                    'street' => $address->getStreet(),
                    'city' => $address->getCity(),
                    'zipcode' => $address->getZipcode()
                ]
            ];
        } else {
            // Gérer le cas où l'utilisateur n'a pas d'adresse
            $userData[$user->getId()] = [
                'name' => $user->getFirstname() . ' ' . $user->getLastname(),
                'address' => null
            ];
        }
    }

    // Rendre le formulaire pour créer un nouveau rendez-vous
    return $this->render('admin/meeting/new.html.twig', [
        'form' => $formMeeting->createView(),
        'userData' => $userData
    ]);
}
}
