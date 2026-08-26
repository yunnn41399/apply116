<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Services\AdminLogService;

class AdminResetPassword extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    // =========================================================
    // 產生驗證碼
    // =========================================================

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
            'admin_reset_captcha',
            $captcha
        );

        return $captcha;
    }

    // =========================================================
    // 重新產生驗證碼
    // =========================================================

    public function refreshCaptcha()
    {
        $captcha = $this->generateCaptcha();

        return $this->response->setJSON([
            'success' => true,
            'captcha' => $captcha,
        ]);
    }


    // =========================================================
    // 顯示重設密碼頁面
    // =========================================================

    public function index()
    {
        // 取得 URL 中的 Token
        $token = $this->request->getGet('token');

        if (!$token) {
            return redirect()
                ->to('/admin/login')
                ->with(
                    'error',
                    '密碼重設連結無效。'
                );
        }

        // 將 Token 雜湊後再查詢資料庫
        $hashedToken = hash(
            'sha256',
            $token
        );

        $admin = $this->adminModel
            ->where(
                'password_reset_token',
                $hashedToken
            )
            ->first();

        // Token 不存在
        if (!$admin) {
            return redirect()
                ->to('/admin/login')
                ->with(
                    'error',
                    '密碼重設連結無效或已失效。'
                );
        }

        // =====================================================
        // 檢查 Token 是否過期
        // =====================================================

        if (
            empty($admin['password_reset_expires_at']) ||
            strtotime(
                $admin['password_reset_expires_at']
            ) < time()
        ) {

            // 清除過期 Token
            $this->adminModel->update(
                $admin['id'],
                [
                    'password_reset_token' =>
                        null,

                    'password_reset_expires_at' =>
                        null,
                ]
            );

            return redirect()
                ->to('/admin/login')
                ->with(
                    'error',
                    '密碼重設連結已過期，請重新申請。'
                );
        }

        // =====================================================
        // 檢查管理員是否仍為啟用狀態
        // =====================================================

        if ($admin['status'] !== 'active') {
            return redirect()
                ->to('/admin/login')
                ->with(
                    'error',
                    '此管理員帳號目前已停用，無法重設密碼。'
                );
        }

        // =====================================================
        // 產生驗證碼
        // =====================================================

        $captcha = $this->generateCaptcha();

        // =====================================================
        // 顯示重設密碼頁面
        // =====================================================

        return view(
            'admin/reset_password',
            [
                'token'   => $token,
                'captcha' => $captcha,
            ]
        );
    }


    // =========================================================
    // 更新密碼
    // =========================================================

    public function update()
    {
        $token = $this->request->getPost('token');

        $password = $this->request->getPost('password');

        $passwordConfirm =
            $this->request->getPost(
                'password_confirm'
            );

        $captcha = strtoupper(
            trim(
                $this->request->getPost('captcha')
            )
        );

        // =====================================================
        // 基本驗證
        // =====================================================

        $rules = [
            'token' => 'required',

            'password' =>
                'required|min_length[8]|regex_match[/[A-Z]/]|regex_match[/[a-z]/]|regex_match[/[0-9]/]',

            'password_confirm' =>
                'required|matches[password]',

            'captcha' =>
                'required',
        ];

        $messages = [

            'token' => [
                'required' =>
                    '密碼重設連結無效。',
            ],

            'password' => [
                'required' =>
                    '請輸入新密碼。',

                'min_length' =>
                    '密碼至少需要 8 個字元。',

                'regex_match' =>
                    '密碼必須包含至少 1 個大寫英文字母、1 個小寫英文字母及 1 個數字。',
            ],

            'password_confirm' => [
                'required' =>
                    '請再次輸入新密碼。',

                'matches' =>
                    '兩次輸入的密碼不一致。',
            ],

            'captcha' => [
                'required' =>
                    '請輸入驗證碼。',
            ],
        ];

        if (
            !$this->validate(
                $rules,
                $messages
            )
        ) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
        }

        // =====================================================
        // 驗證 CAPTCHA
        // =====================================================

        $sessionCaptcha =
            session()->get(
                'admin_reset_captcha'
            );

        if (
            !$sessionCaptcha ||
            strtoupper($sessionCaptcha) !== $captcha
        ) {

            // 驗證失敗後清除舊驗證碼
            session()->remove(
                'admin_reset_captcha'
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
            'admin_reset_captcha'
        );

        // =====================================================
        // 驗證 Token
        // =====================================================

        $hashedToken = hash(
            'sha256',
            $token
        );

        $admin = $this->adminModel
            ->where(
                'password_reset_token',
                $hashedToken
            )
            ->first();

        if (!$admin) {

            return redirect()
                ->to('/admin/login')
                ->with(
                    'error',
                    '密碼重設連結無效或已失效。'
                );
        }

        // =====================================================
        // 檢查 Token 是否過期
        // =====================================================

        if (
            empty($admin['password_reset_expires_at']) ||
            strtotime(
                $admin['password_reset_expires_at']
            ) < time()
        ) {

            $this->adminModel->update(
                $admin['id'],
                [
                    'password_reset_token' =>
                        null,

                    'password_reset_expires_at' =>
                        null,
                ]
            );

            return redirect()
                ->to('/admin/login')
                ->with(
                    'error',
                    '密碼重設連結已過期，請重新申請。'
                );
        }

        // =====================================================
        // 檢查管理員是否仍為啟用狀態
        // =====================================================

        if ($admin['status'] !== 'active') {

            return redirect()
                ->to('/admin/login')
                ->with(
                    'error',
                    '此管理員帳號目前已停用，無法重設密碼。'
                );
        }

        // =====================================================
        // 更新密碼
        // =====================================================

        $result = $this->adminModel->update(
            $admin['id'],
            [
                'password' =>
                    password_hash(
                        $password,
                        PASSWORD_DEFAULT
                    ),

                // 重設成功後立即清除 Token
                'password_reset_token' =>
                    null,

                'password_reset_expires_at' =>
                    null,

                // 重設密碼後不需要強制再次修改
                'must_change_password' =>
                    0,
            ]
        );

        if ($result === false) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    '密碼更新失敗，請稍後再試。'
                );
        }


        // =====================================================
        // 建立管理員操作紀錄
        // =====================================================

        $logService = new AdminLogService();

        $logService->logByAdminId(
            (int) $admin['id'],
            '更新管理員密碼',
            '管理員「' . $admin['username'] . '」透過忘記密碼功能重設密碼'
        );

        // =====================================================
        // 完成
        // =====================================================

        return redirect()
            ->to('/admin/login')
            ->with(
                'success',
                '密碼已成功重設，請使用新密碼登入。'
            );
    }
}