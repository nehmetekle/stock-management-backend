<?php

namespace App\Controllers;

use App\Models\Requests\ProductRequest;
use App\Models\Responses\CommonResponse;
use App\Models\Responses\ProductResponse;
use App\Services\Interfaces\IProductService;
use CodeIgniter\RESTful\ResourceController;

class ProductsController extends ResourceController
{
    private IProductService $productService;

    public function __construct()
    {
        $this->productService = service('productService');
    }

    public function index()
    {
        $filters = [
            'category' => $this->request->getGet('category'),
            'supplier' => $this->request->getGet('supplier'),
            'maxPrice' => $this->request->getGet('maxPrice'),
        ];

        $result = $this->productService->getProducts($filters);

        return $this->respond(
            CommonResponse::toResponse(
                true,
                200,
                'Products retrieved successfully',
                ProductResponse::collection($result['data'])
            ),
            200
        );
    }

    public function detail()
    {
        $id = (int) $this->request->getGet('id');

        if ($id <= 0) {
            return $this->respond(
                CommonResponse::toResponse(
                    false,
                    400,
                    'Product id is required',
                    null,
                    ['id' => 'Product id is required']
                ),
                400
            );
        }

        $product = $this->productService->getProductById($id);

        if (!$product) {
            return $this->respond(
                CommonResponse::toResponse(
                    false,
                    404,
                    'Product not found',
                    null,
                    ['id' => 'No product exists with this id']
                ),
                404
            );
        }

        return $this->respond(
            CommonResponse::toResponse(
                true,
                200,
                'Product retrieved successfully',
                ProductResponse::toResponse($product)
            ),
            200
        );
    }

    public function create()
    {
        $payload = $this->request->getJSON(true) ?? [];
        $data = ProductRequest::toRequest($payload);

        $result = $this->productService->createProduct($data);

        if (!$result['success']) {
            return $this->respond(
                CommonResponse::toResponse(
                    false,
                    $result['statusCode'],
                    $result['message'],
                    null,
                    $result['errors']
                ),
                $result['statusCode']
            );
        }

        return $this->respond(
            CommonResponse::toResponse(
                true,
                $result['statusCode'],
                $result['message'],
                ProductResponse::toResponse($result['data'])
            ),
            $result['statusCode']
        );
    }

    public function updateProduct()
    {
        $payload = $this->request->getJSON(true) ?? [];
        $data = ProductRequest::toRequest($payload);

        $result = $this->productService->updateProduct($data);

        if (!$result['success']) {
            return $this->respond(
                CommonResponse::toResponse(
                    false,
                    $result['statusCode'],
                    $result['message'],
                    null,
                    $result['errors']
                ),
                $result['statusCode']
            );
        }

        return $this->respond(
            CommonResponse::toResponse(
                true,
                $result['statusCode'],
                $result['message'],
                ProductResponse::toResponse($result['data'])
            ),
            $result['statusCode']
        );
    }

    public function deleteProduct()
    {
        $payload = $this->request->getJSON(true) ?? [];
        $data = ProductRequest::toRequest($payload);

        $result = $this->productService->deleteProduct($data);

        if (!$result['success']) {
            return $this->respond(
                CommonResponse::toResponse(
                    false,
                    $result['statusCode'],
                    $result['message'],
                    null,
                    $result['errors']
                ),
                $result['statusCode']
            );
        }

        return $this->respond(
            CommonResponse::toResponse(
                true,
                $result['statusCode'],
                $result['message']
            ),
            $result['statusCode']
        );
    }
}