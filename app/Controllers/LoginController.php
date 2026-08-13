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
        $idLastFour = trim($this->request->getPost('id_last_four'));
        $password = $this->request->getPost('password');
        $captcha = strtoupper(trim($this->request->getPost('captcha')));

        $candidateModel = new CandidateModel();

        //檢查學測應試號碼
        if (empty($examNumber)) {
            return redirect()->back()
                ->with('error', '請輸入學測應試號碼。');
        }

        $candidate = $candidateModel
            ->where('exam_number', $examNumber)
            ->first();

        if (!$candidate) {
            return redirect()->back()
                ->with('error', '學測應試號碼錯誤。');
        }

        //檢查身分證末四碼
        if (empty($idLastFour)) {
            session()->setFlashdata('old_exam_number', $examNumber);

            return redirect()->back()
                ->with('error', '請輸入身分證號碼末四碼。');
        }

        $lastFourDigits = substr($candidate['id_number'], -4);

        if ($idLastFour !== $lastFourDigits) {
            session()->setFlashdata('old_exam_number', $examNumber);

            return redirect()->back()
                ->with('error', '身分證號碼錯誤。');
        }

        //檢查密碼
        if (empty($password)) {
            session()->setFlashdata('old_exam_number', $examNumber);

            return redirect()->back()
                ->with('error', '請輸入個人密碼。');
        }

        if (!password_verify($password, $candidate['password'])) {
            session()->setFlashdata('old_exam_number', $examNumber);

            return redirect()->back()
                ->with('error', '個人密碼錯誤。');
        }

        //檢查驗證碼
        if (empty($captcha)) {
            session()->setFlashdata('old_exam_number', $examNumber);

            return redirect()->back()
                ->with('error', '請輸入驗證碼。');
        }

        $sessionCaptcha = session()->get('captcha');

        if ($captcha !== $sessionCaptcha) {
            session()->setFlashdata('old_exam_number', $examNumber);

            return redirect()->back()
                ->with('error', '驗證碼錯誤。');
        }

        //登入成功
        session()->set([
            'candidate_id' => $candidate['id'],
            'exam_number' => $candidate['exam_number'],
            'isLoggedIn' => true,
        ]);

        session()->remove('captcha');

        return redirect()->to('/registration');
    }
    public function refreshCaptcha()
    {
        // 產生新的 4 碼驗證碼
        $captcha = strtoupper(
            substr(
                str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'),
                0,
                4
            )
        );

        // 更新 Session
        session()->set('captcha', $captcha);

        // 回傳 JSON
        return $this->response->setJSON([
            'success' => true,
            'captcha' => $captcha
        ]);
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
