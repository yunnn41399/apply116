<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Admin extends BaseController
{
    // 後臺管理首頁
    public function index()
    {
        return view('admin/dashboard');
    }
}