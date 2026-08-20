<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class AdminManagement extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    // 管理員列表
    public function index()
    {
        $admins = $this->adminModel
            ->orderBy('id', 'ASC')
            ->findAll();

        return view('admin/admins/index', [
            'admins' => $admins,
        ]);
    }
}