<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table            = 'admins';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $useSoftDeletes = false;

    protected $protectFields = true;

    protected $allowedFields = [
        'username',
        'password',
        'name',
        'email',
        'role',
        'status',
        'must_change_password',
        'password_reset_token',
        'password_reset_expires_at',
    ];

    protected $useTimestamps = true;
}