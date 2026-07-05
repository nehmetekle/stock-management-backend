<?php

namespace App\Repositories\Interfaces;

interface ICategoryRepository
{
    public function findAll(): array;
    public function findById(int $id): ?array;
    public function create(array $data): int;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function nameExists(string $name, ?int $ignoredCategoryId = null): bool;
}