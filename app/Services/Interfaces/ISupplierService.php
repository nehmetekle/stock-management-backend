<?php

namespace App\Services\Interfaces;

interface ISupplierService
{
    public function getSuppliers(): array;
    public function getSupplierById(int $id): ?array;
    public function createSupplier(array $data): array;
    public function updateSupplier(array $data): array;
    public function deleteSupplier(array $data): array;
    public function getSupplierSummary(): array;
}