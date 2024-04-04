<?php

namespace App\Controller;

use TCPDF;
use App\Entity\Belong;
use App\Entity\Invoice;
use App\Entity\Operation;
use App\Service\SendMailService;
use App\Repository\BelongRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @author Nacim <nacim.ouldrabah@gmail.com>
 */

class PdfController extends AbstractController
{
    private $entityManager;
    private BelongRepository $belongRepository;

    public function __construct(EntityManagerInterface $entityManager,  BelongRepository $belongRepository)
    {
        $this->entityManager = $entityManager;
        $this->belongRepository = $belongRepository;
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
        $pdf->SetAuthor('CleanThis');
        $pdf->SetTitle('Facture ' . $invoice->getId());
        $pdf->SetSubject('Facture Opération');
        $pdf->SetKeywords('TCPDF, PDF, facture, test, guide');
        $pdf->SetMargins(5, 1, 5);
        $pdf->SetFooterMargin(5);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));
        // Ajouter une page
        $pdf->AddPage();

        // Définir le chemin du logo.
        // Assurez-vous d'utiliser le chemin correct ici. Si vous utilisez Symfony, vous pouvez obtenir le chemin absolu comme ceci :
        $publicDirectory = $this->getParameter('kernel.project_dir') . '/public';
        $logoPath = $publicDirectory . '/assets/images/Logo.jpg';
        $paidPath = $publicDirectory . '/assets/images/aquitter.jpg';
        $signaturePath = $publicDirectory . '/assets/images/signature.jpg';
        $tamponPath = $publicDirectory . '/assets/images/tampon.jpg';

        // Vérifier si le fichier existe pour éviter des erreurs dans le PDF
        if (!file_exists($logoPath)) {
            throw new \Exception("Le fichier logo n'existe pas dans le chemin spécifié : " . $logoPath);
        }
        if (!file_exists($paidPath)) {
            throw new \Exception("Le fichier logo n'existe pas dans le chemin spécifié : " . $paidPath);
        }
        if (!file_exists($signaturePath)) {
            throw new \Exception("Le fichier logo n'existe pas dans le chemin spécifié : " . $signaturePath);
        }
        if (!file_exists($tamponPath)) {
            throw new \Exception("Le fichier logo n'existe pas dans le chemin spécifié : " . $tamponPath);
        }
        // Définir le contenu avec l'adresse et inclure une image
        $htmlContent = $this->renderView('pdf/invoice.html.twig', [
            'operation' => $operation,
            'invoice' => $invoice,
            'address' => $address,
            'user' => $userWithJobTitleNull,
            'logoPath' => $logoPath,
            'tamponPath' => $tamponPath,
            'signaturePath' => $signaturePath,
            'paidPath' => $paidPath

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
        $pdf->SetAuthor('CleanThis');
        $pdf->SetTitle('Facture ' . $invoice->getId());
        $pdf->SetSubject('Facture Opération');
        $pdf->SetKeywords('TCPDF, PDF, facture, test, guide');
        $pdf->SetMargins(5, 1, 5);
        $pdf->SetFooterMargin(5);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));
        // Ajouter une page
        $pdf->AddPage();

        // Définir le chemin du logo.
        // Assurez-vous d'utiliser le chemin correct ici. Si vous utilisez Symfony, vous pouvez obtenir le chemin absolu comme ceci :
        $publicDirectory = $this->getParameter('kernel.project_dir') . '/public';
        $logoPath = $publicDirectory . '/assets/images/Logo.jpg';
        $paidPath = $publicDirectory . '/assets/images/aquitter.jpg';
        $signaturePath = $publicDirectory . '/assets/images/signature.jpg';
        $tamponPath = $publicDirectory . '/assets/images/tampon.jpg';

        // Vérifier si le fichier existe pour éviter des erreurs dans le PDF
        if (!file_exists($logoPath)) {
            throw new \Exception("Le fichier logo n'existe pas dans le chemin spécifié : " . $logoPath);
        }
        if (!file_exists($paidPath)) {
            throw new \Exception("Le fichier logo n'existe pas dans le chemin spécifié : " . $paidPath);
        }
        if (!file_exists($signaturePath)) {
            throw new \Exception("Le fichier logo n'existe pas dans le chemin spécifié : " . $signaturePath);
        }
        if (!file_exists($tamponPath)) {
            throw new \Exception("Le fichier logo n'existe pas dans le chemin spécifié : " . $tamponPath);
        }
        // Définir le contenu avec l'adresse et inclure une image
        $htmlContent = $this->renderView('pdf/invoice.html.twig', [
            'operation' => $operation,
            'invoice' => $invoice,
            'address' => $address,
            'user' => $userWithJobTitleNull,
            'logoPath' => $logoPath,
            'tamponPath' => $tamponPath,
            'signaturePath' => $signaturePath,
            'paidPath' => $paidPath

        ]);
        $pdf->writeHTML($htmlContent, true, false, true, false, '');

        // Envoyer le PDF au navigateur pour affichage
        $pdf->Output('facture-' . $invoice->getId() . '-operation-' . $operation->getId() . '.pdf', 'I');

        exit; // Pas besoin de retourner une réponse ici, TCPDF s'en charge
    }



    
}
