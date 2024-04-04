<?php

namespace App\Service;

use TCPDF;
use App\Entity\Users;
use Twig\Environment;
use App\Entity\Address;
use App\Entity\Invoice;
use App\Entity\Operation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * @author Nacim <nacim.ouldrabah@gmail.com>
 */

class PdfService
{
    private $twig;
    private $entityManager;
    private $parameterBag;

    public function __construct(Environment $twig, ParameterBagInterface $parameterBag, EntityManagerInterface $entityManager)
    {
        $this->twig = $twig;
        $this->parameterBag = $parameterBag;
        $this->entityManager = $entityManager;
    }

    public function generateInvoicePdf(Invoice $invoice, Operation $operation, Users $user, Address $address): string
    {
        $pdf = new TCPDF();

        // Configurations de base du document PDF
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
        $pdf->AddPage();

        // Chemins des images utilisées dans le template PDF
        $publicDirectory = $this->parameterBag->get('kernel.project_dir') . '/public';
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

        // Rendu du template Twig en HTML
        $htmlContent = $this->twig->render('/pdf/invoice.html.twig', [
            'invoice' => $invoice,
            'operation' => $operation,
            'user' => $user,
            'address' => $address,
            'logoPath' => $logoPath,
            'tamponPath' => $tamponPath,
            'signaturePath' => $signaturePath,
            'paidPath' => $paidPath
        ]);

        // Conversion du HTML en PDF
        $pdf->writeHTML($htmlContent, true, false, true, false, '');

        // Définition du chemin de sauvegarde temporaire du fichier PDF
        $pdfFilePath = sys_get_temp_dir() . '/invoice-' . $invoice->getId() . '.pdf';

        // Sauvegarde du fichier PDF sur le serveur
        $pdf->Output($pdfFilePath, 'F');

        return $pdfFilePath;
    }
}
