<?php

namespace App\Models\Requests;

class ProductRequest
{
    public static function toRequest(array $data): array
    {
        return [
            'id' => isset($data['id']) ? (int) $data['id'] : null,
            'name' => trim($data['name'] ?? ''),
            'sku' => trim($data['sku'] ?? ''),
            'weight' => isset($data['weight']) ? (int) $data['weight'] : null,
            'price' => isset($data['price']) ? (float) $data['price'] : null,
            'stock_quantity' => isset($data['stock_quantity']) ? (int) $data['stock_quantity'] : null,
            'category_id' => isset($data['category_id']) ? (int) $data['category_id'] : null,
            'supplier_id' => isset($data['supplier_id']) ? (int) $data['supplier_id'] : null,
        ];
    }
}