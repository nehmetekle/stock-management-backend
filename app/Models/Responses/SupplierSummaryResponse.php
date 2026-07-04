<?php

namespace App\Models\Responses;

class SupplierSummaryResponse
{
    public static function toResponse(array $summary): array
    {
        return [
            'supplier_id' => (int) $summary['supplier_id'],
            'supplier_name' => $summary['supplier_name'],
            'product_count' => (int) $summary['product_count'],
            'total_stock_value' => (float) $summary['total_stock_value'],
        ];
    }

    public static function collection(array $summaries): array
    {
        return array_map(fn ($summary) => self::toResponse($summary), $summaries);
    }
}