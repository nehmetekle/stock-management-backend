<?php

namespace App\Services\Implementations;

use App\Repositories\Interfaces\IProductRepository;
use App\Services\Interfaces\IProductService;

class ProductService implements IProductService
{
    private IProductRepository $productRepository;

    public function __construct(IProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProducts(array $filters = []): array
    {
        return [
            'success' => true,
            'data' => $this->productRepository->findAll($filters),
        ];
    }

    public function getProductById(int $id): ?array
    {
        return $this->productRepository->findById($id);
    }

    public function createProduct(array $data): array
    {
        $errors = $this->validateProductData($data);

        if (!empty($errors)) {
            return [
                'success' => false,
                'statusCode' => 400,
                'message' => 'Validation failed',
                'errors' => $errors,
            ];
        }

        if ($this->productRepository->skuExists($data['sku'])) {
            return [
                'success' => false,
                'statusCode' => 400,
                'message' => 'SKU already exists',
                'errors' => ['sku' => 'SKU must be unique'],
            ];
        }

        $id = $this->productRepository->create($data);

        return [
            'success' => true,
            'statusCode' => 201,
            'message' => 'Product created successfully',
            'data' => $this->productRepository->findById($id),
        ];
    }

    public function updateProduct(array $data): array
    {
        $id = (int) ($data['id'] ?? 0);

        if ($id <= 0) {
            return [
                'success' => false,
                'statusCode' => 400,
                'message' => 'Product id is required',
                'errors' => ['id' => 'Product id is required'],
            ];
        }

        if (!$this->productRepository->findById($id)) {
            return [
                'success' => false,
                'statusCode' => 404,
                'message' => 'Product not found',
                'errors' => ['id' => 'No product exists with this id'],
            ];
        }

        $errors = $this->validateProductData($data);

        if (!empty($errors)) {
            return [
                'success' => false,
                'statusCode' => 400,
                'message' => 'Validation failed',
                'errors' => $errors,
            ];
        }

        if ($this->productRepository->skuExists($data['sku'], $id)) {
            return [
                'success' => false,
                'statusCode' => 400,
                'message' => 'SKU already exists',
                'errors' => ['sku' => 'SKU must be unique'],
            ];
        }

        unset($data['id']);

        $this->productRepository->update($id, $data);

        return [
            'success' => true,
            'statusCode' => 200,
            'message' => 'Product updated successfully',
            'data' => $this->productRepository->findById($id),
        ];
    }

    public function deleteProduct(array $data): array
    {
        $id = (int) ($data['id'] ?? 0);

        if ($id <= 0) {
            return [
                'success' => false,
                'statusCode' => 400,
                'message' => 'Product id is required',
                'errors' => ['id' => 'Product id is required'],
            ];
        }

        if (!$this->productRepository->findById($id)) {
            return [
                'success' => false,
                'statusCode' => 404,
                'message' => 'Product not found',
                'errors' => ['id' => 'No product exists with this id'],
            ];
        }

        $this->productRepository->delete($id);

        return [
            'success' => true,
            'statusCode' => 200,
            'message' => 'Product deleted successfully',
        ];
    }

    private function validateProductData(array $data): array
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = 'Product name is required';
        }

        if (empty($data['sku'])) {
            $errors['sku'] = 'SKU is required';
        }

        if (!isset($data['weight']) || $data['weight'] <= 0) {
            $errors['weight'] = 'Weight must be a positive number';
        }

        if (!isset($data['price']) || $data['price'] <= 0) {
            $errors['price'] = 'Price must be a positive number';
        }

        if (!isset($data['stock_quantity']) || $data['stock_quantity'] < 0) {
            $errors['stock_quantity'] = 'Stock quantity must be zero or a positive number';
        }

        if (empty($data['category_id']) || !$this->productRepository->categoryExists((int) $data['category_id'])) {
            $errors['category_id'] = 'Valid category is required';
        }

        if (empty($data['supplier_id']) || !$this->productRepository->supplierExists((int) $data['supplier_id'])) {
            $errors['supplier_id'] = 'Valid supplier is required';
        }

        return $errors;
    }
}
