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
            'admin_change_password_captcha',
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


    // 修改密碼頁面
    public function changePassword()
    {

        $captcha = $this->generateCaptcha();

        return view('admin/change_password', [
            'captcha' => $captcha,
        ]);
    }

    // 處理修改密碼
    public function updatePassword()
    {
        $password = $this->request->getPost('password');
        $passwordConfirm = $this->request->getPost('password_confirm');
        $captcha = strtoupper(trim($this->request->getPost('captcha')));
        
        // 驗證新密碼
        $rules = [
            'password' => 'required|min_length[8]|regex_match[/[A-Z]/]|regex_match[/[a-z]/]|regex_match[/[0-9]/]',
            'password_confirm' => 'required|matches[password]',
            'captcha'  => 'required',
        ];

        $messages = [
            'password' => [
                'required' => '請輸入新密碼。',
                'min_length' => '新密碼至少需要 8 個字元。',
                'max_length' => '新密碼不可超過 255 個字元。',
                'regex_match' => '新密碼必須包含至少 1 個大寫英文字母、1 個小寫英文字母及 1 個數字。',
            ],

            'password_confirm' => [
                'required' => '請再次輸入新密碼。',
                'matches' => '兩次輸入的新密碼不一致。',
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
                'admin_change_password_captcha'
            );

        if (
            !$sessionCaptcha ||
            strtoupper($sessionCaptcha) !== $captcha
        ) {

            // 驗證失敗後清除舊驗證碼
            session()->remove(
                'admin_change_password_captcha'
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
            'admin_change_password_captcha'
        );

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