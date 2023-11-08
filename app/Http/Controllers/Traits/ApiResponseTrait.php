<?php

namespace App\Http\Controllers\Traits;

use App\Http\Resources\ProductResource;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponseTrait
{
    protected function createResponse(
        mixed $data,
        string $bearer = '',
        string $metaInfo = '',
        int $httpCode = Response::HTTP_OK,
        array $headers = [],
        int $options = JSON_UNESCAPED_UNICODE
    ): Response
    {
        return response()->json(
            [
                'data' => $data,
                'Bearer' => $bearer,
                'meta' => [
                    'info' => $metaInfo,
                ],
            ],
            $httpCode,
            $headers,
            $options
        );
    }
}
