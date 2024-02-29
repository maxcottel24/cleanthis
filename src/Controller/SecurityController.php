<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Users;
use App\Form\RegisterUsersType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_profile');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

#[Route('/inscription','security.registration',methods:['GET','POST'])]
public function registration(Request $request, EntityManagerInterface $manager  , UserPasswordHasherInterface $passwordHasher) : Response {

    
    $user = new Users();
    $form = $this->createForm(RegisterUsersType::class , $user);

    $form->handleRequest($request); 
    if ($form->isSubmitted() && $form->isValid()) {
        $user = $form->getData();
        $noHash = $user->getPassword();
        $noHash = $passwordHasher->hashPassword($user , $noHash);
        $user->setPassword($noHash);
        $roles[] = 'ROLE_USER';
        $user->setRoles($roles);
        $this->addFlash(
            'success',
            'Votre compte a bien été créé'
        );

        $manager->persist($user);
        $manager->flush();
        
        return $this->redirectToRoute('app_login');
    }

    return $this->render('security/registration.html.twig' , [
        'form' => $form->createView(),
    ]);
}

}
