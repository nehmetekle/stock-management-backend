<?php

namespace App\Models\Requests;

class SupplierRequest
{
    public static function toRequest(array $data): array
    {
        return [
            'id' => isset($data['id']) ? (int) $data['id'] : null,
            'company_name' => trim($data['company_name'] ?? ''),
            'email' => trim($data['email'] ?? ''),
            'phone' => trim($data['phone'] ?? ''),
            'country' => trim($data['country'] ?? ''),
            'created_at' => date('Y-m-d H:i:s'),
        ];
    }
}