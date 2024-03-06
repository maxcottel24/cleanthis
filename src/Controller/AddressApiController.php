<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\ApiAdresseClient;

class AddressApiController extends AbstractController
{
    /**=
      @Route("/api/search_address", name="api_search_address")
     */
    public function search(ApiAdresseClient $apiAdresseClient, Request $request): Response
    {
        $query = $request->query->get('query');
        $results = $apiAdresseClient->search($query);

        return $this->json($results);
    }
}