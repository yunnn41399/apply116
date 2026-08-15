<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CandidateModel;
use CodeIgniter\HTTP\ResponseInterface;

class PasswordController extends BaseController
{
    public function forgot()
    {

        $captcha = strtoupper(
            substr(
                str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'),
                0,
                4
            )
        );

        session()->set('captcha', $captcha);

        return view('Login/forgot_password', [
            'captcha' => $captcha
        ]);
    }

    public function verify()
    {

        $examNumber = trim(
            $this->request->getPost('exam_number')
        );

        $idLastFour = trim(
            $this->request->getPost('id_last_four')
        );

        $captcha = strtoupper(
            trim(
                $this->request->getPost('captcha')
            )
        );


        $candidateModel = new CandidateModel();

        if (empty($examNumber)) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    '請輸入學測應試號碼。'
                );
        }

        $candidate = $candidateModel
            ->where('exam_number', $examNumber)
            ->first();

        if (!$candidate) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    '學測應試號碼錯誤。'
                );
        }

        if (empty($idLastFour)) {

            session()->setFlashdata(
                'old_exam_number',
                $examNumber
            );

            return redirect()
                ->back()
                ->with(
                    'error',
                    '請輸入身分證號碼末四碼。'
                );
        }

        if (!preg_match('/^[0-9]{4}$/', $idLastFour)) {

            session()->setFlashdata(
                'old_exam_number',
                $examNumber
            );

            return redirect()
                ->back()
                ->with(
                    'error',
                    '身分證號碼末四碼必須為 4 位數字。'
                );
        }

        $lastFourDigits = substr(
            $candidate['id_number'],
            -4
        );

        if ($idLastFour !== $lastFourDigits) {

            session()->setFlashdata(
                'old_exam_number',
                $examNumber
            );

            return redirect()
                ->back()
                ->with(
                    'error',
                    '身分證號碼錯誤。'
                );
        }

        if (empty($captcha)) {

            session()->setFlashdata(
                'old_exam_number',
                $examNumber
            );

            return redirect()
                ->back()
                ->with(
                    'error',
                    '請輸入驗證碼。'
                );
        }

        $sessionCaptcha = session()->get('captcha');

        if (
            empty($sessionCaptcha) ||
            $captcha !== strtoupper($sessionCaptcha)
        ) {

            session()->setFlashdata(
                'old_exam_number',
                $examNumber
            );

            return redirect()
                ->back()
                ->with(
                    'error',
                    '驗證碼錯誤。'
                );
        }

        session()->set([
            'password_reset_candidate_id' => $candidate['id'],
            'password_reset_verified' => true,
        ]);

        session()->remove('captcha');

        return redirect()->to('/reset-password');
    }

    public function reset()
    {
        $verified = session()->get(
            'password_reset_verified'
        );

        $candidateId = session()->get(
            'password_reset_candidate_id'
        );


        if (!$verified || !$candidateId) {

            return redirect()
                ->to('/forgot-password')
                ->with(
                    'error',
                    '請先完成身分驗證。'
                );
        }

        return view('Login/reset_password');
    }

    public function update()
    {
        $verified = session()->get(
            'password_reset_verified'
        );

        $candidateId = session()->get(
            'password_reset_candidate_id'
        );


        if (!$verified || !$candidateId) {

            return redirect()
                ->to('/forgot-password')
                ->with(
                    'error',
                    '請先完成身分驗證。'
                );
        }

        $newPassword = $this->request->getPost(
            'password'
        );

        $passwordConfirm = $this->request->getPost(
            'password_confirm'
        );

        if (empty($newPassword)) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    '請輸入新密碼。'
                );
        }

        if (strlen($newPassword) < 8) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    '密碼至少需要 8 個字元。'
                );
        }

        if (!preg_match('/[A-Z]/', $newPassword)) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    '密碼至少需要 1 個大寫英文字母。'
                );
        }

        if (!preg_match('/[a-z]/', $newPassword)) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    '密碼至少需要 1 個小寫英文字母。'
                );
        }

        if (!preg_match('/[0-9]/', $newPassword)) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    '密碼至少需要 1 個數字。'
                );
        }

        if (empty($passwordConfirm)) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    '請輸入確認密碼。'
                );
        }

        if ($newPassword !== $passwordConfirm) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    '兩次輸入的密碼不一致。'
                );
        }

        $candidateModel = new CandidateModel();

        $hashedPassword = password_hash(
            $newPassword,
            PASSWORD_DEFAULT
        );

        $updated = $candidateModel->update(
            $candidateId,
            [
                'password' => $hashedPassword,
            ]
        );

        if (!$updated) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    '密碼更新失敗，請稍後再試。'
                );
        }

        session()->remove([
            'password_reset_candidate_id',
            'password_reset_verified',
        ]);

        return redirect()
            ->to('/login')
            ->with(
                'success',
                '密碼修改成功，請使用新密碼重新登入。'
            );
    }
}