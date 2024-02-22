<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Users;
use App\Repository\UsersRepository;
use DateTimeImmutable;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateAdminService
{
    public function __construct(private readonly UsersRepository $usersRepository, private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function create(string $email, string $password): void
    {
        $user = $this->usersRepository->findOneBy(['email' => $email]);

        if (!$user) {
            $user = new Users();
            $user->setEmail($email);

            $password = $this->passwordHasher->hashPassword($user, $password);
            $user->setPassword($password);
        }

        $user->setRoles(['ROLE_ADMIN']);

        $this->usersRepository->save($user, true);
    }
}
