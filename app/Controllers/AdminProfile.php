<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Services\AdminLogService;

class AdminProfile extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    // 我的帳號頁面
    public function index()
    {
        // 取得目前登入的管理員 ID
        $adminId = session()->get('admin_id');

        // 查詢目前登入的管理員
        $admin = $this->adminModel->find($adminId);

        if (!$admin) {
            return redirect()
                ->to('/admin/login')
                ->with('error', '找不到目前的管理員帳號。');
        }

        return view('admin/profile', [
            'admin' => $admin,
        ]);
    }

    // 更新自己的帳號資料
    public function update()
    {
        // 只能取得目前登入管理員的 ID
        $adminId = session()->get('admin_id');

        // 查詢目前登入的管理員
        $admin = $this->adminModel->find($adminId);

        if (!$admin) {
            return redirect()
                ->to('/admin/login')
                ->with('error', '找不到目前的管理員帳號。');
        }

        // 取得表單資料
        $name = trim($this->request->getPost('name'));

        $password = $this->request->getPost('password');
        $passwordConfirm = $this->request->getPost('password_confirm');

        // 基本驗證
        $rules = [
            'name' => 'required|max_length[50]',
        ];

        $messages = [
            'name' => [
                'required'   => '請輸入管理員姓名。',
                'max_length' => '管理員姓名不可超過 50 個字元。',
            ],
        ];

        // 如果有輸入新密碼，才驗證密碼
        if ($password !== '' || $passwordConfirm !== '') {

            $rules['password'] =
                'required|min_length[8]|max_length[255]';

            $rules['password_confirm'] =
                'required|matches[password]';

            $messages['password'] = [
                'required'   => '請輸入新密碼。',
                'min_length' => '新密碼至少需要 8 個字元。',
                'max_length' => '新密碼不可超過 255 個字元。',
            ];

            $messages['password_confirm'] = [
                'required' => '請再次輸入新密碼。',
                'matches'  => '兩次輸入的新密碼不一致。',
            ];
        }

        // 執行驗證
        if (!$this->validate($rules, $messages)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // =========================
        // 建立更新資料
        // =========================

        $data = [
            'name' => $name,
        ];

        // 如果有輸入新密碼，才更新密碼
        if ($password !== '') {
            $data['password'] = password_hash(
                $password,
                PASSWORD_DEFAULT
            );
        }

        // 更新管理員資料
        $result = $this->adminModel->update($adminId, $data);

        if ($result === false) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->adminModel->errors()
                );
        }

        // =========================
        // 更新 Session 中的姓名
        // =========================

        session()->set([
            'admin_name' => $name,
        ]);

        // =========================
        // 建立操作紀錄
        // =========================

        $changes = [];

        // 姓名變更
        if ($admin['name'] !== $name) {
            $changes[] =
                '姓名：' . $admin['name'] . ' → ' . $name;
        }

        // 密碼變更
        if ($password !== '') {
            $changes[] = '已修改密碼';
        }

        // 如果有實際變更才建立紀錄
        if (!empty($changes)) {

            $logService = new AdminLogService();

            $logService->log(
                '修改自己的管理員帳號',
                '管理員：' . $admin['username'] .
                '（' . implode('、', $changes) . '）'
            );
        }

        return redirect()
            ->to('/admin/profile')
            ->with('success', '管理員帳號資料更新成功。');
    }
}