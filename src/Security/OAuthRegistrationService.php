<?php

namespace App\Security; 

use App\Entity\Users; 
use App\Repository\UsersRepository; 
use League\OAuth2\Client\Provider\GoogleUser; 
use League\OAuth2\Client\Provider\ResourceOwnerInterface; 

/**
 * @author Nacim <nacim.ouldrabah@gmail.com>
 */

final readonly class OAuthRegistrationService
{
    public function __construct(
        private UsersRepository $repository
    ){ 
    }


    /**
     * @param GoogleUser $resourceOwner
     */
    public function persist(ResourceOwnerInterface $resourceOwner) : Users 
    {

        $user = (new Users()) 
                ->setEmail($resourceOwner->getEmail())
                ->setGoogleId($resourceOwner->getId())
                ->setFirstname($resourceOwner->getFirstName())
                ->setRoles(["ROLE_USER"])
                ->setIsVerified(false)
                ; 

        $this->repository->add($user, true); 
        return $user;
    }


}