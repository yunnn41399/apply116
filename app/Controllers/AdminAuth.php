<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Services\AdminLogService;

class AdminAuth extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    // 管理員登入頁面
    public function login()
    {

        // 若第一次登入未更改密碼，會跳轉到更改密碼的頁面
        // 否則會直接進入後臺首頁
        if (session()->get('admin_logged_in')) {

            if (session()->get('admin_must_change_password')) {
                return redirect()->to('/admin/change-password');
            }

            return redirect()->to('/admin');
        }

        return view('admin/login');
    }

    // 處理登入
    public function attemptLogin()
    {
        $username = trim($this->request->getPost('username'));
        $password = $this->request->getPost('password');

        // 基本驗證
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // 查詢管理員
        $admin = $this->adminModel
            ->where('username', $username)
            ->first();

        // 帳號不存在
        if (!$admin) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '管理員帳號或密碼錯誤');
        }

        // 帳號已停用
        if ($admin['status'] !== 'active') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '此管理員帳號目前已停用');
        }

        // 驗證密碼
        if (!password_verify($password, $admin['password'])) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '管理員帳號或密碼錯誤');
        }

        // 登入成功後重新產生 Session ID
        session()->regenerate();

        // 建立管理員登入 Session
        session()->set([
            'admin_logged_in' => true,
            'admin_id'         => $admin['id'],
            'admin_username'   => $admin['username'],
            'admin_name'       => $admin['name'],
            'admin_role'       => $admin['role'],
            'admin_must_change_password' => $admin['must_change_password'],
        ]);

        // 建立登入操作紀錄
        $logService = new AdminLogService();

        $logService->log(
            '管理員登入',
            '管理員登入：' . $admin['username']
        );

        if ((int) $admin['must_change_password'] === 1) {
            return redirect()->to('/admin/change-password');
        }

        return redirect()->to('/admin');
    }

    // 管理員登出
    public function logout()
    {
        // 先建立登出操作紀錄
        // 必須在清除 Session 前執行
        $logService = new AdminLogService();

        $adminUsername = session()->get('admin_username');

        $logService->log(
            '管理員登出',
            '管理員登出：' . ($adminUsername ?? '未知管理員')
        );

        // 清除管理員 Session
        session()->remove([
            'admin_logged_in',
            'admin_id',
            'admin_username',
            'admin_name',
            'admin_role',
            'admin_must_change_password',
        ]);

        session()->regenerate(true);

        return redirect()
            ->to('/admin/login')
            ->with('success', '您已成功登出');
    }
}