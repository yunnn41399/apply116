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
     * 建立目前登入管理員的操作紀錄
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

        return $this->logByAdminId(
            $adminId,
            $action,
            $description
        );
    }


    /**
     * 指定管理員 ID 建立操作紀錄
     *
     * 用於尚未登入的流程，例如：
     * 忘記密碼 → Email → 重設密碼
     */
    public function logByAdminId(
        int $adminId,
        string $action,
        string $description
    ): bool {

        if ($adminId <= 0) {
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