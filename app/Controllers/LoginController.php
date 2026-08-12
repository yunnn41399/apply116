<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CandidateModel;
use CodeIgniter\HTTP\ResponseInterface;

class LoginController extends BaseController
{
    public function index()
    {
        // 產生 4 位數英數驗證碼
        $captcha = strtoupper(substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 4));

        // 將驗證碼存入 Session
        session()->set('captcha', $captcha);

        return view('Login/login', ['captcha' => $captcha]);
    }

    public function login()
    {
        // 取得表單資料
        $examNumber = trim($this->request->getPost('exam_number'));
        $idNumber = trim($this->request->getPost('id_number'));
        $password = $this->request->getPost('password');
        $captcha = strtoupper(trim($this->request->getPost('captcha')));

        // 驗證必填欄位
        if (
            empty($examNumber) || empty($idNumber) || empty($password) || empty($captcha)
        ) {
            return redirect()->back()->withInput()->with('error', '請完整填寫所有欄位。');
        }

        // 驗證碼檢查
        $sessionCaptcha = session()->get('captcha');
        if ($captcha !== $sessionCaptcha) {
            return redirect()->back()->withInput()->with('error', '驗證碼錯誤');
        }

        // 建立 CandidateModel
        $candidateModel = new CandidateModel();

        // 檢查學測應試號碼
        $candidate = $candidateModel
            ->where('exam_number', $examNumber)
            ->first();

        if (!$candidate) {
            return redirect()->back()
                ->withInput()
                ->with('error', '學測應試號碼錯誤');
        }

        // 檢查身分證號碼
        if ($candidate['id_number'] !== $idNumber) {
            return redirect()->back()
                ->withInput()
                ->with('error', '身分證號碼錯誤');
        }

        // 檢查密碼
        if (!password_verify($password, $candidate['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', '個人密碼錯誤');
        }

        // 登入成功，建立 Session 
        session()->set(['candidate_id' => $candidate['id'], 'exam_number' => $candidate['exam_number'], 'isLoggedIn' => true,]);

        // 登入成功後刪除驗證碼 
        session()->remove('captcha');

        // 導向網路報名首頁 
        return redirect()->to('/registration');
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
