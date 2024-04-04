<?php

namespace App\Controller\Admin;

use App\Repository\MeetingRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OperationRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InvoiceRepository;

/**
 * @author Efflam <cefflam@gmail.com>
 */


class AdminChartController extends DashboardController
{   
    private $entityManager;
    private $userRepository;
    private $meetingRepository;
    private $operationRepository;
    private $invoiceRepository;
   

    public function __construct(OperationRepository $operationRepository, EntityManagerInterface $entityManager, MeetingRepository $meetingRepository, UsersRepository $userRepository ,  InvoiceRepository $invoiceRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->meetingRepository = $meetingRepository;
        $this->operationRepository = $operationRepository;
        $this->invoiceRepository = $invoiceRepository;
    }
   
    #[Route('/admin/chart', name: 'app_admin_chart')]
    public function index(): Response
    {

        $currentYear = date('Y');
        $currentMonth = date('n'); // Le mois actuel en chiffres sans les zéros initiaux (1 à 12)
        $currentQuarter = ceil($currentMonth / 3);

    $quartersToMonths = [
            1 => ['Janvier', 'Février', 'Mars'],
            2 => ['Avril', 'Mai', 'Juin'],
            3 => ['Juillet', 'Août', 'Septembre'],
            4 => ['Octobre', 'Novembre', 'Décembre']
    ];

    $labelsForCurrentQuarter = $quartersToMonths[$currentQuarter];

      $TypeOpRevenue =  $this->operationRepository->calculateTotalRevenueByOperationType();
      $TypeOpUse = $this->operationRepository->countTasksByOperationType();
      $CostPerUnit = $this->operationRepository->findCostPerUnit(); 
       
    $operationIDs = array_map(function($item) {
        return 'Op ' . $item['id']; // Assurez-vous que ceci correspond à vos IDs d'opération
    }, $CostPerUnit);

    $costsPerUnit = array_map(function($item) {
        return $item['costPerUnit'];
    }, $CostPerUnit);

    $averageCost = array_sum($costsPerUnit) / count($costsPerUnit);
    $averageCostData = array_fill(0, count($operationIDs), $averageCost);

    $monthlyRevenue = $this->invoiceRepository->findMonthlyRevenue();
    $quarterlyRevenue = $this->invoiceRepository->findQuarterlyRevenue();
    $annualRevenue = $this->invoiceRepository->findAnnualRevenue();

        return $this->render('admin/chart/index.html.twig', [
            'TypeOpRevenue' => $TypeOpRevenue,
            'TypeOpUse' => $TypeOpUse,
            'costsPerUnit' => $costsPerUnit,
            'averageCostData' => $averageCostData,
            'operationIDs' => $operationIDs,
            'monthlyRevenue' => $monthlyRevenue,
            'quarterlyRevenue' => $quarterlyRevenue,
            'annualRevenue' => $annualRevenue,
            'labelsForCurrentQuarter' => $labelsForCurrentQuarter,
        ]);

    }
}