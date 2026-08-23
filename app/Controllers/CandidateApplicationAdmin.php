<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ApplicationModel;

class CandidateApplicationAdmin extends BaseController
{
    protected $applicationModel;

    public function __construct()
    {
        $this->applicationModel = new ApplicationModel();
    }

    // 後臺報名資料列表
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

        $direction = strtoupper(
            $this->request->getGet('direction')
        );


        // =========================
        // 允許排序的欄位
        // =========================

        $allowedSorts = [
            'id' => 'applications.id',
            'name' => 'candidates.name',
            'exam_number' => 'candidates.exam_number',
            'birth_date' => 'applications.birth_date',
            'current_school' => 'applications.current_school',
            'created_at' => 'applications.created_at',
        ];


        // 如果沒有指定或指定錯誤
        // 預設依報名時間由新到舊

        if (!isset($allowedSorts[$sort])) {
            $sort = 'created_at';
        }


        // =========================
        // 排序方向
        // =========================

        if (!in_array($direction, ['ASC', 'DESC'], true)) {
            $direction = 'DESC';
        }


        // =========================
        // 建立查詢
        // =========================

        $builder = $this->applicationModel
            ->select('
                applications.*,
                candidates.name,
                candidates.exam_number,
                candidates.id_number
            ')
            ->join(
                'candidates',
                'candidates.id = applications.candidate_id'
            );


        // =========================
        // 搜尋
        // =========================

        if ($keyword !== '') {

            $builder->groupStart()
                ->like('candidates.name', $keyword)
                ->orLike('candidates.exam_number', $keyword)
                ->orLike('candidates.id_number', $keyword)
                ->groupEnd();
        }


        // =========================
        // 排序
        // =========================

        $builder->orderBy(
            $allowedSorts[$sort],
            $direction
        );


        // =========================
        // 每頁 10 筆
        // =========================

        $applications = $builder->paginate(10);


        // =========================
        // 傳送資料到 View
        // =========================

        return view('admin/applications/index', [
            'applications' => $applications,
            'keyword' => $keyword,
            'sort' => $sort,
            'direction' => $direction,
            'pager' => $this->applicationModel->pager,
        ]);
    }
}