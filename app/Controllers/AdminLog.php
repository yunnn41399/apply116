<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminLogModel;

class AdminLog extends BaseController
{
    protected $adminLogModel;

    public function __construct()
    {
        $this->adminLogModel = new AdminLogModel();
    }

    // 管理員操作紀錄列表
    public function index()
    {
        // 取得搜尋關鍵字
        $keyword = trim(
            $this->request->getGet('keyword') ?? ''
        );

        // 取得排序欄位
        $sort = $this->request->getGet('sort');

        // 取得排序方向
        $direction = strtoupper(
            $this->request->getGet('direction') ?? ''
        );

        // 允許排序的欄位
        $allowedSorts = [
            'id',
            'username',
            'admin_name',
            'action',
            'description',
            'created_at',
        ];

        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'id';
        }

        // 只允許 ASC / DESC
        if (!in_array($direction, ['ASC', 'DESC'], true)) {
            $direction = 'DESC';
        }

        /*
         * admin_logs 與 admins JOIN
         *
         * admin_logs.admin_id
         *        ↓
         * admins.id
         */
        $builder = $this->adminLogModel
            ->select(
                'admin_logs.*,
                 admins.username,
                 admins.name AS admin_name'
            )
            ->join(
                'admins',
                'admins.id = admin_logs.admin_id',
                'left'
            );

        // 搜尋
        if ($keyword !== '') {

            $builder->groupStart()
                ->like('admins.username', $keyword)
                ->orLike('admins.name', $keyword)
                ->orLike('admin_logs.action', $keyword)
                ->orLike('admin_logs.description', $keyword)
                ->groupEnd();
        }


        if ($sort === 'username') {

            $builder->orderBy(
                'admins.username',
                $direction
            );

        } elseif ($sort === 'admin_name') {

            $builder->orderBy(
                'admins.name',
                $direction
            );

        } else {

            $builder->orderBy(
                'admin_logs.' . $sort,
                $direction
            );
        }

        // 每頁 20 筆
        $logs = $builder->paginate(20);

        return view('admin/logs/index', [
            'logs'      => $logs,
            'keyword'   => $keyword,
            'sort'      => $sort,
            'direction' => $direction,
            'pager'     => $this->adminLogModel->pager,
        ]);
    }
}