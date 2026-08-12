<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CandidateModel;

class Register extends BaseController
{
    public function index()
    {
        $captcha = (string) random_int(1000, 9999);

        session()->set('captcha', $captcha);

        return view('register', [
            'captcha' => $captcha,
        ]);
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
                'rules' => 'required|regex_match[/^[A-Z][12][0-9]{8}$/]',
                'errors' => [
                    'required'    => '請輸入身分證號碼。',
                    'regex_match' => '身分證號碼格式不正確。',
                ],
            ],

            'password' => [
                'label' => '個人密碼',
                'rules' => 'required|min_length[8]|max_length[255]',
                'errors' => [
                    'required'   => '請輸入個人密碼。',
                    'min_length' => '密碼至少需要 8 個字元。',
                    'max_length' => '密碼不可超過 255 個字元。',
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

        // 執行資料驗證
        if (! $this->validate($rules)) {
            return view('register', [
                'validation' => $this->validator,
            ]);
        }

        //確認驗證碼是否輸入正確
        $captcha = $this->request->getPost('captcha');
        $sessionCaptcha = session()->get('captcha');

        if ($captcha !== $sessionCaptcha) {
            return view('register', [
                'validation' => $this->validator,
                'captcha' => $sessionCaptcha,
                'captchaError' => '驗證碼錯誤。',
            ]);
        }

        $examNumber = $this->request->getPost('exam_number');
        $idNumber = $this->request->getPost('id_number');
        $password = $this->request->getPost('password');

        $model = new CandidateModel();

        if ($model->where('exam_number', $examNumber)->first()) {
            return view('register', [
                'error' => '此學測應試號碼已經註冊。',
            ]);
        }

        if ($model->where('id_number', $idNumber)->first()) {
            return view('register', [
                'error' => '此身分證號碼已經註冊。',
            ]);
        }

        $model->insert([
            'exam_number' => $examNumber,
            'id_number'   => $idNumber,
            'password'    => password_hash($password, PASSWORD_DEFAULT),
        ]);

        return view('register_success');
    }
}