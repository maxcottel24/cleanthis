<?php

namespace App\Controller;

use App\Entity\Meeting;
use App\Entity\Users;
use App\Form\MeetingType;
use App\Repository\MeetingRepository;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class MeetingController extends AbstractController
{
    #[Route('/demande-de-devis', name: 'app_meeting')]
    public function sendMeeting(Request $request, EntityManagerInterface $manager, Security $security, SendMailService $mail, TranslatorInterface $translator): Response
    {
        $user = $security->getUser();
        if ($this->getUser() == NULL) {
            return $this->redirectToRoute('app_login');
        }
        if ($user->isIsVerified() == 0) {
            $message = $translator->trans('Votre compte n\'est pas vérifié.');
            $this->addFlash(
                'danger',
                $message
            );
            return $this->redirectToRoute('app_profile');
        }
        $meeting = new Meeting();
        $form = $this->createForm(
            MeetingType::class,
            $meeting,
            [
                'user' => $user,
            ]
        );
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $meeting->setStatus(1);
            if ($user) {
                $meeting->addUser($user);
            }

            if ($user) {
                $meeting->addUser($user);
            }



            $manager->persist($meeting);
            $manager->flush();

            $context = [

                'userId' => $user->getId(),
                'user' => $user,
                'meeting' => $meeting,
            ];

            $mail->send(
                'acleanthis@gmail.com',
                $user->getEmail(),
                'Demande de rendez vous reçue',
                'meeting_confirmation',
                $context
            );

            $message = $translator->trans('Votre demande de devis a été correctement enregistrée. Nous vous recontacterons dans les 48 heures qui suivent.');
            $this->addFlash(
                'success',
                $message
            );

            return $this->redirectToRoute('app_profile');
        }
        return $this->render('meeting/addMeeting.html.twig', [

            'form' => $form->createView(),
        ]);
    }


    #[Route('/meeting/{id}', name: 'app_meeting_index', methods: ['GET'])]
    public function index(int $id, MeetingRepository $meetingRepository, Security $security): Response
    {
        $user = $security->getUser();

        if ($user->getId() == $id) {

            $meetings = $meetingRepository->findByUser($user->getId());

            return $this->render('meeting/index.html.twig', [
                'meetings' => $meetings,
            ]);
        } else {
            return $this->redirectToRoute('app_home');
        }
    }

    #[Route('/meeting/{id}/edit', name: 'app_meeting_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Meeting $meeting, EntityManagerInterface $entityManager, Security $security, TranslatorInterface $translator): Response
    {
        $user = $security->getUser();
        if (!$meeting->getUsers()->contains($user)) {
            $this->addFlash('warning', 'Vous n’êtes pas autorisé à modifier ce rendez-vous.');
            return $this->redirectToRoute('app_meeting_index', ['id' => $user->getId()]);
        }

        $form = $this->createForm(MeetingType::class, $meeting, [
            'user' => $user,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager->flush();
            $message = $translator->trans('Rendez-vous mis à jour avec succès.');
            $this->addFlash('success', $message);
            return $this->redirectToRoute('app_meeting_index', ['id' => $user->getId()]);
        }

        return $this->render('meeting/edit.html.twig', [
            'meeting' => $meeting,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/meeting/delete/{id}', name: 'app_meeting_delete', methods: ['POST'])]
    public function delete(Request $request, Meeting $meeting, EntityManagerInterface $entityManager, Security $security, TranslatorInterface $translator): Response
    {
        $user = $security->getUser();
        if (!$meeting->getUsers()->contains($user)) {
            $message = $translator->trans('Vous n’êtes pas autorisé à supprimer ce rendez-vous.');
            $this->addFlash('warning', $message);
            return $this->redirectToRoute('app_meeting_index');
        }

        if ($this->isCsrfTokenValid('delete' . $meeting->getId(), $request->request->get('_token'))) {
            try {
                $entityManager->remove($meeting);
                $entityManager->flush();
                $message = $translator->trans('Le rendez-vous a été annulé avec succès.');
                $this->addFlash('success', $message);
            } catch (\Exception $e) {
                $message = $translator->trans('Une erreur est survenue lors de l\'annulation du rendez-vous.');
                $this->addFlash('warning', $message);
            }
        } else {
            $message = $translator->trans('Le token de sécurité est invalide.');
            $this->addFlash('danger', $message);
        }

        return $this->redirectToRoute('app_meeting_index', ['id' => $user->getId()]);
    }

    #[Route('/meeting/validate/{id}', name: 'app_meeting_validate', methods: ['GET', 'POST'])]
    public function validate(int $id, EntityManagerInterface $entityManager, Security $security, MeetingRepository $meetingRepository, TranslatorInterface $translator): Response
    {
        $user = $security->getUser();
        $meeting = $meetingRepository->find($id);

        // Vérifier si le rendez-vous existe et si l'utilisateur est associé au rendez-vous
        if (!$meeting || !$meeting->getUsers()->contains($user)) {
            $message = $translator->trans('Vous n’êtes pas autorisé à valider ce rendez-vous ou le rendez-vous n\'existe pas.');
            $this->addFlash('danger', $message);
            return $this->redirectToRoute('app_meeting_index', ['id' => $user->getId()]);
        }

        // Modifier le statut du rendez-vous
        $meeting->setStatus(3);
        $entityManager->persist($meeting);
        $entityManager->flush();

        $message = $translator->trans('Le rendez-vous a été validé avec succès.');
        $this->addFlash('success', $message);
        return $this->redirectToRoute('app_meeting_index', ['id' => $user->getId()]);
    }
}
