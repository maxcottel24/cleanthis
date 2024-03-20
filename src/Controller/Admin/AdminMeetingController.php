<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Form\EditAdminProfileType;
use App\Form\EditAdminPasswordType;
use App\Repository\MeetingRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminMeetingController extends AbstractController
{
    #[Route('/admin/meeting', name: 'app_admin_meeting')]
    public function index(UsersRepository $repository, MeetingRepository $meetingrepo): Response
    {   
        
        $users=$repository; 
        $meetings=$meetingrepo->findAll(); 
        //  dd($meetings);
        return $this->render('admin/meeting/index.html.twig', [
            'controller_name' => 'AdminMeetingController',
            'meetings' => $meetings, 
            'users' => $users
            
        ]);
    }
    
}