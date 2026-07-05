<?php

namespace App\Repositories\Implementations;

use App\Models\SupplierModel;
use App\Repositories\Interfaces\ISupplierRepository;

class SupplierRepository implements ISupplierRepository
{
    private SupplierModel $supplierModel;

    public function __construct(SupplierModel $supplierModel)
    {
        $this->supplierModel = $supplierModel;
    }

    public function findAll(): array
    {
        return $this->supplierModel
            ->where('is_deleted', 0)
            ->orderBy('id', 'DESC')
            ->findAll();
    }

    public function findById(int $id): ?array
    {
        $supplier = $this->supplierModel
            ->where('id', $id)
            ->where('is_deleted', 0)
            ->first();

        return $supplier ?: null;
    }

    public function create(array $data): int
    {
        $this->supplierModel->insert($data);

        return $this->supplierModel->getInsertID();
    }

    public function update(int $id, array $data): bool
    {
        return $this->supplierModel->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->supplierModel->update($id, [
            'is_deleted' => 1,
        ]);
    }

    public function emailExists(string $email, ?int $ignoredSupplierId = null): bool
    {
        $builder = $this->supplierModel
            ->where('email', $email)
            ->where('is_deleted', 0);

        if ($ignoredSupplierId !== null) {
            $builder->where('id !=', $ignoredSupplierId);
        }

        return $builder->first() !== null;
    }

    public function getSummary(): array
    {
        return $this->supplierModel
            ->select('
                suppliers.id AS supplier_id,
                suppliers.company_name AS supplier_name,
                COUNT(products.id) AS product_count,
                COALESCE(SUM(products.price * products.stock_quantity), 0) AS total_stock_value
            ')
            ->join(
                'products',
                'products.supplier_id = suppliers.id AND products.is_deleted = 0',
                'left'
            )
            ->where('suppliers.is_deleted', 0)
            ->groupBy('suppliers.id')
            ->orderBy('suppliers.company_name', 'ASC')
            ->findAll();
    }
}