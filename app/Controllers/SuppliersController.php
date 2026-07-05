<?php

namespace App\Controllers;

use App\Models\Requests\SupplierRequest;
use App\Models\Responses\CommonResponse;
use App\Models\Responses\SupplierResponse;
use App\Models\Responses\SupplierSummaryResponse;
use App\Services\Interfaces\ISupplierService;
use CodeIgniter\RESTful\ResourceController;

class SuppliersController extends ResourceController
{
    private ISupplierService $supplierService;

    public function __construct()
    {
        $this->supplierService = service('supplierService');
    }

    public function index()
    {
        $result = $this->supplierService->getSuppliers();

        return $this->respond(
            CommonResponse::toResponse(
                true,
                200,
                'Suppliers retrieved successfully',
                SupplierResponse::collection($result['data'])
            ),
            200
        );
    }

    public function detail()
    {
        $id = (int) $this->request->getGet('id');

        if ($id <= 0) {
            return $this->respond(
                CommonResponse::toResponse(false, 400, 'Supplier id is required', null, ['id' => 'Supplier id is required']),
                400
            );
        }

        $supplier = $this->supplierService->getSupplierById($id);

        if (!$supplier) {
            return $this->respond(
                CommonResponse::toResponse(false, 404, 'Supplier not found', null, ['id' => 'No supplier exists with this id']),
                404
            );
        }

        return $this->respond(
            CommonResponse::toResponse(true, 200, 'Supplier retrieved successfully', SupplierResponse::toResponse($supplier)),
            200
        );
    }

    public function create()
    {
        $data = SupplierRequest::toRequest($this->request->getJSON(true) ?? []);
        $result = $this->supplierService->createSupplier($data);

        if (!$result['success']) {
            return $this->respond(
                CommonResponse::toResponse(false, $result['statusCode'], $result['message'], null, $result['errors']),
                $result['statusCode']
            );
        }

        return $this->respond(
            CommonResponse::toResponse(true, $result['statusCode'], $result['message'], SupplierResponse::toResponse($result['data'])),
            $result['statusCode']
        );
    }

    public function updateSupplier()
    {
        $data = SupplierRequest::toRequest($this->request->getJSON(true) ?? []);
        $result = $this->supplierService->updateSupplier($data);

        if (!$result['success']) {
            return $this->respond(
                CommonResponse::toResponse(false, $result['statusCode'], $result['message'], null, $result['errors']),
                $result['statusCode']
            );
        }

        return $this->respond(
            CommonResponse::toResponse(true, $result['statusCode'], $result['message'], SupplierResponse::toResponse($result['data'])),
            $result['statusCode']
        );
    }

    public function deleteSupplier()
    {
        $data = SupplierRequest::toRequest($this->request->getJSON(true) ?? []);
        $result = $this->supplierService->deleteSupplier($data);

        if (!$result['success']) {
            return $this->respond(
                CommonResponse::toResponse(false, $result['statusCode'], $result['message'], null, $result['errors']),
                $result['statusCode']
            );
        }

        return $this->respond(
            CommonResponse::toResponse(true, $result['statusCode'], $result['message']),
            $result['statusCode']
        );
    }

    public function summary()
    {
        $result = $this->supplierService->getSupplierSummary();

        return $this->respond(
            CommonResponse::toResponse(
                true,
                200,
                'Supplier summary retrieved successfully',
                SupplierSummaryResponse::collection($result['data'])
            ),
            200
        );
    }
}