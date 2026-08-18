<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CandidateModel;

class CandidateAdmin extends BaseController
{
    protected $candidateModel;

    public function __construct()
    {
        $this->candidateModel = new CandidateModel();
    }

    // 後臺考生資料列表
    public function index()
    {
        // =========================
        // 取得搜尋關鍵字
        // =========================

        $keyword = trim($this->request->getGet('keyword'));

        // =========================
        // 取得排序欄位
        // =========================

        $sort = $this->request->getGet('sort');

        // =========================
        // 取得排序方向
        // =========================

        $direction = strtoupper($this->request->getGet('direction'));

        // =========================
        // 允許排序的欄位
        // =========================

        $allowedSorts = [
            'id',
            'name',
            'exam_number',
            'id_number',
            'created_at'
        ];

        // 如果沒有指定或指定了不允許的欄位
        // 預設依註冊時間由新到舊
        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        // 只允許 ASC / DESC
        if (!in_array($direction, ['ASC', 'DESC'], true)) {
            $direction = 'DESC';
        }

        // =========================
        // 建立查詢
        // =========================

        $builder = $this->candidateModel;

        // =========================
        // 搜尋
        // =========================

        if ($keyword !== '') {

            $builder->groupStart()
                ->like('name', $keyword)
                ->orLike('exam_number', $keyword)
                ->orLike('id_number', $keyword)
                ->groupEnd();
        }

        // =========================
        // 排序
        // =========================

        $builder->orderBy($sort, $direction);

        // =========================
        // 分頁
        // =========================

        $candidates = $builder->paginate(10);

        // =========================
        // 傳送資料給 View
        // =========================

        return view('admin/candidates/index', [
            'candidates' => $candidates,
            'keyword' => $keyword,
            'sort' => $sort,
            'direction' => $direction,
            'pager' => $this->candidateModel->pager
        ]);
    }
}