<?php

namespace App\Models;

use CodeIgniter\Model;

class HomepageMarqueeModel extends Model
{
    protected $table            = 'homepage_marquees';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $protectFields = true;

    protected $allowedFields = [
        'content',
        'is_enabled',
        'start_at',
        'end_at',
    ];

    protected $useTimestamps = true;
}