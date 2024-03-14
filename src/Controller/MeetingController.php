<?php

namespace App\Controller;

use App\Entity\Meeting;
use App\Form\MeetingType;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
        return $this->render('meeting/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
