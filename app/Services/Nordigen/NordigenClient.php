<?php

namespace App\Services\Nordigen;

use App\Http\Client\Client;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

class NordigenClient extends Client implements NordigenClientInterface
{
    public function request(string $method, $uri = '', array $options = []): ResponseInterface
    {
        $response = parent::request($method, $uri, $options);

        $this->log(
            [
                'uri' => $uri,
                'method' => $method,
                'options' => $options
            ],
            $response
        );

        return $response;
    }

    public function log(array $clientParameters, ResponseInterface $response): void
    {
        $log = [
            'type' => '[NordigenClient Requests Log]',
            'time' => time(),
            'meta' => [
                'client_parameters' => $clientParameters,
                'response' => [
                    'status_code' => $response->getStatusCode(),
                    'body' => $response->getBody(),
                    'headers' => $response->getHeaders(),
                    'protocol_version' => $response->getProtocolVersion()
                ]
            ]
        ];

        Log::debug(
            json_encode($log)
        );
    }
}
