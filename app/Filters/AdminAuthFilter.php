<?php

namespace App\Filters;

use App\Models\AdminModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminAuthFilter implements FilterInterface
{
    /**
     * 在 Controller 執行之前執行
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // 檢查管理員是否已登入
        if (!session()->get('admin_logged_in')) {
            return redirect()
                ->to('/admin/login')
                ->with('error', '請先登入管理員帳號。');
        }

        // 取得目前登入的管理員 ID
        $adminId = session()->get('admin_id');

        if (empty($adminId)) {
            session()->remove([
                'admin_logged_in',
                'admin_id',
                'admin_username',
                'admin_name',
                'admin_role',
            ]);

            session()->regenerate(true);

            return redirect()
                ->to('/admin/login')
                ->with('error', '登入資料已失效，請重新登入。');
        }

        // 從資料庫取得管理員資料
        $adminModel = new AdminModel();

        $admin = $adminModel->find($adminId);

        // 找不到管理員
        if (!$admin) {
            session()->remove([
                'admin_logged_in',
                'admin_id',
                'admin_username',
                'admin_name',
                'admin_role',
            ]);

            session()->regenerate(true);

            return redirect()
                ->to('/admin/login')
                ->with('error', '找不到管理員資料，請重新登入。');
        }

        // 管理員帳號已停用
        if ($admin['status'] !== 'active') {
            session()->remove([
                'admin_logged_in',
                'admin_id',
                'admin_username',
                'admin_name',
                'admin_role',
            ]);

            session()->regenerate(true);

            return redirect()
                ->to('/admin/login')
                ->with('error', '您的管理員帳號已被停用，請聯絡系統管理員。');
        }

        // 同步最新的管理員資料到 Session
        session()->set([
            'admin_username' => $admin['username'],
            'admin_name'     => $admin['name'],
            'admin_role'     => $admin['role'],
        ]);
    }

    /**
     * 在 Controller 執行之後執行
     */
    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {
        // 目前不需要處理
    }
}