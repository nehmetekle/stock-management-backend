<?php

namespace App\Services\Interfaces;

interface ICategoryService
{
    public function getCategories(): array;
    public function getCategoryById(int $id): ?array;
    public function createCategory(array $data): array;
    public function updateCategory(array $data): array;
    public function deleteCategory(array $data): array;
}