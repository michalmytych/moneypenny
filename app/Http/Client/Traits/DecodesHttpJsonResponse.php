<?php

namespace App\Http\Client\Traits;

use Throwable;
use GuzzleHttp\Psr7\Response;

trait DecodesHttpJsonResponse
{
    protected function decodedResponse(Response $response): array
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
