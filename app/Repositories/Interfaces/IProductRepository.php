<?php

namespace App\Repositories\Interfaces;

interface IProductRepository
{
    public function findAll(array $filters = []): array;
    public function findById(int $id): ?array;
    public function create(array $data): int;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function skuExists(string $sku, ?int $ignoredProductId = null): bool;
    public function categoryExists(int $categoryId): bool;
    public function supplierExists(int $supplierId): bool;
}