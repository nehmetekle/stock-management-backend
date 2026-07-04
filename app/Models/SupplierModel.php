<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    protected $table = 'suppliers';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'company_name',
        'email',
        'phone',
        'country',
        'created_at',
    ];

    protected $useTimestamps = false;
}
