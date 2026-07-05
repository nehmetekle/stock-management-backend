<?php

namespace App\Controllers;

use App\Models\Requests\CategoryRequest;
use App\Models\Responses\CategoryResponse;
use App\Models\Responses\CommonResponse;
use App\Services\Interfaces\ICategoryService;
use CodeIgniter\RESTful\ResourceController;

class CategoriesController extends ResourceController
{
    private ICategoryService $categoryService;

    public function __construct()
    {
        $this->categoryService = service('categoryService');
    }

    public function index()
    {
        $result = $this->categoryService->getCategories();

        return $this->respond(
            CommonResponse::toResponse(
                true,
                200,
                'Categories retrieved successfully',
                CategoryResponse::collection($result['data'])
            ),
            200
        );
    }

    public function detail()
    {
        $id = (int) $this->request->getGet('id');

        if ($id <= 0) {
            return $this->respond(
                CommonResponse::toResponse(false, 400, 'Category id is required', null, ['id' => 'Category id is required']),
                400
            );
        }

        $category = $this->categoryService->getCategoryById($id);

        if (!$category) {
            return $this->respond(
                CommonResponse::toResponse(false, 404, 'Category not found', null, ['id' => 'No category exists with this id']),
                404
            );
        }

        return $this->respond(
            CommonResponse::toResponse(true, 200, 'Category retrieved successfully', CategoryResponse::toResponse($category)),
            200
        );
    }

    public function create()
    {
        $data = CategoryRequest::toRequest($this->request->getJSON(true) ?? []);
        $result = $this->categoryService->createCategory($data);

        if (!$result['success']) {
            return $this->respond(
                CommonResponse::toResponse(false, $result['statusCode'], $result['message'], null, $result['errors']),
                $result['statusCode']
            );
        }

        return $this->respond(
            CommonResponse::toResponse(true, $result['statusCode'], $result['message'], CategoryResponse::toResponse($result['data'])),
            $result['statusCode']
        );
    }

    public function updateCategory()
    {
        $data = CategoryRequest::toRequest($this->request->getJSON(true) ?? []);
        $result = $this->categoryService->updateCategory($data);

        if (!$result['success']) {
            return $this->respond(
                CommonResponse::toResponse(false, $result['statusCode'], $result['message'], null, $result['errors']),
                $result['statusCode']
            );
        }

        return $this->respond(
            CommonResponse::toResponse(true, $result['statusCode'], $result['message'], CategoryResponse::toResponse($result['data'])),
            $result['statusCode']
        );
    }

    public function deleteCategory()
    {
        $data = CategoryRequest::toRequest($this->request->getJSON(true) ?? []);
        $result = $this->categoryService->deleteCategory($data);

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
}