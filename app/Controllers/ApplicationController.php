<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ApplicationModel;
use App\Models\CandidateModel;
use CodeIgniter\HTTP\ResponseInterface;
class ApplicationController extends BaseController
{
    //顯示報名基本資料頁
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')
                ->with(
                    'error',
                    '請先登入後再進入網路報名系統。'
                );
        }
        $candidateId = session()->get('candidate_id');
        if (empty($candidateId)) {
            session()->destroy();
            return redirect()->to('/login')
                ->with(
                    'error',
                    '登入資料已失效，請重新登入。'
                );
        }
        $candidateModel = new CandidateModel();
        $candidate = $candidateModel
            ->where('id', $candidateId)
            ->first();
        if (!$candidate) {
            session()->destroy();
            return redirect()->to('/login')
                ->with(
                    'error',
                    '找不到考生資料，請重新登入。'
                );
        }
        $applicationModel = new ApplicationModel();
        $application = $applicationModel
            ->where(
                'candidate_id',
                $candidateId
            )
            ->first();
        return view(
            'Apply/application',
            [
                'candidate' =>
                    $candidate,
                'application' =>
                    $application,
            ]
        );
    }
    //儲存報名基本資料
    public function save()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')
                ->with(
                    'error',
                    '請先登入後再進行報名。'
                );
        }
        $candidateId = session()->get('candidate_id');
        if (empty($candidateId)) {
            session()->destroy();
            return redirect()->to('/login')
                ->with(
                    'error',
                    '登入資料已失效，請重新登入。'
                );
        }
        $birthDate = trim(
            $this->request->getPost('birth_date') ?? ''
        );
        $phone = trim(
            $this->request->getPost('phone') ?? ''
        );
        $address = trim(
            $this->request->getPost('address') ?? ''
        );
        $currentSchool = trim(
            $this->request->getPost('current_school') ?? ''
        );
        if ($birthDate === '') {
            return redirect()->back()
                ->with(
                    'error',
                    '請輸入出生年月日。'
                );
        }
        if ($phone === '') {

            return redirect()->back()
                ->with(
                    'error',
                    '請輸入手機號碼。'
                );
        }
        if (!preg_match('/^09[0-9]{8}$/', $phone)) {

            return redirect()->back()
                ->with(
                    'error',
                    '手機號碼格式錯誤，請輸入 10 位數手機號碼，例如 0912345678。'
                );
        }
        if ($address === '') {
            return redirect()->back()
                ->with(
                    'error',
                    '請輸入通訊地址。'
                );
        }
        if ($currentSchool === '') {
            return redirect()->back()
                ->with(
                    'error',
                    '請輸入目前就讀學校。'
                );
        }
        $applicationModel = new ApplicationModel();
        $application = $applicationModel
            ->where(
                'candidate_id',
                $candidateId
            )
            ->first();
        $data = [
            'candidate_id' => $candidateId,
            'birth_date' => $birthDate,
            'phone' => $phone,
            'address' => $address,
            'current_school' => $currentSchool,
        ];
        if ($application) {
            $applicationModel->update(
                $application['id'],
                $data
            );
            return redirect()
                ->to('/application')
                ->with(
                    'success',
                    '報名基本資料已更新。'
                );
        }
        $applicationModel->insert($data);
        return redirect()
            ->to('/application')
            ->with(
                'success',
                '報名基本資料已儲存。'
            );
    }
}
