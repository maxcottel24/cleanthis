<?php

namespace App\Controller;

use App\Entity\Belong;
use App\Entity\Invoice;
use App\Entity\Operation;
use App\Service\ApiLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @author Nacim <nacim.ouldrabah@gmail.com>
 */

class OperationController extends AbstractController 
{
    #[Route('/admin/operations', name:'admin_operations', methods:['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $operations = $entityManager->getRepository(Operation::class)->findAll();

        return $this->render('admin/meeting/index.html.twig', [
            'operations' => $operations,
        ]);
    }

    #[Route('operation/validate/{id}', name:'app_operation_customer_validate' , methods:['GET', 'POST'])]
    public function validate(Security $security, EntityManagerInterface $entityManager, int $id, ApiLog $apiLog): Response
    {

        $user = $security->getUser();
        $operation = $entityManager->getRepository(Operation::class)->find($id);
    
        if (!$operation) {
            throw $this->createNotFoundException('L\'opération n\'a pas été trouvée.');
        }
    
        // Modifier le statut de l'opération
        $operation->setStatus(3);
        $operation->setIsValid(true);
        $operation->setFinishedAt(new \DateTimeImmutable());
    
        // Créer une nouvelle facture
        $invoice = new Invoice();
        $invoice->setStatus(1); // Exemple: 1 pour "en attente de paiement"
        $invoice->setAmount($operation->getPrice()); // Définir selon la logique de votre application
    
        // Créer une nouvelle entité Belong pour lier l'opération à la facture
        $belong = new Belong();
        $belong->setCreatedAt(new \DateTime());
        $belong->setInvoice($invoice);
        $belong->setOperation($operation);
    
        $entityManager->persist($invoice);
        $entityManager->persist($belong);
        $entityManager->flush();

        $logData = [
            'loggerName' => 'opévalid',
            'user' => $user->getEmail(),
            'level' => 'INFO',
            'message' => 'opération valider par le client',
            'data' => [],
        ]; 

        try {
            $apiLog->postLog($logData);
        } catch (\Throwable $th) {
            
        }

        return $this->render('profile/index.html.twig');
    }
}
