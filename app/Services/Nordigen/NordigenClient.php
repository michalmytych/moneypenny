<?php

namespace App\Services\Nordigen;

use App\Http\Client\Client;
use Psr\Http\Message\ResponseInterface;
use App\Services\Logging\LoggingAdapterInterface;

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
                    'body' => $response->getBody()->getContents(),
                    'headers' => $response->getHeaders(),
                    'protocol_version' => $response->getProtocolVersion()
                ]
            ]
        ];

        app(LoggingAdapterInterface::class)->debug(
            json_encode($log)
        );
    }
}
