<?php

namespace App\Filters;

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
        // 尚未登入管理員
        if (!session()->get('admin_logged_in')) {
            return redirect()
                ->to('/admin/login')
                ->with('error', '請先登入管理員帳號');
        }

        /*
         * 第一次登入必須修改密碼
         *
         * change-password 頁面本身必須允許進入，
         * 否則會形成重新導向迴圈。
         */
        $currentPath = trim(
            $request->getUri()->getPath(),
            '/'
        );

        if (
            session()->get('admin_must_change_password')
            && $currentPath !== 'admin/change-password'
        ) {
            return redirect()->to('/admin/change-password');
        }
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