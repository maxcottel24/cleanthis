<?php

namespace App\Command;

use App\Service\CreateAdminService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use DateTime;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @author Efflam <cefflam@gmail.com>
 */


#[AsCommand(
    name: 'app:create-admin',
    description: 'Create a new admin user',
)]
class CreateAdminCommand extends Command
{
    
    public function __construct(
        private readonly CreateAdminService $createAdminService
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Email of admin user')
            ->addArgument('password', InputArgument::REQUIRED, 'password of admin user')
            ->addArgument('lastname', InputArgument::REQUIRED, 'lastname of admin user')
            ->addArgument('firstname', InputArgument::REQUIRED, 'firstname of admin user')
            ->addArgument('phone_number', InputArgument::REQUIRED, 'phone number of admin user')
            ->addArgument('date_of_birthday', InputArgument::REQUIRED, 'birthday of admin user')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $lastname = $input->getArgument('lastname');
        $firstname = $input->getArgument('firstname');
        $phone_number = $input->getArgument('phone_number');
        $date_of_birthday = DateTime::createFromFormat('Y-m-d', $input->getArgument('date_of_birthday'));

        $this->createAdminService->create($email , $password , $lastname , $firstname , $phone_number , $date_of_birthday);

        $io->success('Successfuly created admin user');

        return Command::SUCCESS;
    }
}
