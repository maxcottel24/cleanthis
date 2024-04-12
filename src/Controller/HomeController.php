<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @author Nacim <nacim.ouldrabah@gmail.com>
 */
class HomeController extends AbstractController 
{


    public function __construct()
    {
    }

    #[Route('/', 'app_home', methods: ['GET'])]
    public function index(): Response
    {

        

        return $this->render('home.html.twig');
    }
}