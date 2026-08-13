<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CandidateModel;

class Register extends BaseController
{
    protected $helpers = ['form'];
    
    public function index()
    {
        return view('register');
    }

    public function refreshCaptcha()
    {
        $captcha = (string) random_int(1000, 9999);

        session()->set('captcha', $captcha);

        return redirect()->to('/register');
    }
    
    public function register()
    {
        $rules = [
            'exam_number' => [
                'label' => '學測應試號碼',
                'rules' => 'required|alpha_numeric|min_length[6]|max_length[20]',
                'errors' => [
                    'required'      => '請輸入學測應試號碼。',
                    'alpha_numeric' => '學測應試號碼只能包含英文字母及數字。',
                    'min_length'    => '學測應試號碼至少需要 6 個字元。',
                    'max_length'    => '學測應試號碼不可超過 20 個字元。',
                ],
            ],

            'id_number' => [
                'label' => '身分證號碼',
                'rules' => 'required|regex_match[/^[A-Z][12][0-9]{8}$/]|taiwan_id',
                'errors' => [
                    'required'  => '請輸入身分證號碼。',
                    'regex_match' => '身分證號碼格式不正確。',
                    'taiwan_id' => '身分證號碼檢查碼不正確。',
                ],
            ],

            'password' => [
                'label' => '個人密碼',
                'rules' => 'required|min_length[8]|max_length[255]|regex_match[/[A-Z]/]|regex_match[/[a-z]/]|regex_match[/[0-9]/]',
                'errors' => [
                    'required'    => '請輸入個人密碼。',
                    'min_length'  => '密碼至少需要 8 個字元。',
                    'max_length'  => '密碼不可超過 255 個字元。',
                    'regex_match' => '密碼必須包含至少一個大寫字母、一個小寫字母及一個數字。',
                ],
            ],

            'password_confirm' => [
                'label' => '確認密碼',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => '請再次輸入密碼。',
                    'matches'  => '兩次輸入的密碼不一致。',
                ],
            ],

            'captcha' => [
                'label' => '驗證碼',
                'rules' => 'required|exact_length[4]|numeric',
                'errors' => [
                    'required'     => '請輸入驗證碼。',
                    'exact_length' => '驗證碼必須為 4 位數字。',
                    'numeric'      => '驗證碼只能輸入數字。',
                ],
            ],
        ];

        // 1. 執行基礎欄位驗證失敗時
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        // 2. 檢查驗證碼是否正確
        $captcha = $this->request->getPost('captcha');
        $sessionCaptcha = session()->get('captcha');

        if ($captcha !== $sessionCaptcha) {
            return redirect()->back()->withInput()->with('captchaError', '驗證碼錯誤。');
        }

        // 3. 檢查資料庫是否重複註冊
        $examNumber = $this->request->getPost('exam_number');
        $idNumber   = $this->request->getPost('id_number');
        $password   = $this->request->getPost('password');

        $model = new CandidateModel();

        if ($model->where('exam_number', $examNumber)->first()) {
            return redirect()->back()->withInput()->with('error', '此學測應試號碼已經註冊。');
        }

        if ($model->where('id_number', $idNumber)->first()) {
            return redirect()->back()->withInput()->with('error', '此身分證號碼已經註冊。');
        }

        // 4. 全部驗證通過，寫入資料庫
        $model->insert([
            'exam_number' => $examNumber,
            'id_number'   => $idNumber,
            'password'    => password_hash($password, PASSWORD_DEFAULT),
        ]);

        return view('register_success');
    }
}