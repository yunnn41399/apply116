<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Register extends BaseController
{
    public function index()
    {
        return view('register');
    }

    public function register()
    {
        $examNumber = $this->request->getPost('exam_number');
        $idNumber = $this->request->getPost('id_number');
        $password = $this->request->getPost('password');
        $passwordConfirm = $this->request->getPost('password_confirm');
        $captcha = $this->request->getPost('captcha');

        return "收到註冊資料";
    }
}