<?php

namespace App\Repositories\Implementations;

use App\Models\CategoryModel;
use App\Repositories\Interfaces\ICategoryRepository;

class CategoryRepository implements ICategoryRepository
{
    private CategoryModel $categoryModel;

    public function __construct(CategoryModel $categoryModel)
    {
        $this->categoryModel = $categoryModel;
    }

    public function findAll(): array
    {
        return $this->categoryModel
            ->where('is_deleted', 0)
            ->orderBy('id', 'DESC')
            ->findAll();
    }

    public function findById(int $id): ?array
    {
        $category = $this->categoryModel
            ->where('id', $id)
            ->where('is_deleted', 0)
            ->first();

        return $category ?: null;
    }

    public function create(array $data): int
    {
        $this->categoryModel->insert($data);
        return $this->categoryModel->getInsertID();
    }

    public function update(int $id, array $data): bool
    {
        return $this->categoryModel->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->categoryModel->update($id, [
            'is_deleted' => 1,
        ]);
    }

    public function nameExists(string $name, ?int $ignoredCategoryId = null): bool
    {
        $builder = $this->categoryModel
            ->where('name', $name)
            ->where('is_deleted', 0);

        if ($ignoredCategoryId !== null) {
            $builder->where('id !=', $ignoredCategoryId);
        }

        return $builder->first() !== null;
    }
}