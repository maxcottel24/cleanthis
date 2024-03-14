<?php

namespace App\Controller;

use Exception;
use App\Entity\Users;
use App\Entity\Invitation;
use App\Service\SendMailService;
use App\Form\RegisterEmployeeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InvitationController extends AbstractController
{

    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly EntityManagerInterface $entityManager,
    )
    {

    }

    #[Route('/invitation/{uuid}', name: 'app_invitation')]
    public function index(Invitation $invitation, Request $request): Response
    {
        if ($invitation->getEmployee() !== null) {
            throw new Exception('This invitation has already been used.');
        }

        $user = new Users();
        $user->setEmail($invitation->getEmail());

        $form = $this->createForm(RegisterEmployeeType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            $noHash = $user->getPassword();
            $noHash = $this->userPasswordHasher->hashPassword($user, $noHash);
            $user->setPassword($noHash);
            $user->setJobTitle('Opérateur');

            $roles[] = $invitation->getRoles();
            $user->setRoles($roles);
            $user->setIsVerified(true);

            $invitation->setEmployee($user);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            
            return $this->redirectToRoute('admin');
        }

        return $this->render('security/registration_employee.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
