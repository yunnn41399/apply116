<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class AdminForgotPassword extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    // =========================================================
    // 忘記密碼頁面
    // =========================================================

    public function index()
    {
        // 產生 4 碼英數驗證碼
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $captcha = '';

        for ($i = 0; $i < 4; $i++) {
            $captcha .= $characters[
                random_int(0, strlen($characters) - 1)
            ];
        }

        // 儲存到 Session
        session()->set(
            'admin_forgot_captcha',
            $captcha
        );

        return view('admin/forgot_password', [
            'captcha' => $captcha,
        ]);
    }


    // =========================================================
    // 重新產生驗證碼
    // =========================================================

    public function refreshCaptcha()
    {
        // 產生 4 碼英數驗證碼
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $captcha = '';

        for ($i = 0; $i < 4; $i++) {
            $captcha .= $characters[
                random_int(0, strlen($characters) - 1)
            ];
        }

        // 儲存到 Session
        session()->set(
            'admin_forgot_captcha',
            $captcha
        );

        return $this->response->setJSON([
            'success' => true,
            'captcha' => $captcha,
        ]);
    }


    // =========================================================
    // 處理忘記密碼
    // =========================================================

    public function sendResetLink()
    {
        // 取得表單資料
        $username = trim(
            $this->request->getPost('username')
        );

        $email = trim(
            $this->request->getPost('email')
        );

        $captcha = strtoupper(
            trim($this->request->getPost('captcha'))
        );


        // =====================================================
        // 基本驗證
        // =====================================================

        $rules = [
            'username' => 'required|max_length[50]',
            'email'    => 'required|valid_email|max_length[255]',
            'captcha'  => 'required',
        ];

        $messages = [

            'username' => [
                'required' => '請輸入管理員帳號。',
                'max_length' => '管理員帳號不可超過 50 個字元。',
            ],

            'email' => [
                'required' => '請輸入 Email。',
                'valid_email' => '請輸入有效的 Email。',
                'max_length' => 'Email 不可超過 255 個字元。',
            ],

            'captcha' => [
                'required' => '請輸入驗證碼。',
            ],
        ];


        if (!$this->validate($rules, $messages)) {

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
            session()->get('admin_forgot_captcha');


        if (
            !$sessionCaptcha ||
            strtoupper($sessionCaptcha) !== $captcha
        ) {

            // 驗證碼錯誤後立即清除
            session()->remove(
                'admin_forgot_captcha'
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
            'admin_forgot_captcha'
        );


        // =====================================================
        // 查詢管理員
        // =====================================================

        $admin = $this->adminModel
            ->where('username', $username)
            ->where('email', $email)
            ->first();


        // =====================================================
        // 帳號或 Email 不正確
        // =====================================================

        if (!$admin) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    '提供的帳號或 Email 資訊不正確。'
                );
        }


        // =====================================================
        // 管理員帳號已停用
        // =====================================================

        if ($admin['status'] !== 'active') {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    '此管理員帳號目前已停用，無法進行密碼重設。'
                );
        }


        // =====================================================
        // 產生密碼重設 Token
        // =====================================================

        $token = bin2hex(
            random_bytes(32)
        );


        // Token 有效期限
        // 這裡設定為 30 分鐘
        $expiresAt = date(
            'Y-m-d H:i:s',
            time() + (30 * 60)
        );


        // =====================================================
        // 儲存 Token
        // =====================================================

        $result = $this->adminModel->update(
            $admin['id'],
            [
                'password_reset_token' =>
                    hash('sha256', $token),

                'password_reset_expires_at' =>
                    $expiresAt,
            ]
        );


        if ($result === false) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    '系統發生錯誤，無法建立密碼重設連結。'
                );
        }


        // =====================================================
        // 建立重設密碼網址
        // =====================================================

        $resetUrl =
            site_url(
                'admin/reset-password?token='
                . urlencode($token)
            );


        // =====================================================
        // 建立 Email
        // =====================================================

        $emailService = \Config\Services::email();
        
        $emailService->setFrom(
            env('ADMIN_DEFAULT_EMAIL'),
            'Apply116 後臺管理'
        );

        $emailService->setTo($email);

        $emailService->setSubject(
            'Apply116 後臺管理 - 密碼重設'
        );

        // 設定 Email 為 HTML
        $emailService->setMailType('html');

        $emailBody = view(
            'emails/admin_reset_password',
            [
                'username'  => $admin['username'],
                'resetUrl'  => $resetUrl,
                'expiresAt' => $expiresAt,
            ],
            ['debug' => false]
        );

        $emailService->setMessage($emailBody);

        // =====================================================
        // 寄送 Email
        // =====================================================

        if (!$emailService->send()) {

            // 寄信失敗時清除 Token
            $this->adminModel->update(
                $admin['id'],
                [
                    'password_reset_token' => null,
                    'password_reset_expires_at' => null,
                ]
            );

            log_message(
                'error',
                '管理員密碼重設 Email 寄送失敗：'
                . $emailService->printDebugger(
                    ['headers']
                )
            );

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    '重設密碼信件寄送失敗，請稍後再試。'
                );
        }


        // =====================================================
        // 完成
        // =====================================================

        return redirect()
            ->to('/admin/login')
            ->with(
                'success',
                '密碼重設連結已寄至您的 Email，請於 30 分鐘內完成密碼重設。'
            );
    }
}