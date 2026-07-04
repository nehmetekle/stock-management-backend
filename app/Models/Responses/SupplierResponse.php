<?php

namespace App\Models\Responses;

class SupplierResponse
{
    public static function toResponse(array $supplier): array
    {
        return [
            'id' => (int) $supplier['id'],
            'company_name' => $supplier['company_name'],
            'email' => $supplier['email'],
            'phone' => $supplier['phone'] ?? null,
            'country' => $supplier['country'],
            'created_at' => $supplier['created_at'] ?? null,
        ];
    }

    public static function collection(array $suppliers): array
    {
        return array_map(fn ($supplier) => self::toResponse($supplier), $suppliers);
    }
}