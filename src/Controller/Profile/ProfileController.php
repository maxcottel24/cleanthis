<?php

namespace App\Controller\Profile;

use App\Entity\Users;
use App\Form\UsersPasswordType;
use App\Repository\UsersRepository;
use App\Form\UsersType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


/**
 * @author Efflam <cefflam@gmail.com>
 */
class ProfileController extends AbstractController
{

    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }


    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        return $this->render('profile/profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }


    #[Route('/profile/edition/{id}', name: 'app_profile_edit' ,  methods: ['GET', 'POST'])]
    public function edit(Users $user, Request $request, EntityManagerInterface $manager): Response
    {
        if($this->getUser() == NULL) {
            return $this->redirectToRoute('app_login');
        }

        if($this->getUser() !== $user ){
            return $this->redirectToRoute('app_logout');
        }

        $form = $this->createForm(UsersType::class , $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ) {
            $user = $form->getData();
            $manager->persist($user);
            $manager->flush();
            $this->addFlash(
                'succes' ,
                'Les information de votre compte ont bien été modifié'
            );
            
        return $this->redirectToRoute('app_profile');
        }
        return $this->render('profile/profile/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/profile/edition/{id}/password', name: 'app_profile_edit_password' ,  methods: ['GET', 'POST'])]
    public function editPassword(Users $user, Request $request, EntityManagerInterface $manager): Response

    {
        if($this->getUser() == NULL) {
            return $this->redirectToRoute('app_login');
        }

        if($this->getUser() !== $user ){
            return $this->redirectToRoute('app_logout');
        }

        $form = $this->createForm(UsersPasswordType::class);

        return $this->render('profile/profile/editPassword.html.twig' , [
            'form' => $form->createView()
        ]);

    }
}
