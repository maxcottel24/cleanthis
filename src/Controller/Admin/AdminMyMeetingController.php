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

class AdminMyMeetingController extends DashboardController
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

    #[Route('/admin/mymeeting', name: 'app_admin_my_meeting')]
    public function index(): Response
    {
        $user = $this->getUser();

        // Assurez-vous que $user n'est pas null avant de continuer
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        // Ici, utilisez directement $user pour filtrer les meetings.
        // Cette partie dépend de comment votre entité et relation sont configurées.
        // L'exemple suivant suppose que vous avez une méthode appropriée dans votre repository.
        $meetings = $this->meetingRepository->findByOperatorUser($user->getId());

        return $this->render('admin/meeting/mymeetingindex.html.twig', [
            'meetings' => $meetings,
        ]);
    }

    #[Route('/admin/mymeetings', name: 'app_admin_my_meetings')]
    public function mymeeting(): Response
    {
        $user = $this->getUser();

        // Assurez-vous que $user n'est pas null avant de continuer
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        // Ici, utilisez directement $user pour filtrer les meetings.
        // Cette partie dépend de comment votre entité et relation sont configurées.
        // L'exemple suivant suppose que vous avez une méthode appropriée dans votre repository.
        $meetings = $this->meetingRepository->findByOperatorUser($user->getId());

        return $this->render('admin/meeting/index.html.twig', [
            'meetings' => $meetings,
        ]);
    }
}
