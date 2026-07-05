<?php

namespace Config;

use App\Models\CategoryModel;
use CodeIgniter\Config\BaseService;

use App\Models\ProductModel;
use App\Models\SupplierModel;
use App\Repositories\Implementations\CategoryRepository;
use App\Repositories\Implementations\ProductRepository;
use App\Repositories\Implementations\SupplierRepository;
use App\Services\Implementations\CategoryService;
use App\Services\Implementations\ProductService;
use App\Services\Implementations\SupplierService;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    public static function productRepository(bool $getShared = true): ProductRepository
    {
        if ($getShared) {
            return static::getSharedInstance('productRepository');
        }

        return new ProductRepository(
            new ProductModel()
        );
    }

    public static function productService(bool $getShared = true): ProductService
    {
        if ($getShared) {
            return static::getSharedInstance('productService');
        }

        return new ProductService(
            static::productRepository()
        );
    }

    public static function categoryRepository(bool $getShared = true): CategoryRepository
    {
        if ($getShared) {
            return static::getSharedInstance('categoryRepository');
        }

        return new CategoryRepository(
            new CategoryModel()
        );
    }

    public static function categoryService(bool $getShared = true): CategoryService
    {
        if ($getShared) {
            return static::getSharedInstance('categoryService');
        }

        return new CategoryService(
            static::categoryRepository()
        );
    }

    public static function supplierRepository(bool $getShared = true): SupplierRepository
{
    if ($getShared) {
        return static::getSharedInstance('supplierRepository');
    }

    return new SupplierRepository(
        new SupplierModel()
    );
}

public static function supplierService(bool $getShared = true): SupplierService
{
    if ($getShared) {
        return static::getSharedInstance('supplierService');
    }

    return new SupplierService(
        static::supplierRepository()
    );
}
}
