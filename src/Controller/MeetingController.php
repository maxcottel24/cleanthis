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
    public function sendMeeting(Request $request, EntityManagerInterface $manager, Security $security, SendMailService $mail): Response
    {
        $user = $security->getUser();
        if ($this->getUser() == NULL) {
            return $this->redirectToRoute('app_login');
        }
        if ($user->isIsVerified() == 0) {
            $this->addFlash(
                'danger',
                "Votre compte n'est pas vérifié"
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

            // Optionnel : envoyer un e-mail 

            $this->addFlash(
                'success',
                'Votre demande de devis a été correctement enregistrée. Nous vous recontacterons dans les 48 heures qui suivent. Vous trouverez un résumé dans vos e-mails et dans vos commandes pour suivre votre demande.'
            );

            return $this->redirectToRoute('app_profile');
        }
        return $this->render('meeting/addMeeting.html.twig', [

            'form' => $form->createView(),
        ]);
    }


    #[Route('/meeting/{id}', name: 'app_meeting_index', methods: ['GET'])]
    public function index (int $id ,MeetingRepository $meetingRepository , Security $security ): Response
    {
        $user = $security->getUser();

        if ($user->getId() == $id ) {

            $meetings = $meetingRepository->findByUser($user->getId());

        return $this->render('meeting/index.html.twig', [
         'meetings' => $meetings,
        ]);
    } else {
        return $this->redirectToRoute('app_home'); }
    
    }

    #[Route('/meeting/{id}/edit', name: 'app_meeting_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, Meeting $meeting, EntityManagerInterface $entityManager, Security $security): Response
{
    $user = $security->getUser();
    if (!$meeting->getUsers()->contains($user)) {
        $this->addFlash('error', 'Vous n’êtes pas autorisé à modifier cette réunion.');
        return $this->redirectToRoute('app_meeting_index', ['id' => $user->getId()]);
    }

    $form = $this->createForm(MeetingType::class, $meeting, [
        'user' => $user,
    ]);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        

        $entityManager->flush();
        $this->addFlash('success', 'RDV mise à jour avec succès.');
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
        $this->addFlash('error', 'Vous n’êtes pas autorisé à supprimer ce RDV.');
        return $this->redirectToRoute('app_meeting_index');
    }

    if ($this->isCsrfTokenValid('delete'.$meeting->getId(), $request->request->get('_token'))) {
        try {
            $entityManager->remove($meeting);
            $entityManager->flush();
            $this->addFlash('success', 'Le RDV a été annulé avec succès.');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur est survenue lors de l\'annulation du RDV.');
        }
    } else {
        $this->addFlash('error', 'Le token de sécurité est invalide.');
    }

    return $this->redirectToRoute('app_meeting_index' , ['id' => $user->getId()]);
}
}