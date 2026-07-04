<?php

namespace App\Services\Interfaces;

interface IProductService
{
    public function getProducts(array $filters = []): array;

    public function getProductById(int $id): ?array;

    public function createProduct(array $data): array;

    public function updateProduct(array $data): array;

    public function deleteProduct(array $data): array;
}