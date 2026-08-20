<?php

namespace App\Services;

use App\Models\AdminLogModel;

class AdminLogService
{
    protected $adminLogModel;

    public function __construct()
    {
        $this->adminLogModel = new AdminLogModel();
    }

    /**
     * 建立管理員操作紀錄
     */
    public function log(
        string $action,
        string $description
    ): bool {

        $adminId = session()->get('admin_id');

        // 沒有管理員 Session 時不建立紀錄
        if (empty($adminId)) {
            return false;
        }

        return $this->adminLogModel->insert([
            'admin_id' => $adminId,
            'action' => $action,
            'description' => $description,
            'created_at' => date('Y-m-d H:i:s'),
        ]) !== false;
    }
}