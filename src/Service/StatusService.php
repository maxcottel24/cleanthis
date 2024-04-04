<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @author Efflam <cefflam@gmail.com>
 */

class StatusService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function StatusToName(int $status): string
    {
        switch ($status) {
            case 1:
                return "Demande en attente de prise en charge[RDV non Confirmé]";
            case 2:
                return "Demande prise en charge [RDV Confirmé]";
            case 3:
                return ""; // Définissez un message approprié pour le statut 3
            default:
                return "Statut inconnu";
        }

    }
}