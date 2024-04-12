<?php

namespace App\Service;

use Exception;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class ApiLog
{
    public function __construct(
        private HttpClientInterface $httpClient,
    ) {
    }

    public function postLog(array $logData): array
    {
        $requestData = [
            'loggerName' => $logData['loggerName'],
            'user' => $logData['user'],
            'level' => $logData['level'],
            'message' => $logData['message'],
            'data' => $logData['data']
        ];
        
        $requestJson = json_encode($requestData, JSON_THROW_ON_ERROR);

        $response = $this->httpClient->request('POST', 'http://localhost:5000/post', [
            'headers' => [
                'Content-Type: application/json',
                'Accept: application/json',
            ],
            'body' => $requestJson,
        ]);

        if (201 !== $response->getStatusCode()) {
            throw new Exception('Response status code is different than expected.');
        }

        // ... other checks

        $responseJson = $response->getContent();
        $responseData = json_decode($responseJson, true, 512, JSON_THROW_ON_ERROR);

        return $responseData;
    }
}