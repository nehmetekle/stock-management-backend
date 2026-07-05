<?php

namespace App\Repositories\Interfaces;

interface ISupplierRepository
{
    public function findAll(): array;
    public function findById(int $id): ?array;
    public function create(array $data): int;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function emailExists(string $email, ?int $ignoredSupplierId = null): bool;
    public function getSummary(): array;
}
