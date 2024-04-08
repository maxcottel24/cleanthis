<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

/**
 * @author Nacim <nacim.ouldrabah@gmail.com>
 */

class SendMailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(
        string $from,
        string $to,
        string $subject,
        string $template,
        array $context,
        string $pdfPath = null // Ajoutez un paramètre optionnel pour le chemin du fichier PDF
    ): void {
        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->htmlTemplate("email/$template.html.twig")
            ->context($context);

        // Vérifiez si un chemin de fichier PDF a été fourni et que le fichier existe
        if ($pdfPath !== null && file_exists($pdfPath)) {
            $email->attachFromPath($pdfPath, 'NomDuFichier.pdf', 'application/pdf');
            // Vous pouvez personnaliser 'NomDuFichier.pdf' avec le nom souhaité pour la pièce jointe
        }

        $this->mailer->send($email);
    }

    public function sendEmailWithPdfAttachment(string $to, $invoice, string $pdfPath): void
    {
        // Assurez-vous que le fichier existe
        if (!file_exists($pdfPath)) {
            throw new \Exception("Le fichier PDF n'existe pas : $pdfPath");
        }

        $email = (new TemplatedEmail())
            ->from('from@example.com')
            ->to($to)
            ->subject('Votre Facture')
            // Chemin vers le template Twig de votre email
            ->htmlTemplate('email/invoice_paid.html.twig')
            ->context([
                'invoice' => $invoice,
            ])
            // Ajout de la pièce jointe
            ->attachFromPath($pdfPath, 'facture.pdf', 'application/pdf');

        $this->mailer->send($email);
    }

    public function sendRecruitment(
        string $from,
        string $to,
        string $subject,
        string $template,
        array $context,
        string $cvPath = null, // Chemin vers le CV
        string $letterPath = null // Chemin vers la lettre de motivation
    ): void {
        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->htmlTemplate("email/$template.html.twig")
            ->context($context);
    
        // Attachez le CV s'il est fourni et existe
        if ($cvPath !== null && file_exists($cvPath)) {
            $email->attachFromPath($cvPath, 'CV.pdf', 'application/pdf');
        }
    
        // Attachez la lettre de motivation si elle est fournie et existe
        if ($letterPath !== null && file_exists($letterPath)) {
            $email->attachFromPath($letterPath, 'LettreDeMotivation.pdf', 'application/pdf');
        }
    
        $this->mailer->send($email);
    }
    
}
