<?php

namespace App\Controller;

use App\Entity\Users;
use App\Service\JWTService;
use App\Form\RegisterUsersType;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManager;
use App\Service\SendMailService;
use Doctrine\ORM\Mapping\Entity;
use App\Security\AppAuthenticator;
use App\Repository\UsersRepository;
use App\Form\ResetPasswordRequestType;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security\UserAuthenticator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SecurityController extends AbstractController
{

    public const SCOPES = [
        'google' => [],
    ];

    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    #[Route(path: '/connexion', name: 'app_login', methods:['GET', 'POST'])]
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

    #[Route("/oauth/connect/{service}", name: 'auth_oauth_connect', methods:['GET'])]
    public function connect(string $service, ClientRegistry $clientRegistry): RedirectResponse
    {
        if (! in_array($service, array_keys(self::SCOPES), true)) {
            throw $this->createNotFoundException();
        }

        return $clientRegistry->getClient($service)->redirect(self::SCOPES[$service]); 
    }


    #[Route('/oauth/check/{service}', name: 'auth_oauth_check', methods:['GET', 'POST'])]
    public function check(): Response
    {
        return new Response(status: 200); 
    }


    #[Route('/inscription', 'security.registration', methods: ['GET', 'POST'])]
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHasher, Security $security, UserAuthenticatorInterface $userAuthenticator, AppAuthenticator $appAuthenticator, JWTService $jwt, SendMailService $mail): Response
    {

        $user = new Users();
        $form = $this->createForm(RegisterUsersType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $noHash = $user->getPassword();
            $noHash = $passwordHasher->hashPassword($user, $noHash);
            $user->setPassword($noHash);
            $roles[] = 'ROLE_USER';
            $user->setRoles($roles);
            $user->setIsVerified(false);

            $manager->persist($user);
            $manager->flush();

            //On génère le JWT de l'utilisateur
            $header = [
                "alg" => "HS256",
                "typ" => "JWT"
            ];
            $payload = [
                "user_id" => $user->getId()
            ];
            $jwtToken = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

            $mail->send(
                'acleanthis@gmail.com',
                $user->getEmail(),
                'Activation de votre compte sur notre site',
                'register',
                compact('user', 'jwtToken')
            );

            $token = new UsernamePasswordToken($user, 'main', $roles);
            $this->tokenStorage->setToken($token);

            return $this->redirectToRoute('app_address_inscription' , ['id' => $user->getId()], Response::HTTP_SEE_OTHER);

        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/oubli-pass', name: 'forgotten_password')]
    public function forgottenPassword(Request $request, UsersRepository $usersRepository, TokenGeneratorInterface $tokenGenerator, EntityManagerInterface $entityManagerInterface, SendMailService $mail): Response
    {
        $form = $this->createForm(ResetPasswordRequestType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //On cherche l'utilisateur par son email
            $user = $usersRepository->findOneByEmail($form->get('email')->getData());

            //On vérifie si l'utilisateur existe dans la bdd
            if ($user) {
                //On génère un token de réinitialisation
                $token = $tokenGenerator->generateToken();
                $user->setResetToken($token);

                $entityManagerInterface->persist($user);
                $entityManagerInterface->flush();

                //On génère un lien de réinitialisation du mot de passe
                $url = $this->generateUrl('reset_pass', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

                //On crée les données du mail
                $context = compact('url', 'user');

                //Envoi du mail
                $mail->send(
                    'acleanthis@gmail.com',
                    $user->getEmail(),
                    'Réinitialisation de mot de passe',
                    'password_reset',
                    $context
                );

                $this->addFlash('success', 'Email envoyé avec succès');
                return $this->redirectToRoute('app_login');
            }

            //$user est NULL
            $this->addFlash('danger', 'Un problème est survenu');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset_password_request.html.twig', [
            'requestPassForm' => $form->createView()
        ]);
    }

    #[Route('/oubli-pass/{token}', name:'reset_pass')]
    public function resetPass(string $token, Request $request, UsersRepository $usersRepository, EntityManagerInterface $entityManagerInterface, UserPasswordHasherInterface $passwordHasher): Response
    {
        //On vérifie si le token existe dans la bdd
        $user = $usersRepository->findOneByResetToken($token);
        
        if($user){
            $form = $this->createForm(ResetPasswordType::class);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                // On efface le token
                $user->setResetToken('');
                $user->setPassword(
                    $passwordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
                $entityManagerInterface->persist($user);
                $entityManagerInterface->flush();

                $this->addFlash('success', 'Mot de passe changé avec succès');
                return $this->redirectToRoute('app_login');
            }

            return $this->render('security/reset_password.html.twig', [
                'passForm' => $form->createView()
            ]);
        }
        $this->addFlash('danger', 'Jeton invalide');
        return $this->redirectToRoute('app_login');
    }


    #[Route('/verif/{jwtToken}', name: 'verify_user')]
    public function verifyUser($jwtToken, JWTService $jwt, UsersRepository $usersRepository, EntityManagerInterface $emi): Response
    {
        //On vérifie si le token est valide, n'a pas expiré et n'a pas été modifié
        if ($jwt->isValid($jwtToken) && !$jwt->isExpired($jwtToken) && $jwt->check($jwtToken, $this->getParameter('app.jwtsecret'))) {
            //On récupère le Payload
            $payload = $jwt->getPayload($jwtToken);

            //On récupère le user du token
            $user = $usersRepository->find($payload['user_id']);

            //On vérifie que l'utilisateur existe et n'a pas encore activé son compte
            if ($user && !$user->isIsVerified()) {
                $user->setIsVerified(true);
                $emi->flush($user);
                $this->addFlash('success', 'Utilisateur activé');
                return $this->redirectToRoute('app_profile');
            }
        }
        //Après vérification token non valide
        $this->addFlash('danger', 'Le token est invalide ou a expiré');
        return $this->redirectToRoute('app_login');
    }

    #[Route('/renvoiverif', name: 'resend_verif')]
    public function resendVerif(JWTService $jwt, SendMailService $mail, UsersRepository $usersRepository): Response
    {
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash(
                'danger',
                'Vous devez être connecté pour accéder à cette page'
            );
            return $this->redirectToRoute('app_login');
        }

        if ($user->isIsVerified()) {
            $this->addFlash(
                'warning',
                'Cet utilisateur est déjà activé'
            );
            return $this->redirectToRoute('app_profile');
        }

        //On génère le JWT de l'utilisateur
        //On crée le Header
        $header = [
            "alg" => "HS256",
            "typ" => "JWT"
        ];

        //On crée le Payload
        $payload = [
            "user_id" => $user->getId()
        ];

        //On génère le token
        $jwtToken = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

        //On envoie un mail
        $mail->send(
            'acleanthis@gmail.com',
            $user->getEmail(),
            'Activation de votre compte sur notre site',
            'register',
            compact('user', 'jwtToken')
        );
        $this->addFlash(
            'success',
            'Email de vérification envoyé'
        );
        return $this->redirectToRoute('app_profile');
    }

}
