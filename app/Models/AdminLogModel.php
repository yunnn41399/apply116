<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminLogModel extends Model
{
    protected $table = 'admin_logs';

    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $useSoftDeletes = false;

    protected $protectFields = true;

    protected $allowedFields = [
        'admin_id',
        'action',
        'description',
    ];

    protected $useTimestamps = false;
}