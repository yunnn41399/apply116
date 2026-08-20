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

        // 最新紀錄顯示在最前面
        $builder->orderBy(
            'admin_logs.created_at',
            'DESC'
        );

        // 每頁 20 筆
        $logs = $builder->paginate(20);

        return view('admin/logs/index', [
            'logs' => $logs,
            'keyword' => $keyword,
            'pager' => $this->adminLogModel->pager,
        ]);
    }
}