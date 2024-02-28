<?php 


declare(strict_types=1);

namespace App\Service;

use App\Repository\UsersRepository;
use App\Entity\Users;
use Doctrine\DBAL\Types\Types;
use PharIo\Manifest\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateAdminService
{
    public function __construct(
        private readonly UsersRepository $usersRepository,
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    { }


public function create(string $email, string $password , string $lastname , string $firstname ,string $phone_number , \DateTimeInterface $date_of_birthday  ): void
{
    $user = $this->usersRepository->findOneBy(['email' => $email]);

    if (!$user){
        $user = new Users();
    $user->setEmail($email);
    $user->setFirstname($firstname);
    $user->setLastname($lastname);
    $user->setPhoneNumber($phone_number);
    $user->setDateOfBirthday($date_of_birthday);
    $password = $this->passwordHasher->hashPassword($user, $password);
    $user->setPassword($password);
    }
   

    $user->setRoles(['ROLE_ADMIN']);
    
    $this->usersRepository->save($user , true);
}
}