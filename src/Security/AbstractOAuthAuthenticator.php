<?php

namespace App\Security;

use App\Entity\Users;
use App\Repository\UsersRepository;
use App\Service\ApiLog;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use KnpU\OAuth2ClientBundle\Client\OAuth2Client;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use KnpU\OAuth2ClientBundle\Client\OAuth2ClientInterface;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

/**
 * @author Nacim <nacim.ouldrabah@gmail.com>
 */


abstract class AbstractOAuthAuthenticator extends OAuth2Authenticator
{
    use TargetPathTrait; 
    protected string $serviceName = ''; 
    private $apiLog;

    public function __construct(
        private readonly ClientRegistry $clientRegistry,   
        private readonly RouterInterface $router, 
        private readonly UsersRepository $repository,  
        private readonly OAuthRegistrationService $registrationService,
        ApiLog $apiLog
        
    ){
        $this->apiLog = $apiLog;
        
    }

    public function supports(Request $request): ?bool
    {
        return 'auth_oauth_check' == $request->attributes->get('_route') && 
        $request->get('service') == $this->serviceName; 
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $targetPath = $this->getTargetPath($request->getSession(), $firewallName); 
        if ($targetPath) {
            return new RedirectResponse($targetPath); 
        }
        
        $roles = $token->getRoleNames();
        $user=$token->getUser(); 
    if (in_array('ROLE_SENIOR', $roles) || in_array('ROLE_APPRENTI', $roles) || in_array('ROLE_EXPERT', $roles) || in_array('ROLE_ADMIN', $roles)) {
        $logData = [
            'loggerName' => 'connexion',
            'user' => $user->getEmail(),
            'level' => 'INFO',
            'message' => 'Utilisateur connecté',
            'data' => [
            ]
        ];

        try {
            $this->apiLog->postLog($logData);
        } catch (\Throwable $th) {
        }
        return new RedirectResponse($this->router->generate('admin'));
    } else {
        $logData = [
            'loggerName' => 'connexion',
            'user' => $user->getEmail(),
            'level' => 'INFO',
            'message' => 'Utilisateur connecté',
            'data' => [
            ]
        ];

        try {
            $this->apiLog->postLog($logData);
        } catch (\Throwable $th) {
        }
        return new RedirectResponse($this->router->generate('app_profile'));
    }
        
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        if ($request->hasSession()) {
            $request->getSession()->set(SecurityRequestAttributes::AUTHENTICATION_ERROR, $exception); 
        }


        return new RedirectResponse($this->router->generate('app_login')); 
    }

    public function authenticate(Request $request): SelfValidatingPassport
{
    $credentials = $this->fetchAccessToken($this->getClient()); 
    $resourceOwner = $this->getResourceOwnerFromCredentials($credentials);
    $user = $this->getUserFromResourceOwner($resourceOwner, $this->repository); 

    $this->repository->getEntityManager()->beginTransaction();

    try {
        if (null == $user) {
            $user = $this->registrationService->persist($resourceOwner);
        }

        $this->repository->getEntityManager()->commit();
    } catch (\Exception $e) {
        $this->repository->getEntityManager()->rollback();
        throw $e;
    }

    return new SelfValidatingPassport(
        userBadge: new UserBadge($user->getUserIdentifier(), fn () => $user), 
        badges: [
            new RememberMeBadge()
        ]
    );
}


    protected function getResourceOwnerFromCredentials(AccessToken $credentials): ResourceOwnerInterface
    {
        return $this->getClient()->fetchUserFromToken($credentials); 
    }

    private function getClient(): OAuth2ClientInterface
    {
        return $this->clientRegistry->getClient($this->serviceName); 
    }

    abstract protected function getUserFromResourceOwner(ResourceOwnerInterface $resourceOwner, UsersRepository $repository): ?Users; 
}