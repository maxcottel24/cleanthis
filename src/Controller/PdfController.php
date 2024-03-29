<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use App\Entity\Belong;
use App\Entity\Operation;
use Doctrine\ORM\EntityManagerInterface;
use TCPDF;

class PdfController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/generate-pdf/{id}', name: 'generate_pdf')]
    public function generatePdf($id): Response
    {
        // Récupération de l'opération par son ID
        $operation = $this->entityManager->getRepository(Operation::class)->find($id);
        if (!$operation) {
            throw $this->createNotFoundException(sprintf('L\'opération avec l\'ID "%s" n\'existe pas.', $id));
        }

        // Récupération de l'entité Belong
        $belong = $this->entityManager->getRepository(Belong::class)->findOneBy(['operation' => $operation]);
        if (!$belong) {
            throw $this->createNotFoundException('Aucune relation Belong trouvée pour cette opération.');
        }

        // Récupération de la facture
        $invoice = $belong->getInvoice();
        if (!$invoice) {
            throw $this->createNotFoundException('Aucune facture liée à cette opération.');
        }

        // Récupération de l'adresse associée au Meeting
        $meeting = $operation->getMeeting();
        if (!$meeting) {
            throw $this->createNotFoundException('Aucune réunion liée à cette opération.');
        }

        $address = $meeting->getAddress();
        if (!$address) {
            throw $this->createNotFoundException('Aucune adresse liée à cette réunion.');
        }

        $userWithJobTitleNull = null;

        // Supposons que getMeeting()->getUsers() retourne une Collection d'utilisateurs...
        $users = $meeting->getUsers();

        foreach ($users as $user) {
            if ($user->getJobTitle() === "Null") {
                $userWithJobTitleNull = $user;
                break; // Sortir de la boucle dès qu'un utilisateur correspondant est trouvé
            }
        }

        if (!$userWithJobTitleNull) {
            throw $this->createNotFoundException('Aucun utilisateur avec job_title "Null" trouvé pour cette réunion.');
        }

        // Configuration et création d'un nouveau document PDF avec TCPDF
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Votre Entreprise');
        $pdf->SetTitle('Facture ' . $invoice->getId());
        $pdf->SetSubject('Facture Opération');
        $pdf->SetKeywords('TCPDF, PDF, facture, test, guide');

        // Ajouter une page
        $pdf->AddPage();

        // Définir le contenu avec l'adresse
        $htmlContent = $this->renderView('pdf/invoice.html.twig', [
            'operation' => $operation,
            'invoice' => $invoice,
            'address' => $address,
            'user' => $userWithJobTitleNull
        ]);
        $pdf->writeHTML($htmlContent, true, false, true, false, '');

        // Nom du fichier PDF à générer
        $fileName = 'facture-' . $invoice->getId() . '-operation-' . $operation->getId() . '.pdf';

        // Envoi du fichier PDF au client pour téléchargement
        $pdf->Output($fileName, 'D');

        // Pour s'assurer que Symfony retourne une réponse HTTP valide
        return new Response('', Response::HTTP_OK, ['Content-Type' => 'application/pdf']);
    }

    #[Route('/view-pdf/{id}', name: 'view_pdf')]
    public function viewPdf($id): Response
    {
        // Récupération de l'opération, de l'entité Belong, de la facture et de l'adresse comme dans generatePdf
        $operation = $this->entityManager->getRepository(Operation::class)->find($id);
        if (!$operation) {
            throw $this->createNotFoundException(sprintf('L\'opération avec l\'ID "%s" n\'existe pas.', $id));
        }

        $belong = $this->entityManager->getRepository(Belong::class)->findOneBy(['operation' => $operation]);
        if (!$belong) {
            throw $this->createNotFoundException('Aucune relation Belong trouvée pour cette opération.');
        }

        $invoice = $belong->getInvoice();
        if (!$invoice) {
            throw $this->createNotFoundException('Aucune facture liée à cette opération.');
        }

        $meeting = $operation->getMeeting();
        if (!$meeting) {
            throw $this->createNotFoundException('Aucune réunion liée à cette opération.');
        }

        $address = $meeting->getAddress();
        if (!$address) {
            throw $this->createNotFoundException('Aucune adresse liée à cette réunion.');
        }
        
        $userWithJobTitleNull = null;

        // Supposons que getMeeting()->getUsers() retourne une Collection d'utilisateurs...
        $users = $meeting->getUsers();

        foreach ($users as $user) {
            if ($user->getJobTitle() === "Null") {
                $userWithJobTitleNull = $user;
                break; // Sortir de la boucle dès qu'un utilisateur correspondant est trouvé
            }
        }

        if (!$userWithJobTitleNull) {
            throw $this->createNotFoundException('Aucun utilisateur avec job_title "Null" trouvé pour cette réunion.');
        }
        // Configuration et création d'un nouveau document PDF avec TCPDF
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Votre Entreprise');
        $pdf->SetTitle('Facture ' . $invoice->getId());
        $pdf->SetSubject('Facture Opération');
        $pdf->SetKeywords('TCPDF, PDF, facture, test, guide');

        // Ajouter une page
        $pdf->AddPage();

        // Définir le contenu avec l'adresse
        $htmlContent = $this->renderView('pdf/invoice.html.twig', [
            'operation' => $operation,
            'invoice' => $invoice,
            'address' => $address,
            'user' => $userWithJobTitleNull
        ]);
        $pdf->writeHTML($htmlContent, true, false, true, false, '');

        // Envoyer le PDF au navigateur pour affichage
        $pdf->Output('facture-' . $invoice->getId() . '-operation-' . $operation->getId() . '.pdf', 'I');

        // La réponse HTTP est gérée par TCPDF, pas besoin de retourner une réponse ici
        exit;
    }
}
