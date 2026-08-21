<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class AdminPassword extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    // 修改密碼頁面
    public function changePassword()
    {
        return view('admin/change_password');
    }

    // 處理修改密碼
    public function updatePassword()
    {
        $password = $this->request->getPost('password');
        $passwordConfirm = $this->request->getPost('password_confirm');

        // 驗證新密碼
        $rules = [
            'password' => 'required|min_length[8]|max_length[255]',
            'password_confirm' => 'required|matches[password]',
        ];

        $messages = [
            'password' => [
                'required' => '請輸入新密碼。',
                'min_length' => '新密碼至少需要 8 個字元。',
                'max_length' => '新密碼不可超過 255 個字元。',
            ],

            'password_confirm' => [
                'required' => '請再次輸入新密碼。',
                'matches' => '兩次輸入的新密碼不一致。',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // 取得目前登入的管理員
        $adminId = session()->get('admin_id');

        if (!$adminId) {
            return redirect()->to('/admin/login');
        }

        // 更新密碼
        $this->adminModel->update($adminId, [
            'password' => password_hash(
                $password,
                PASSWORD_DEFAULT
            ),
            'must_change_password' => 0,
        ]);

        // 更新 Session
        session()->set([
            'admin_must_change_password' => 0,
        ]);

        return redirect()
            ->to('/admin')
            ->with('success', '密碼修改成功，歡迎進入後臺管理系統。');
    }
}