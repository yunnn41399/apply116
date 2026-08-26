<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\AdminModel;

class AdminAuthFilter implements FilterInterface
{

    // 在 Controller 執行之前執行
    public function before(RequestInterface $request, $arguments = null)
    {
        // 尚未登入管理員
        if (!session()->get('admin_logged_in')) {
            return redirect()
                ->to('/admin/login')
                ->with('error', '請先登入管理員帳號');
        }

        // 取得目前登入管理員 ID
        $adminId = session()->get('admin_id');

        // Session 沒有管理員 ID
        if (!$adminId) {

            $this->logoutAdmin();

            return redirect()
                ->to('/admin/login')
                ->with('error', '登入狀態無效，請重新登入。');
        }

        // 從資料庫重新取得管理員資料
        $adminModel = new AdminModel();

        $admin = $adminModel->find($adminId);

        // 找不到管理員帳號
        if (!$admin) {

            $this->logoutAdmin();

            return redirect()
                ->to('/admin/login')
                ->with('error', '管理員帳號不存在，請重新登入。');
        }

        // 管理員帳號已被停用
        if ($admin['status'] !== 'active') {

            $this->logoutAdmin();

            return redirect()
                ->to('/admin/login')
                ->with('error', '您的管理員帳號已被停用。');
        }

        // 重新同步管理員資料
        // 確保 Session 中的管理員資料與資料庫最新狀態一致。
        session()->set([
            'admin_logged_in' => true,
            'admin_id' => $admin['id'],
            'admin_username' => $admin['username'],
            'admin_name' => $admin['name'],
            'admin_role' => $admin['role'],
            'admin_must_change_password' => $admin['must_change_password'],
        ]);

        // 第一次登入必須修改密碼
        // change-password 頁面本身必須允許進入，否則會形成重新導向迴圈。
        $currentPath = trim(
            $request->getUri()->getPath(),
            '/'
        );

        if (
            (int) $admin['must_change_password'] === 1
            && $currentPath !== 'admin/change-password'
        ) {
            return redirect()->to('/admin/change-password');
        }
    }


    // 清除管理員登入 Session
    private function logoutAdmin()
    {
        session()->remove([
            'admin_logged_in',
            'admin_id',
            'admin_username',
            'admin_name',
            'admin_role',
            'admin_must_change_password',
        ]);

        session()->regenerate(true);
    }


    // 在 Controller 執行之後執行
    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {

    }
}