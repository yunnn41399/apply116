<?php

namespace App\Models;

use CodeIgniter\Model;

class HomepagePageModel extends Model
{
    protected $table            = 'homepage_pages';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $protectFields = true;

    protected $allowedFields = [
        'page_key',
        'title',
        'route',
        'location',
        'is_enabled',
        'display_mode',
        'start_at',
        'end_at',
        'before_message',
        'after_message',
    ];

    protected $useTimestamps = true;
}