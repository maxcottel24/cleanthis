<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegisterUsersType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\SecurityBundle\Security\UserAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SecurityController extends AbstractController
{

    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

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
public function registration(Request $request, EntityManagerInterface $manager  , UserPasswordHasherInterface $passwordHasher, Security $security, UserAuthenticatorInterface $userAuthenticator, AppAuthenticator $appAuthenticator) : Response {

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
        $token = new UsernamePasswordToken($user, 'main', $roles);
        $this->tokenStorage->setToken($token);
        return $this->redirectToRoute('app_address_new');
    }

    return $this->render('security/registration.html.twig' , [
        'form' => $form->createView(),
    ]);
}



}
