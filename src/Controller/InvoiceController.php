<?php

namespace App\Controller;

use App\Entity\Belong;
use App\Entity\Invoice;
use App\Service\PdfService;
use App\Service\SendMailService;
use App\Repository\InvoiceRepository;
use App\Service\ApiLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author Nacim <nacim.ouldrabah@gmail.com>
 */

class InvoiceController extends AbstractController
{
    #[Route('/invoice/payed/{id}', name: 'app_invoice_to_pay', methods: ['POST'])]
    public function toPay(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        InvoiceRepository $invoiceRepository,
        Security $security,
        PdfService $pdfService,
        SendMailService $sendMailService, 
        TranslatorInterface $translator,
        ApiLog $apiLog
    ) {
        $user = $security->getUser();
        $invoice = $invoiceRepository->find($id);

        if (!$invoice) {
            $message = $translator->trans('Facture non trouvée.');
            $this->addFlash('error', $message);
            return $this->redirectToRoute('app_home');
        }

        // Assurez-vous d'avoir une méthode pour récupérer Belong associé à Invoice
        $belong = $entityManager->getRepository(Belong::class)->findOneBy(['invoice' => $invoice]);
        if (!$belong) {
            $message = $translator->trans('Facture introuvable.');
            $this->addFlash('error', $message);
            return $this->redirectToRoute('app_profile');
        }

        $operation = $belong->getOperation();
        $meeting = $operation->getMeeting();
        $userWithJobTitleNull = $meeting->getUserWithJobTitleNull();
        
        $paymentMethod = $request->request->get('payment_method');
        if ($paymentMethod) {
            $invoice->setPaymentMethod($paymentMethod);
            $invoice->setStatus(2); // Supposons que 2 indique que la facture est payée
            $invoice->setClosingAt(new \DateTimeImmutable());
            $entityManager->flush();

            // Génération du PDF
            $pdfPath = $pdfService->generateInvoicePdf($invoice, $operation, $userWithJobTitleNull, $meeting->getAddress());

            // Envoi de l'email avec le PDF en pièce jointe
            $sendMailService->sendEmailWithPdfAttachment($user->getEmail(), $invoice, $pdfPath);

            $message = $translator->trans('La facture a été payée avec succès. Votre facture vous a été envoyé par mail.');
            $this->addFlash('success', $message);

            $type = $operation->getTypeOperation();

            if ($type == 1) {
                $operationType = 'Petite';
            } elseif ($type == 2) {
                $operationType = 'Moyenne';
            } elseif ($type == 3) {
                $operationType = 'Grosse';
            } else {
                $operationType = 'Custom';
            }

            $logData = [
                'loggerName' => 'payment',
                'user' => $user->getEmail(),
                'level' => 'INFO',
                'message' => 'vente',
                'data' => [
                    'method payment' => $invoice->getPaymentMethod(),
                    'price' => $invoice->getAmount(),
                    'type operation' => $operationType
                ],
            ]; 

            try {
                $apiLog->postLog($logData);
            } catch (\Throwable $th) {
                
            }

            // Supprimez le fichier PDF temporaire
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }
        } else {
            $message=$translator->trans('Veuillez sélectionner un moyen de paiement.'); 
            $this->addFlash('error', $message);
        }

        return $this->redirectToRoute('app_profile');
    }
}