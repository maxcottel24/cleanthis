<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Entity\Belong;
use App\Entity\Address;
use App\Entity\Invoice;
use App\Entity\Meeting;
use App\Entity\Operation;
use App\Entity\TypeOperation;
use App\Repository\UsersRepository;
use App\Repository\BelongRepository;
use App\Repository\InvoiceRepository;
use App\Repository\MeetingRepository;
use App\Repository\OperationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminInvoiceController extends DashboardController
{

    private $entityManager;
    private $userRepository;
    private $meetingRepository;
    private $operation;
    private Security $security;
    private $belongRepository;
    private $invoiceRepository;

    public function __construct(Security $security, OperationRepository $operation, EntityManagerInterface $entityManager, MeetingRepository $meetingRepository, UsersRepository $userRepository, BelongRepository $belongRepository, InvoiceRepository $invoiceRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->meetingRepository = $meetingRepository;
        $this->operation = $operation;
        $this->security = $security;
        $this->belongRepository = $belongRepository;
        $this->invoiceRepository = $invoiceRepository;
    }

    #[Route('/admin/invoice', name:'app_admin_invoice', methods:['GET'])]
    public function index(): Response 
    {
        $invoices =  $this->entityManager->getRepository(Invoice::class)->findAll(); 
        $belongs = $this->entityManager->getRepository(Belong::class)->findAll();

        return $this->render('admin/invoice/index.html.twig', [
            'invoices' => $invoices,
            'belongs' => $belongs
        ]);
    }

}