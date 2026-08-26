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


    // 產生驗證碼
    private function generateCaptcha()
    {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $captcha = '';

        for ($i = 0; $i < 4; $i++) {
            $captcha .= $characters[
                random_int(0, strlen($characters) - 1)
            ];
        }

        session()->set(
            'admin_login_captcha',
            $captcha
        );

        return $captcha;
    }

    // 重新產生驗證碼
    public function refreshCaptcha()
    {
        $captcha = $this->generateCaptcha();

        return $this->response->setJSON([
            'success' => true,
            'captcha' => $captcha,
        ]);
    }

    // 管理員登入頁面
    public function login()
    {
        // 若已登入
        if (session()->get('admin_logged_in')) {

            if (session()->get('admin_must_change_password')) {
                return redirect()->to('/admin/change-password');
            }

            return redirect()->to('/admin');
        }

        // 每次進入登入頁面都重新產生驗證碼
        $captcha = $this->generateCaptcha();

        return view('admin/login', [
            'captcha' => $captcha,
        ]);
    }

    // 處理登入
    public function attemptLogin()
    {
        $username = trim($this->request->getPost('username'));
        $password = $this->request->getPost('password');
        $captcha = strtoupper(trim($this->request->getPost('captcha')));

        // 基本驗證
        $rules = [
            'username' => 'required',
            'password' => 'required',
            'captcha'  => 'required',
        ];

        $messages = [
            'username' => [
                'required' => '請輸入管理員帳號。',
            ],

            'password' => [
                'required' => '請輸入管理員密碼。',
            ],

            'captcha' => [
                'required' => '請輸入驗證碼。',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }


        // 驗證 CAPTCHA
        $sessionCaptcha =
            session()->get(
                'admin_login_captcha'
            );

        if (
            !$sessionCaptcha ||
            strtoupper($sessionCaptcha) !== $captcha
        ) {

            // 驗證失敗後清除舊驗證碼
            session()->remove(
                'admin_login_captcha'
            );

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    '驗證碼錯誤，請重新輸入。'
                );
        }

        // CAPTCHA 使用一次後清除
        session()->remove(
            'admin_login_captcha'
        );


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