<?php

namespace App\Models\Responses;

class CommonResponse
{
    public static function toResponse(
        bool $success,
        int $statusCode,
        string $message,
        mixed $data = null,
        mixed $errors = null
    ): array {
        return [
            'success' => $success,
            'statusCode' => $statusCode,
            'message' => $message,
            'data' => $data,
            'errors' => $errors,
        ];
    }
}