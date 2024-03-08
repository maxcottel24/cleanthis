<?php

namespace App\Security;

use App\Entity\Users;
use App\Repository\UsersRepository;
use App\Security\AbstractOAuthAuthenticator;
use League\OAuth2\Client\Provider\GoogleUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use League\OAuth2\Client\Provider\ResourceOwnerInterface; 
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;

class GoogleAuthenticator extends AbstractOAuthAuthenticator
{
    
    protected string $serviceName = 'google'; 

    protected function getUserFromResourceOwner(ResourceOwnerInterface $resourceOwner, UsersRepository $repository): ?Users
    {
        if (!($resourceOwner instanceof GoogleUser)) {
           throw new \RuntimeException("expecting google user"); 
        }

        $existingUser = $repository->findOneByEmail($resourceOwner->getEmail());
    if ($existingUser) {
        return $existingUser;
    }

        if (true !== ($resourceOwner->toArray()['email_verified'] ?? null)) {
            throw new AuthenticationException("email not verified"); 
        }

        return $repository->findOneBy([
            'google_id' => $resourceOwner->getId(), 
            'email' => $resourceOwner->getEmail(),
            'lastname' => $resourceOwner->getFirstName(),
            'firstname' => $resourceOwner->getLastName()
        ]); 
    }

}
