<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CandidateModel;

class Register extends BaseController
{
    protected $helpers = ['form'];
    
    public function index()
    {
        $captcha = session()->get('captcha');

        if ($captcha === null) {
            $captcha = (string) random_int(1000, 9999); // 確保存入的是字串 (string)
            session()->set('captcha', $captcha);
        }

        return view('register', [
            'captcha' => (string) $captcha
        ]);
    }

    public function refreshCaptcha()
    {
        $captcha = (string) random_int(1000, 9999); // 確保存入的是字串 (string)
        session()->set('captcha', $captcha);

        return $this->response->setJSON([
            'success'   => true,
            'captcha'   => $captcha,
            'csrfHash'  => csrf_hash(),
        ]);
    }
    
    public function register()
    {
        $rules = [
            'name' => [
                'label' => '姓名',
                'rules' => 'required|max_length[50]',
                'errors' => [
                    'required'   => '請輸入姓名。',
                    'max_length' => '姓名不可超過 50 個字元。',
                ],
            ],

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
                'rules' => 'required|exact_length[4]|numeric',
                'errors' => [
                    'required'     => '請輸入驗證碼。',
                    'exact_length' => '驗證碼必須為 4 位數字。',
                    'numeric'      => '驗證碼只能輸入數字。',
                ],
            ],
        ];

        // 儲存所有錯誤
        $errors = [];

        // 1. 執行欄位格式驗證
        $isValid = $this->validate($rules);

        if (! $isValid) {
            $errors = $this->validator->getErrors();
        }


        // 取得使用者輸入資料
        $name       = trim((string) $this->request->getPost('name'));
        $examNumber = trim((string) $this->request->getPost('exam_number'));
        $idNumber   = strtoupper(trim((string) $this->request->getPost('id_number')));
        $password   = (string) $this->request->getPost('password');
        $captcha    = trim((string) $this->request->getPost('captcha'));

        // 2. 檢查 CAPTCHA
        $sessionCaptcha = (string) session()->get('captcha'); // 強制轉為字串再做嚴格比對

        if (
            empty($errors['captcha']) &&
            $captcha !== $sessionCaptcha
        ) {
            $errors['captcha'] = '驗證碼錯誤。';
        }

        // 3. 檢查資料庫是否重複註冊
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

        // 4. 如果有任何錯誤，一次把所有錯誤傳回註冊頁面。
        if (! empty($errors)) {
            return redirect()->back()
                ->withInput()
                ->with('registerErrors', $errors);
        }

        // 5. 所有驗證都通過將資料寫入資料庫。
        $model->insert([
            'name'        => $name,
            'exam_number' => $examNumber,
            'id_number'   => $idNumber,
            'password'    => password_hash($password, PASSWORD_DEFAULT),
        ]);

        return view('register_success', [
            'name' => $name,
        ]);
    }
}