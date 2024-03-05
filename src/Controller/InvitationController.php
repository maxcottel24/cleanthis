<?php

namespace App\Controller;

use Exception;
use App\Entity\Users;
use App\Entity\Invitation;
use App\Form\RegisterUsersType;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class InvitationController extends AbstractController
{

    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly EntityManagerInterface $entityManager,
    )
    {

    }

    #[Route('/invitation/{uuid}', name: 'app_invitation')]
    public function index(Invitation $invitation, Request $request, SendMailService $mail): Response
    {
        if ($invitation->getEmployee() !== null) {
            throw new Exception('This invitation has already been used.');
        }

        $user = new Users();
        $user->setEmail($invitation->getEmail());

        $form = $this->createForm(RegisterUsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            $noHash = $user->getPassword();
            $noHash = $this->userPasswordHasher->hashPassword($user, $noHash);
            $user->setPassword($noHash);

            $roles[] = 'ROLE_APPRENTI';
            $user->setRoles($roles);

            $invitation->setEmployee($user);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            // $uuid= $invitation->getUuid();
            // $url= $this->generateUrl('app_invitation', ['uuid' => $uuid], UrlGeneratorInterface::ABSOLUTE_URL);
            // $context= compact('url', 'invitation');
            // $mail->send(
            //     'acleanthis@gmail.com', 
            //     $invitation->getEmail(),
            //     'Création de votre compte professionel', 
            //     'invitation',  
            //     $context
            // );

            return $this->redirectToRoute('admin');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
