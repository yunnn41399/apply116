<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminRoleFilter implements FilterInterface
{
    /**
     * 在 Controller 執行之前執行
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // 取得目前登入管理員的角色
        $adminRole = session()->get('admin_role');

        // 如果沒有指定角色
        if (empty($arguments)) {
            return redirect()
                ->to('/admin')
                ->with('error', '沒有指定管理員權限');
        }

        // 判斷目前管理員是否具有指定角色
        if (!in_array($adminRole, $arguments, true)) {
            return redirect()
                ->to('/admin')
                ->with('error', '您沒有權限使用此功能');
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