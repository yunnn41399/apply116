<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CandidateModel;

class Register extends BaseController
{
    protected $helpers = ['form'];
    private function generateCaptcha(): string
    {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $captcha = '';

        for ($i = 0; $i < 4; $i++) {
            $captcha .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $captcha;
    }

    public function index()
    {
        // 每次進入註冊頁面，都產生新的驗證碼
        $captcha = $this->generateCaptcha();

        session()->set('captcha', $captcha);

        return view('register', [
            'captcha' => $captcha
        ]);
    }

    public function refreshCaptcha()
    {
        $captcha = $this->generateCaptcha();
        session()->set('captcha', $captcha);

        return $this->response->setJSON([
            'success'  => true,
            'captcha'  => $captcha,
            'csrfHash' => csrf_hash(),
        ]);
    }
    
    public function register()
    {
        $rules = [
            'name' => [
                'label' => '姓名',
                'rules' => 'required|max_length[50]|regex_match[/^[\x{4e00}-\x{9fff}A-Za-z]+$/u]',
                'errors' => [
                    'required'   => '請輸入姓名。',
                    'max_length' => '姓名不可超過 50 個字元。',
                    'regex_match'  => '姓名不可輸入數字或特殊字元。',
                ],
            ],

            'exam_number' => [
                'label' => '學測應試號碼',
                'rules' => 'required|regex_match[/^[0-9]{8}$/]|min_length[8]|max_length[8]',
                'errors' => [
                    'required'      => '請輸入學測應試號碼。',
                    'regex_match'   => '學測應試號碼只能包含數字。',
                    'min_length'    => '學測應試號碼至少需要 8 個字元。',
                    'max_length'    => '學測應試號碼不可超過 8 個字元。',
                ],
            ],

            'id_number' => [
                'label' => '身分證號碼',
                'rules' => 'required|regex_match[/^[A-Z][12][0-9]{8}$/]|taiwan_id',
                'errors' => [
                    'required'    => '請輸入身分證號碼。',
                    'regex_match' => '身分證號碼格式不正確。',
                    'taiwan_id'  => '身分證號碼檢查碼不正確。',
                ],
            ],

            'password' => [
                'label' => '個人密碼',
                'rules' => 'required|min_length[8]|max_length[255]|regex_match[/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).+$/]',
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
                'rules' => 'required|exact_length[4]|regex_match[/^[A-Za-z0-9]{4}$/]',
                'errors' => [
                    'required'     => '請輸入驗證碼。',
                    'exact_length' => '驗證碼必須為 4 碼。',
                    'regex_match'  => '驗證碼只能包含英文字母和數字。',
                ],
            ],
        ];

        $errors = [];

        $isValid = $this->validate($rules);

        if (! $isValid) {
            $errors = $this->validator->getErrors();
        }


        $name       = trim((string) $this->request->getPost('name'));
        $examNumber = trim((string) $this->request->getPost('exam_number'));
        $idNumber   = strtoupper(trim((string) $this->request->getPost('id_number')));
        $password   = (string) $this->request->getPost('password');
        $captcha = strtoupper(trim((string) $this->request->getPost('captcha')));

        $sessionCaptcha = strtoupper((string) session()->get('captcha'));

        if (
            empty($errors['captcha']) &&
            $captcha !== $sessionCaptcha
        ) {
            $errors['captcha'] = '驗證碼錯誤。';
        }

        $model = new CandidateModel();

        if ($examNumber !== '') {
            if ($model->where('exam_number', $examNumber)->first()) {
                $errors['exam_number_duplicate'] = '此學測應試號碼已經註冊。';
            }
        }

        if ($idNumber !== '') {
            if ($model->where('id_number', $idNumber)->first()) {
                $errors['id_number_duplicate'] = '此身分證號碼已經註冊。';
            }
        }

        if (! empty($errors)) {
            return redirect()->back()
                ->withInput()
                ->with('registerErrors', $errors);
        }

        $model->insert([
            'name'        => $name,
            'exam_number' => $examNumber,
            'id_number'   => $idNumber,
            'password'    => password_hash($password, PASSWORD_DEFAULT),
        ]);

        // 註冊成功後清除舊驗證碼
        session()->remove('captcha');

        return view('register_success', [
            'name' => $name,
        ]);
    }
}