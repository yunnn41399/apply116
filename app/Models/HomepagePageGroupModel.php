<?php

namespace App\Models;

use CodeIgniter\Model;

class HomepagePageGroupModel extends Model
{
    protected $table            = 'homepage_page_groups';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $useSoftDeletes = false;

    protected $protectFields = true;

    protected $allowedFields = [
        'group_key',
        'title',
        'location',
        'is_enabled',
        'display_mode',
        'start_at',
        'end_at',
        'before_message',
        'after_message',
    ];

    protected bool $allowEmptyInserts = false;

    protected $useTimestamps = true;
}