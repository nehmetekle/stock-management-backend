<?php

namespace App\Services\Implementations;

use App\Repositories\Interfaces\ICategoryRepository;
use App\Services\Interfaces\ICategoryService;

class CategoryService implements ICategoryService
{
    private ICategoryRepository $categoryRepository;

    public function __construct(ICategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategories(): array
    {
        return [
            'success' => true,
            'data' => $this->categoryRepository->findAll(),
        ];
    }

    public function getCategoryById(int $id): ?array
    {
        return $this->categoryRepository->findById($id);
    }

    public function createCategory(array $data): array
    {
        $errors = $this->validateCategoryData($data);

        if (!empty($errors)) {
            return [
                'success' => false,
                'statusCode' => 400,
                'message' => 'Validation failed',
                'errors' => $errors,
            ];
        }

        if ($this->categoryRepository->nameExists($data['name'])) {
            return [
                'success' => false,
                'statusCode' => 400,
                'message' => 'Category already exists',
                'errors' => ['name' => 'Category name must be unique'],
            ];
        }

        $id = $this->categoryRepository->create($data);

        return [
            'success' => true,
            'statusCode' => 201,
            'message' => 'Category created successfully',
            'data' => $this->categoryRepository->findById($id),
        ];
    }

    public function updateCategory(array $data): array
    {
        $id = (int) ($data['id'] ?? 0);

        if ($id <= 0) {
            return [
                'success' => false,
                'statusCode' => 400,
                'message' => 'Category id is required',
                'errors' => ['id' => 'Category id is required'],
            ];
        }

        if (!$this->categoryRepository->findById($id)) {
            return [
                'success' => false,
                'statusCode' => 404,
                'message' => 'Category not found',
                'errors' => ['id' => 'No category exists with this id'],
            ];
        }

        $errors = $this->validateCategoryData($data);

        if (!empty($errors)) {
            return [
                'success' => false,
                'statusCode' => 400,
                'message' => 'Validation failed',
                'errors' => $errors,
            ];
        }

        if ($this->categoryRepository->nameExists($data['name'], $id)) {
            return [
                'success' => false,
                'statusCode' => 400,
                'message' => 'Category already exists',
                'errors' => ['name' => 'Category name must be unique'],
            ];
        }

        unset($data['id'], $data['created_at']);

        $this->categoryRepository->update($id, $data);

        return [
            'success' => true,
            'statusCode' => 200,
            'message' => 'Category updated successfully',
            'data' => $this->categoryRepository->findById($id),
        ];
    }

    public function deleteCategory(array $data): array
    {
        $id = (int) ($data['id'] ?? 0);

        if ($id <= 0) {
            return [
                'success' => false,
                'statusCode' => 400,
                'message' => 'Category id is required',
                'errors' => ['id' => 'Category id is required'],
            ];
        }

        if (!$this->categoryRepository->findById($id)) {
            return [
                'success' => false,
                'statusCode' => 404,
                'message' => 'Category not found',
                'errors' => ['id' => 'No category exists with this id'],
            ];
        }

        $this->categoryRepository->delete($id);

        return [
            'success' => true,
            'statusCode' => 200,
            'message' => 'Category deleted successfully',
        ];
    }

    private function validateCategoryData(array $data): array
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = 'Category name is required';
        }

        return $errors;
    }
}