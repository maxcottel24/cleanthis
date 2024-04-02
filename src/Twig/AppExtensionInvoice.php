<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtensionInvoice extends AbstractExtension
{
    public function getFilters()
    {
        return [
            // Ensure method names match the actual method definitions
            new TwigFilter('invoice_status_badge', [$this, 'invoiceStatusBadge']),
            new TwigFilter('invoice_status', [$this, 'invoiceStatus']),
        ];
    }


    
    public function invoiceStatus($status)
    {
        switch ($status) {
            case 1:
                return "En attente de paiement";
            case 2:
                return "Payé";
            default:
                return "Statut d'opération inconnu";
        }
    }

    public function invoiceStatusBadge($status)
    {
        switch ($status) {
            case 1:
                return "badge badge-danger";
            case 2:
                return "badge badge-success";
            default:
                return "badge badge-secondary"; 
        }
    }

   
}
