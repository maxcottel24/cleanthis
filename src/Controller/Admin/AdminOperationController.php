<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Entity\Belong;
use App\Entity\Address;
use App\Entity\Invoice;
use App\Entity\Meeting;
use App\Entity\Operation;
use App\Form\OperationType;
use App\Entity\TypeOperation;
use App\Form\MeetingFormType;
use App\Service\SendMailService;
use App\Form\MeetingUpdateTypeForm;
use App\Repository\UsersRepository;
use App\Repository\AddressRepository;
use App\Repository\MeetingRepository;
use App\Repository\OperationRepository;
use App\Service\ApiLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;


/**
 * @author Nacim <nacim.ouldrabah@gmail.com>
 */

class AdminOperationController extends DashboardController
{
    private $entityManager;
    private $userRepository;
    private $meetingRepository;
    private $operation;
    private Security $security;

    public function __construct(Security $security, OperationRepository $operation, EntityManagerInterface $entityManager, MeetingRepository $meetingRepository, UsersRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->meetingRepository = $meetingRepository;
        $this->operation = $operation;
        $this->security = $security;
    }

    #[Route('/admin/operation', name: 'app_admin_operation', methods: ['GET'])]
    public function index(): Response
    {
        $operations = $this->entityManager->getRepository(Operation::class)->findAll();

        return $this->render('admin/operation/index.html.twig', [
            'operations' => $operations,
        ]);
    }

    #[Route('/admin/operation/update/{id}', name: 'app_admin_operation_update', methods: ['GET', 'POST'])]
    public function update(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $operation = $entityManager->getRepository(Operation::class)->find($id);

        if (!$operation) {
            throw $this->createNotFoundException('L\'opération n\'a pas été trouvée.');
        }


        $form = $this->createForm(OperationType::class, $operation);
        $form->handleRequest($request);

        $surface = $operation->getFloorSpace();
        $cleanliness = $operation->getCleanliness();
        $typeOperationRepo = $entityManager->getRepository(TypeOperation::class);

        // Définir le type d'opération basé sur la surface
        if ($surface <= 50) {
            $typeOperation = $typeOperationRepo->findOneBy(['label' => 'Petite']);
        } elseif ($surface > 50 && $surface <= 100) {
            $typeOperation = $typeOperationRepo->findOneBy(['label' => 'Moyenne']);
        } elseif ($surface > 100 && $surface <= 150) {
            $typeOperation = $typeOperationRepo->findOneBy(['label' => 'Grosse']);
        } elseif ($surface > 150) {
            $typeOperation = $typeOperationRepo->findOneBy(['label' => 'Custom']); // ou définissez une valeur par défaut
        }

        if ($typeOperation) {
            $operation->setTypeOperation($typeOperation);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $price = 0; // Prix par défaut
            $surface = $operation->getFloorSpace();
            $cleanliness = $operation->getCleanliness();

            if ($surface <= 50) {
                switch ($cleanliness) {
                    case 1: // Normal
                        $price = $surface * 10; // Exemple de prix pour <= 50m² et Normal
                        break;
                    case 2: // Sale
                        $price = $surface * 15; // Exemple de prix pour <= 50m² et Sale
                        break;
                    case 3: //très sale
                        $price = $surface * 20;
                        // Ajoutez plus de cas selon votre tarification
                }
            } elseif ($surface > 50 && $surface <= 100) {
                // Logique similaire pour d'autres plages de surface
                switch ($cleanliness) {
                    case 1: // Normal
                        $price = $surface * 15; // Exemple de prix pour <= 50m² et Normal
                        break;
                    case 2: // Sale
                        $price = $surface * 20; // Exemple de prix pour <= 50m² et Sale
                        break;
                    case 3: //très sale
                        $price = $surface * 25;
                        // Ajoutez plus de cas selon votre tarification
                }
            } elseif ($surface > 100 && $surface <= 150) {
                switch ($cleanliness) {
                    case 1: // Normal
                        $price = $surface * (10 * 2); // Exemple de prix pour <= 50m² et Normal
                        break;
                    case 2: // Sale
                        $price = $surface * (14 * 2); // Exemple de prix pour <= 50m² et Sale
                        break;
                    case 3: //très sale
                        $price = $surface * (16.67 * 2);
                        // Ajoutez plus de cas selon votre tarification
                }
            } elseif ($surface > 150) {
                switch ($cleanliness) {
                    case 1: // Normal
                        $price = $surface * (10 * 2); // Exemple de prix pour <= 50m² et Normal
                        break;
                    case 2: // Sale
                        $price = $surface * (14 * 2); // Exemple de prix pour <= 50m² et Sale
                        break;
                    case 3: //très sale
                        $price = $surface * (16.67 * 2);
                }
            }
            $discount = $operation->getDiscount();
            $price = $price * $discount;
            $operation->setPrice($price);

            $entityManager->flush();

            $this->addFlash('success', 'L\'opération a été mise à jour avec succès. Prix calculé: ' . $operation->getPrice() . ' €');

            return $this->redirectToRoute('app_admin_operation', [], Response::HTTP_SEE_OTHER);
        }

        // Ce return couvre tous les cas, y compris si le formulaire n'est pas soumis ou n'est pas valide.
        return $this->render('admin/operation/update.html.twig', [
            'operation' => $operation,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/myoperation', name: 'app_admin_myoperation')]
    public function myoperation(): Response
    {
        $user = $this->security->getUser();

        // Assurez-vous que l'utilisateur est connecté
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        // Assurez-vous que l'utilisateur a le job_title "Opérateur"
        if ($user->getJobTitle() !== 'Opérateur') {
            throw $this->createAccessDeniedException('Seuls les opérateurs peuvent accéder à cette page.');
        }

        // Utilisez la méthode findOperationsByUser de votre OperationRepository
        $operations = $this->operation->findOperationsByUser($user);

        return $this->render('admin/operation/index.html.twig', [
            'operations' => $operations,
        ]);
    }

    #[Route('/admin/myoperation/past', name: 'app_admin_my_past_operation')]
    public function myoperations(): Response
    {
        $user = $this->security->getUser();

        // Assurez-vous que l'utilisateur est connecté
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        // Assurez-vous que l'utilisateur a le job_title "Opérateur"
        if ($user->getJobTitle() !== 'Opérateur') {
            throw $this->createAccessDeniedException('Seuls les opérateurs peuvent accéder à cette page.');
        }

        // Utilisez la méthode findOperationsByUser de votre OperationRepository
        $operations = $this->operation->findOperationsByUser($user);

        return $this->render('admin/operation/myoperation.html.twig', [
            'operations' => $operations,
        ]);
    }



    #[Route('/admin/operation/validate/{id}', name: 'app_admin_operation_validate')]
    public function validateOperation(Request $request, EntityManagerInterface $entityManager, $id, Security $security, SendMailService $sendMailService, ApiLog $apiLog): Response
    {
        $operator = $user = $security->getUser();

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
    
        // Trouver l'utilisateur avec le jobTitle "Null" dans le meeting associé
        $meeting = $operation->getMeeting();
        if ($meeting) {
            foreach ($meeting->getUsers() as $user) {
                if ($user->getJobTitle() === "Null") {
                    // Envoie un email à cet utilisateur
                    $sendMailService->send(
                        'email@votre-domaine.com',
                        $user->getEmail(),
                        'Opération Validée',
                        'operation_validee',
                        ['user' => $user, 'operation' => $operation]
                    );
                    break; // Arrête la boucle une fois l'email envoyé
                }
            }
        }

        $logData = [
            'loggerName' => 'opévalid',
            'user' => $operator->getLastname(). " ".$operator->getFirstname(),
            'level' => 'INFO',
            'message' => 'opération valider par un employé ' ,
            'data' => [
                'price' => $invoice->getAmount()
            ]
        ]; 

        try {
            $apiLog->postLog($logData);
        } catch (\Throwable $th) {
            
        }
    
        // Rediriger l'utilisateur ou envoyer une réponse
        return $this->redirectToRoute('admin');
    }
    

}
