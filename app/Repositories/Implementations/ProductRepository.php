<?php

namespace App\Repositories\Implementations;

use App\Models\ProductModel;
use App\Repositories\Interfaces\IProductRepository;
use Config\Database;

class ProductRepository implements IProductRepository
{
    private ProductModel $productModel;

    public function __construct(ProductModel $productModel)
    {
        $this->productModel = $productModel;
    }

    public function findAll(array $filters = []): array
    {
        $builder = $this->productModel
            ->select('products.*, categories.name AS category_name, suppliers.company_name AS supplier_name')
            ->where('products.is_deleted', 0)
            ->join('categories', 'categories.id = products.category_id')
            ->join('suppliers', 'suppliers.id = products.supplier_id');

        if (!empty($filters['category'])) {
            $builder->where('products.category_id', (int) $filters['category']);
        }

        if (!empty($filters['supplier'])) {
            $builder->where('products.supplier_id', (int) $filters['supplier']);
        }

        if (!empty($filters['maxPrice'])) {
            $builder->where('products.price <=', (float) $filters['maxPrice']);
        }

        return $builder->orderBy('products.id', 'DESC')->findAll();
    }

    public function findById(int $id): ?array
    {
        $product = $this->productModel
            ->select('products.*, categories.name AS category_name, suppliers.company_name AS supplier_name')
            ->join('categories', 'categories.id = products.category_id')
            ->join('suppliers', 'suppliers.id = products.supplier_id')
            ->where('products.is_deleted', 0)
            ->where('products.id', $id)
            ->first();

        return $product ?: null;
    }

    public function create(array $data): int
    {
        $this->productModel->insert($data);

        return $this->productModel->getInsertID();
    }

    public function update(int $id, array $data): bool
    {
        return $this->productModel->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->productModel->update($id, [
            'is_deleted' => 1,
        ]);
    }

    public function skuExists(string $sku, ?int $ignoredProductId = null): bool
    {
        $builder = $this->productModel->where('sku', $sku);

        if ($ignoredProductId !== null) {
            $builder->where('id !=', $ignoredProductId);
        }

        return $builder->first() !== null;
    }

    public function categoryExists(int $categoryId): bool
    {
        return Database::connect()
            ->table('categories')
            ->where('id', $categoryId)
            ->countAllResults() > 0;
    }

    public function supplierExists(int $supplierId): bool
    {
        return Database::connect()
            ->table('suppliers')
            ->where('id', $supplierId)
            ->countAllResults() > 0;
    }
}
