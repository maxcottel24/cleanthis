<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('meeting_status_badge', [$this, 'MeetingStatusBadge']),
            new TwigFilter('meeting_status', [$this, 'MeetingStatus']),
            new TwigFilter('status_to_percent', [$this, 'statusToPercent']),
            new TwigFilter('operation_status', [$this, 'operationStatus']),
        ];
    }

    public function meetingStatus($status)
    {
        switch ($status) {
            case 1:
                return "En attente de contact";
            case 2:
                return "En attente de prise en charge";
            case 3:
                return "RDV pris en charge";
            case 4:
                return "Modifier par l'operateur [veuillez confirmer]";
            default:
                return "Statut inconnu";
        }
    }
    public function meetingStatusBadge($status)
    {
        switch ($status) {
            case 1:
                return 'badge bg-secondary';
            case 2:
                return "badge bg-warning text-dark";
            case 3:
                return "badge bg-success";
            case 4:
                return "badge bg-warning text-dark";
            default:
                return "Statut inconnu";
        }
    }

    // Nouvelle méthode pour la traduction des statuts d'opération
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
            case 5 :
                return 100;
            default:
                return 0;
        }
    }



}




















?>