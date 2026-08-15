<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CandidateModel;
use CodeIgniter\HTTP\ResponseInterface;
class ApplyController extends BaseController
{
    public function index()
    {
        // 檢查是否已登入
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')
                ->with('error', '請先登入後再進入網路報名系統。');
        }
        // 取得目前登入考生的 ID
        $candidateId = session()->get('candidate_id');
        // 查詢考生資料
        $candidateModel = new CandidateModel();
        $candidate = $candidateModel
            ->where('id', $candidateId)
            ->first();
        // 找不到考生資料
        if (!$candidate) {
            session()->destroy();
            return redirect()->to('/login')
                ->with('error', '找不到考生資料，請重新登入。');
        }
        // 傳送資料給 View
        return view('Apply/index', [
            'candidate' => $candidate
        ]);
    }
}