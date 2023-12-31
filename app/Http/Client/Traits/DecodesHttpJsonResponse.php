<?php

namespace App\Http\Client\Traits;

use Throwable;
use Psr\Http\Message\ResponseInterface;

trait DecodesHttpJsonResponse
{
    protected function decodedResponse(ResponseInterface $response): array
    {
        $contents = $response
            ->getBody()
            ->getContents();

        try {
            return json_decode($contents, true, 512, JSON_THROW_ON_ERROR);

        } catch (Throwable $throwable) {
            return [
                'raw_response'       => $contents,
                'decoding_exception' => $throwable->getMessage(),
            ];
        }
    }
}
