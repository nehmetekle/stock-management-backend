<?php

namespace App\Models\Requests;

class CategoryRequest
{
    public static function toRequest(array $data): array
    {
        return [
            'id' => isset($data['id']) ? (int) $data['id'] : null,
            'name' => trim($data['name'] ?? ''),
            'description' => trim($data['description'] ?? ''),
            'created_at' => date('Y-m-d H:i:s'),
        ];
    }
}