<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'description',
        'created_at',
        'is_deleted',
    ];

    protected $useTimestamps = false;
}
