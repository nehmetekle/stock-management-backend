<?php

namespace App\Services\Implementations;

use App\Repositories\Interfaces\ISupplierRepository;
use App\Services\Interfaces\ISupplierService;

class SupplierService implements ISupplierService
{
    private ISupplierRepository $supplierRepository;

    public function __construct(ISupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function getSuppliers(): array
    {
        return [
            'success' => true,
            'data' => $this->supplierRepository->findAll(),
        ];
    }

    public function getSupplierById(int $id): ?array
    {
        return $this->supplierRepository->findById($id);
    }

    public function createSupplier(array $data): array
    {
        $errors = $this->validateSupplierData($data);

        if (!empty($errors)) {
            return [
                'success' => false,
                'statusCode' => 400,
                'message' => 'Validation failed',
                'errors' => $errors,
            ];
        }

        if ($this->supplierRepository->emailExists($data['email'])) {
            return [
                'success' => false,
                'statusCode' => 400,
                'message' => 'Supplier email already exists',
                'errors' => ['email' => 'Email must be unique'],
            ];
        }

        $id = $this->supplierRepository->create($data);

        return [
            'success' => true,
            'statusCode' => 201,
            'message' => 'Supplier created successfully',
            'data' => $this->supplierRepository->findById($id),
        ];
    }

    public function updateSupplier(array $data): array
    {
        $id = (int) ($data['id'] ?? 0);

        if ($id <= 0) {
            return [
                'success' => false,
                'statusCode' => 400,
                'message' => 'Supplier id is required',
                'errors' => ['id' => 'Supplier id is required'],
            ];
        }

        if (!$this->supplierRepository->findById($id)) {
            return [
                'success' => false,
                'statusCode' => 404,
                'message' => 'Supplier not found',
                'errors' => ['id' => 'No supplier exists with this id'],
            ];
        }

        $errors = $this->validateSupplierData($data);

        if (!empty($errors)) {
            return [
                'success' => false,
                'statusCode' => 400,
                'message' => 'Validation failed',
                'errors' => $errors,
            ];
        }

        if ($this->supplierRepository->emailExists($data['email'], $id)) {
            return [
                'success' => false,
                'statusCode' => 400,
                'message' => 'Supplier email already exists',
                'errors' => ['email' => 'Email must be unique'],
            ];
        }

        unset($data['id'], $data['created_at']);

        $this->supplierRepository->update($id, $data);

        return [
            'success' => true,
            'statusCode' => 200,
            'message' => 'Supplier updated successfully',
            'data' => $this->supplierRepository->findById($id),
        ];
    }

    public function deleteSupplier(array $data): array
    {
        $id = (int) ($data['id'] ?? 0);

        if ($id <= 0) {
            return [
                'success' => false,
                'statusCode' => 400,
                'message' => 'Supplier id is required',
                'errors' => ['id' => 'Supplier id is required'],
            ];
        }

        if (!$this->supplierRepository->findById($id)) {
            return [
                'success' => false,
                'statusCode' => 404,
                'message' => 'Supplier not found',
                'errors' => ['id' => 'No supplier exists with this id'],
            ];
        }

        $this->supplierRepository->delete($id);

        return [
            'success' => true,
            'statusCode' => 200,
            'message' => 'Supplier deleted successfully',
        ];
    }

    public function getSupplierSummary(): array
    {
        return [
            'success' => true,
            'data' => $this->supplierRepository->getSummary(),
        ];
    }

    private function validateSupplierData(array $data): array
    {
        $errors = [];

        if (empty($data['company_name'])) {
            $errors['company_name'] = 'Company name is required';
        }

        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email format is invalid';
        }

        if (empty($data['country'])) {
            $errors['country'] = 'Country is required';
        }

        return $errors;
    }
}