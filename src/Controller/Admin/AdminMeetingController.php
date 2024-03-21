<?php

namespace App\Controller\Admin;

use App\Entity\Meeting;
use App\Repository\MeetingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security as SecurityBundleSecurity;

class AdminMeetingController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/meeting', name: 'app_admin_meeting')]
    public function index(Request $request): Response
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
            'eaContext' => $request->query->get('eaContext'),
            'menuIndex' => $request->query->get('menuIndex'),
            'submenu' => $request->query->get('submenuIndex')
        ]);
    }

    #[Route('/admin/meeting/handle/{id}', name: 'app_admin_meeting_handle', methods: ['POST'])]
    public function handleMeeting(Request $request, $id): Response
    {
        $meeting = $this->entityManager->getRepository(Meeting::class)->find($id);

        if (!$meeting) {
            throw $this->createNotFoundException('RDV non trouvé');
        }

        $meeting->setStatus(3);
        $this->entityManager->flush();

        $this->addFlash('success', 'RDV pris en charge avec succès.');

        return $this->redirectToRoute('app_admin_meeting');
    }
}

