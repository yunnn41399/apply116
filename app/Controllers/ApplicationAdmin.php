<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ApplicationModel;
use App\Models\CandidateModel;

class ApplicationAdmin extends BaseController
{
    protected $applicationModel;
    protected $candidateModel;

    public function __construct()
    {
        $this->applicationModel = new ApplicationModel();
        $this->candidateModel = new CandidateModel();
    }

    // 後臺報名資料列表
    public function index()
    {
        // 取得搜尋關鍵字
        $keyword = trim($this->request->getGet('keyword'));

        // 取得排序欄位
        $sort = $this->request->getGet('sort');

        // 取得排序方向
        $direction = strtoupper($this->request->getGet('direction'));

        // 允許排序的欄位
        $allowedSorts = [
            'id',
            'name',
            'exam_number',
            'birth_date',
            'created_at',
            'updated_at'
        ];

        // 防止使用者傳入不允許的欄位
        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        // 只允許 ASC / DESC
        if (!in_array($direction, ['ASC', 'DESC'], true)) {
            $direction = 'DESC';
        }

        /*
         * applications 與 candidates JOIN
         *
         * applications.candidate_id
         *        ↓
         * candidates.id
         */
        $builder = $this->applicationModel
            ->select(
                'applications.id,
                applications.candidate_id,
                applications.birth_date,
                applications.created_at,
                applications.updated_at,
                candidates.name,
                candidates.exam_number,
                candidates.id_number'
            )
            ->join(
                'candidates',
                'candidates.id = applications.candidate_id',
                'inner'
            );

        // 搜尋
        if ($keyword !== '') {

            $builder->groupStart()
                ->like('candidates.name', $keyword)
                ->orLike('candidates.exam_number', $keyword)
                ->orLike('candidates.id_number', $keyword)
                ->groupEnd();
        }

        // 排序
        if ($sort === 'name') {

            $builder->orderBy(
                'candidates.name',
                $direction
            );

        } elseif ($sort === 'exam_number') {

            $builder->orderBy(
                'candidates.exam_number',
                $direction
            );

        } else {

            $builder->orderBy(
                'applications.' . $sort,
                $direction
            );
        }
        
        // 每頁 10 筆
        $applications = $builder->paginate(10);

        return view('admin/applications/index', [
            'applications' => $applications,
            'keyword' => $keyword,
            'sort' => $sort,
            'direction' => $direction,
            'pager' => $this->applicationModel->pager
        ]);
    }

    // 查看單筆報名資料
    public function detail($id)
    {
        $application = $this->applicationModel
            ->select(
                'applications.id,
                applications.candidate_id,
                applications.birth_date,
                applications.phone,
                applications.address,
                applications.current_school,
                applications.created_at,
                applications.updated_at,
                candidates.name,
                candidates.exam_number,
                candidates.id_number'
            )
            ->join(
                'candidates',
                'candidates.id = applications.candidate_id',
                'inner'
            )
            ->where('applications.id', $id)
            ->first();

        if (!$application) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                '找不到此報名資料'
            );
        }

        return view('admin/applications/detail', [
            'application' => $application
        ]);
    }
}