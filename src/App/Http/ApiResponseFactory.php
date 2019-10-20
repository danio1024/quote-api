<?php

declare(strict_types=1);

namespace App\Http;

use Symfony\Component\HttpFoundation\JsonResponse;

final class ApiResponseFactory
{
    public function error(string $message): JsonResponse
    {
        return new JsonResponse(['error' => $message], 403);
    }

    public function success(array $data): JsonResponse
    {
        return new JsonResponse($data);
    }
}
