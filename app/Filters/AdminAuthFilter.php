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
        // 檢查管理員是否已登入
        if (
            !session()->get('admin_logged_in') ||
            !session()->get('admin_id')
        ) {
            return redirect()
                ->to('/admin/login')
                ->with('error', '請先登入管理員帳號');
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