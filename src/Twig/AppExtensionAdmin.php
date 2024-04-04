<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtensionAdmin extends AbstractExtension
{
    public function getFilters()
    {
        return [
            // Ensure method names match the actual method definitions
            new TwigFilter('meeting_statuss_badge', [$this, 'meetingStatusBadge']), // Corrected method name
            new TwigFilter('meeting_statuss', [$this, 'meetingStatus']), // Corrected method name
            new TwigFilter('statuss_to_percent', [$this, 'statusToPercent']),
            new TwigFilter('operation_statuss', [$this, 'operationStatus']),
        ];
    }

    public function meetingStatus($status)
    {
        switch ($status) {
            case 1:
                return "Nouveau RDV";
            case 2:
                return "En attente de retour client";
            case 3:
                return "Pris en charge";
            case 4:
                return "Intervention opérateur";
            case 5:
                return "Terminé";
            default:
                return "Statut inconnu";
        }
    }

    public function meetingStatusBadge($status)
    {
        switch ($status) {
            case 1:
                return 'badge badge-danger';
            case 2:
                return "badge badge-warning text-dark";
            case 3:
                return "badge badge-success";
            case 4:
                return "badge badge-info";
            case 5:
                return "badge badge-success";
            default:
                return "badge badge-secondary"; // It's better to return a default badge class than text
        }
    }

    public function operationStatus($status)
    {
        switch ($status) {
            case 1:
                return "Opération en attente";
            case 2:
                return "Opération en cours";
            case 3:
                return "Opération terminée";
            case 4:
                return "Opération annulée";
            default:
                return "Statut d'opération inconnu";
        }
    }

    public function statusToPercent($status)
    {
        switch ($status) {
            case 2:
                return 25;
            case 3:
                return 50;
            case 4:
                return 75;
            case 5:
                return 100;
            default:
                return 0;
        }
    }
}
