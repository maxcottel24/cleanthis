<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiAdresseClient
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function search(string $query): array
    {
        $response = $this->client->request('GET', 'https://api-adresse.data.gouv.fr/search/', [
            'query' => ['q' => $query],
        ]);

        return $response->toArray();
    }
}

