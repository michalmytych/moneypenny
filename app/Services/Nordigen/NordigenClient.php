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
        $clonedResponse = clone $response;

        data_set($options, 'headers.accept', 'application/json');
        data_set($options, 'headers.Content-Type', 'application/json');

        $this->logRequest(
            [
                'response_php_object_id' => spl_object_id($clonedResponse),
                'uri' => $uri,
                'method' => $method,
                'options' => $options
            ],
            $clonedResponse
        );

        return $response;
    }

    public function logRequest(array $clientParameters, ResponseInterface $response): void
    {
        $stream = $response->getBody();
        $body = $stream->getContents();

        $log = [
            'type' => '[NordigenClient Requests Log]',
            'time' => time(),
            'meta' => [
                'client_parameters' => $clientParameters,
                'response' => [
                    'status_code' => $response->getStatusCode(),
                    'body' => $body,
                    'headers' => $response->getHeaders(),
                    'protocol_version' => $response->getProtocolVersion()
                ]
            ]
        ];

        $stream->rewind();

        app(LoggingAdapterInterface::class)->debug(
            json_encode($log)
        );
    }
}
