<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtensionOperation extends AbstractExtension
{
    public function getFilters()
    {
        return [
            // Ensure method names match the actual method definitions
            new TwigFilter('operation_status_badge', [$this, 'operationStatusBadge']),
            new TwigFilter('operation_status', [$this, 'operationStatus']),
            new TwigFilter('operation_is_valid', [$this, 'operationisValid']),
            new TwigFilter('operation_is_valid_badge', [$this, 'operationisValidBadge'])

        ];
    }


    
    public function operationStatus($status)
    {
        switch ($status) {
            case 1:
                return "En attente";
            case 2:
                return "En cours";
            case 3:
                return "Terminée";
            case 4:
                return "Annulée";
            default:
                return "Statut d'opération inconnu";
        }
    }

    public function OperationStatusBadge($status)
    {
        switch ($status) {
            case 1:
                return "badge badge-warning text-dark";
            case 2:
                return "badge badge-info";
            case 3:
                return "badge badge-success";
            case 4:
                return "badge badge-danger";
            default:
                return "badge badge-secondary"; 
        }
    }

    public function operationisValid($isValid)
    {
        switch ($isValid) {
            case 0:
                return "En attente";
            case 1:
                return "Validé";
            
            default:
                return "Statut d'opération inconnu";
        }
    }

    public function operationisValidBadge($isValid)
    {
        switch ($isValid) {
            case 0:
                return "badge badge-warning text-dark";
            case 1:
                return "badge badge-success";
            default:
                return "badge badge-secondary"; 
        }
    }
}
