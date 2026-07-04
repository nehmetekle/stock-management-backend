<?php

namespace App\Models\Responses;

class CategoryResponse
{
    public static function toResponse(array $category): array
    {
        return [
            'id' => (int) $category['id'],
            'name' => $category['name'],
            'description' => $category['description'] ?? null,
            'created_at' => $category['created_at'] ?? null,
        ];
    }

    public static function collection(array $categories): array
    {
        return array_map(fn ($category) => self::toResponse($category), $categories);
    }
}