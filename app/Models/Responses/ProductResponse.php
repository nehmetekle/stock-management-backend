<?php

namespace App\Models\Responses;

class ProductResponse
{
    public static function toResponse(array $product): array
    {
        return [
            'id' => (int) $product['id'],
            'name' => $product['name'],
            'sku' => $product['sku'],
            'weight' => (int) $product['weight'],
            'price' => (float) $product['price'],
            'stock_quantity' => (int) $product['stock_quantity'],
            'category_id' => isset($product['category_id']) ? (int) $product['category_id'] : null,
            'category_name' => $product['category_name'] ?? null,
            'supplier_id' => isset($product['supplier_id']) ? (int) $product['supplier_id'] : null,
            'supplier_name' => $product['supplier_name'] ?? null,
            'is_heavy_and_cheap' => (int) $product['weight'] > 1000 && (float) $product['price'] < 50,
            'is_low_stock' => (int) $product['stock_quantity'] < 10,
            'created_at' => $product['created_at'] ?? null,
            'updated_at' => $product['updated_at'] ?? null,
        ];
    }

    public static function collection(array $products): array
    {
        return array_map(fn ($product) => self::toResponse($product), $products);
    }
}