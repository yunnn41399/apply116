<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Services\AdminLogService;

class AdminManagement extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }


    // =========================================================
    // 管理員列表
    // =========================================================

    public function index()
    {
        // 取得搜尋關鍵字
        $keyword = trim($this->request->getGet('keyword'));

        // 取得排序欄位
        $sort = $this->request->getGet('sort');

        // 取得排序方向
        $direction = strtoupper($this->request->getGet('direction'));

        // 允許排序的欄位
        $allowedSorts = [
            'id',
            'username',
            'name',
            'role',
            'status',
            'created_at',
        ];

        // 如果沒有指定或指定了不允許的欄位
        // 預設依編號由小到大
        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'id';
        }

        // 只允許 ASC / DESC
        if (!in_array($direction, ['ASC', 'DESC'], true)) {
            $direction = 'ASC';
        }

        // 建立查詢
        $builder = $this->adminModel;

        // 搜尋
        if ($keyword !== '') {

            $builder->groupStart()
                ->like('username', $keyword)
                ->orLike('name', $keyword)
                ->groupEnd();
        }

        // 排序
        $builder->orderBy($sort, $direction);

        // 分頁
        $admins = $builder->paginate(10);

        // 傳送資料給 View
        return view('admin/admins/index', [
            'admins' => $admins,
            'keyword' => $keyword,
            'sort' => $sort,
            'direction' => $direction,
            'pager' => $this->adminModel->pager,
        ]);
    }


    // =========================================================
    // 新增管理員
    // =========================================================

    public function create()
    {
        // GET：顯示新增管理員頁面
        if ($this->request->getMethod() !== 'POST') {
            return view('admin/admins/create');
        }

        // 驗證資料
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|alpha_numeric',
            'password' => 'required|min_length[8]|max_length[255]',
            'password_confirm' => 'required|matches[password]',
            'name' => 'required|max_length[50]',
            'role' => 'required|in_list[admin,super_admin]',
            'status' => 'required|in_list[active,inactive]',
        ];

        $messages = [
            'username' => [
                'required' => '請輸入管理員帳號。',
                'min_length' => '管理員帳號至少需要 3 個字元。',
                'max_length' => '管理員帳號不可超過 50 個字元。',
                'alpha_numeric' => '管理員帳號只能包含英文字母及數字。',
            ],

            'password' => [
                'required' => '請輸入密碼。',
                'min_length' => '密碼至少需要 8 個字元。',
                'max_length' => '密碼不可超過 255 個字元。',
            ],

            'password_confirm' => [
                'required' => '請再次輸入密碼。',
                'matches' => '兩次輸入的密碼不一致。',
            ],

            'name' => [
                'required' => '請輸入管理員姓名。',
                'max_length' => '管理員姓名不可超過 50 個字元。',
            ],

            'role' => [
                'required' => '請選擇管理員角色。',
                'in_list' => '管理員角色選擇無效。',
            ],

            'status' => [
                'required' => '請選擇帳號狀態。',
                'in_list' => '帳號狀態選擇無效。',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $username = trim($this->request->getPost('username'));

        // 檢查帳號是否已存在
        $existingAdmin = $this->adminModel
            ->where('username', $username)
            ->first();

        if ($existingAdmin) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    '此管理員帳號已存在，請使用其他帳號。'
                );
        }

        // 建立管理員資料
        $data = [
            'username' => $username,
            'password' => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),
            'name' => trim($this->request->getPost('name')),
            'role' => $this->request->getPost('role'),
            'status' => $this->request->getPost('status'),
        ];

        $this->adminModel->insert($data);

        // 建立操作紀錄
        $logService = new AdminLogService();

        $logService->log(
            '新增管理員帳號',
            '新增管理員：' . $username
        );

        return redirect()
            ->to('/admin/admins')
            ->with('success', '管理員新增成功。');
    }


    // =========================================================
    // 編輯管理員
    // =========================================================

    public function edit($id)
    {
        // -----------------------------------------------------
        // 取得目前登入的管理員
        // -----------------------------------------------------

        $currentAdminId = session()->get('admin_id');
        $currentAdminRole = session()->get('admin_role');


        // -----------------------------------------------------
        // 找要編輯的管理員
        // -----------------------------------------------------

        $admin = $this->adminModel->find($id);

        if (!$admin) {
            return redirect()
                ->to('/admin/admins')
                ->with('error', '找不到指定的管理員帳號。');
        }


        // -----------------------------------------------------
        // 判斷是不是編輯自己的帳號
        // -----------------------------------------------------

        $isSelf = ((int) $admin['id'] === (int) $currentAdminId);


        // -----------------------------------------------------
        // 如果編輯其他管理員
        // 只有最高管理員可以進行
        // -----------------------------------------------------

        if (!$isSelf && $currentAdminRole !== 'super_admin') {
            return redirect()
                ->to('/admin/admins')
                ->with(
                    'error',
                    '只有最高管理員可以編輯其他管理員帳號。'
                );
        }


        // -----------------------------------------------------
        // GET：顯示編輯頁面
        // -----------------------------------------------------

        if ($this->request->getMethod() !== 'POST') {

            return view('admin/admins/edit', [
                'admin' => $admin,
                'isSelf' => $isSelf,
            ]);
        }


        // =====================================================
        // POST：處理修改
        // =====================================================


        // -----------------------------------------------------
        // 姓名
        // -----------------------------------------------------

        $name = trim($this->request->getPost('name'));


        // -----------------------------------------------------
        // 密碼
        // -----------------------------------------------------

        $password = $this->request->getPost('password');
        $passwordConfirm = $this->request->getPost('password_confirm');


        // =====================================================
        // 編輯自己
        //
        // 自己：
        // - 可以修改姓名
        // - 可以修改密碼
        // - 不可以修改角色
        // - 不可以修改狀態
        //
        // 因此這裡完全不讀取 POST 的 role / status
        // =====================================================

        if ($isSelf) {

            // ---------------------------------------------
            // 驗證姓名
            // ---------------------------------------------

            $rules = [
                'name' => 'required|max_length[50]',
            ];

            $messages = [
                'name' => [
                    'required' => '請輸入管理員姓名。',
                    'max_length' => '管理員姓名不可超過 50 個字元。',
                ],
            ];


            // ---------------------------------------------
            // 如果有輸入密碼，才驗證密碼
            // ---------------------------------------------

            if ($password !== '' || $passwordConfirm !== '') {

                $rules['password'] =
                    'required|min_length[8]|max_length[255]';

                $rules['password_confirm'] =
                    'required|matches[password]';

                $messages['password'] = [
                    'required' => '請輸入新密碼。',
                    'min_length' => '新密碼至少需要 8 個字元。',
                    'max_length' => '新密碼不可超過 255 個字元。',
                ];

                $messages['password_confirm'] = [
                    'required' => '請再次輸入新密碼。',
                    'matches' => '兩次輸入的新密碼不一致。',
                ];
            }


            // ---------------------------------------------
            // 驗證
            // ---------------------------------------------

            if (!$this->validate($rules, $messages)) {

                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'errors',
                        $this->validator->getErrors()
                    );
            }


            // ---------------------------------------------
            // 更新資料
            //
            // 注意：
            // 這裡故意不放 role / status
            // ---------------------------------------------

            $data = [
                'name' => $name,
            ];


            // 有輸入新密碼才更新密碼
            if ($password !== '') {

                $data['password'] = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );
            }


            // ---------------------------------------------
            // 更新資料庫
            // ---------------------------------------------

            $this->adminModel->update($id, $data);


            // ---------------------------------------------
            // 建立操作紀錄
            // ---------------------------------------------

            $logService = new AdminLogService();

            $changes = [];


            // 姓名有變更
            if ($admin['name'] !== $name) {

                $changes[] =
                    '姓名：' . $admin['name'] . ' → ' . $name;
            }


            // 密碼有變更
            if ($password !== '') {

                $changes[] = '已修改密碼';
            }


            // 如果有實際變更才建立紀錄
            if (!empty($changes)) {

                $logDescription =
                    '修改自己的管理員帳號：'
                    . $admin['username']
                    . '（'
                    . implode('、', $changes)
                    . '）';

                $logService->log(
                    '更新管理員帳號資料',
                    $logDescription
                );
            }


            return redirect()
                ->to('/admin/admins')
                ->with(
                    'success',
                    '管理員資料更新成功。'
                );
        }


        // =====================================================
        // 編輯其他管理員
        //
        // 只有 super_admin 可以到這裡
        // 可以修改：
        // - 姓名
        // - 密碼
        // - 角色
        // - 狀態
        // =====================================================


        // -----------------------------------------------------
        // 取得角色與狀態
        // -----------------------------------------------------

        $role = $this->request->getPost('role');
        $status = $this->request->getPost('status');


        // -----------------------------------------------------
        // 驗證資料
        // -----------------------------------------------------

        $rules = [
            'name' => 'required|max_length[50]',
            'role' => 'required|in_list[admin,super_admin]',
            'status' => 'required|in_list[active,inactive]',
        ];

        $messages = [
            'name' => [
                'required' => '請輸入管理員姓名。',
                'max_length' => '管理員姓名不可超過 50 個字元。',
            ],

            'role' => [
                'required' => '請選擇管理員角色。',
                'in_list' => '管理員角色選擇無效。',
            ],

            'status' => [
                'required' => '請選擇帳號狀態。',
                'in_list' => '帳號狀態選擇無效。',
            ],
        ];


        // -----------------------------------------------------
        // 如果有輸入新密碼，才驗證密碼
        // -----------------------------------------------------

        if ($password !== '' || $passwordConfirm !== '') {

            $rules['password'] =
                'required|min_length[8]|max_length[255]';

            $rules['password_confirm'] =
                'required|matches[password]';

            $messages['password'] = [
                'required' => '請輸入新密碼。',
                'min_length' => '新密碼至少需要 8 個字元。',
                'max_length' => '新密碼不可超過 255 個字元。',
            ];

            $messages['password_confirm'] = [
                'required' => '請再次輸入新密碼。',
                'matches' => '兩次輸入的新密碼不一致。',
            ];
        }


        // -----------------------------------------------------
        // 驗證
        // -----------------------------------------------------

        if (!$this->validate($rules, $messages)) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
        }


        // =====================================================
        // 防止最後一個啟用中的 super_admin
        // 被降級或停用
        // =====================================================

        if ($admin['role'] === 'super_admin') {

            // 計算目前有幾個啟用中的最高管理員
            $superAdminCount = $this->adminModel
                ->where('role', 'super_admin')
                ->where('status', 'active')
                ->countAllResults();


            // 如果這是最後一個啟用中的 super_admin
            if ($superAdminCount <= 1) {

                // 不允許降級
                if ($role !== 'super_admin') {

                    return redirect()
                        ->back()
                        ->withInput()
                        ->with(
                            'error',
                            '系統至少需要一位啟用中的最高管理員，無法將最後一位最高管理員降為一般管理員。'
                        );
                }


                // 不允許停用
                if ($status !== 'active') {

                    return redirect()
                        ->back()
                        ->withInput()
                        ->with(
                            'error',
                            '系統至少需要一位啟用中的最高管理員，無法停用最後一位最高管理員。'
                        );
                }
            }
        }


        // =====================================================
        // 更新資料
        // =====================================================

        $data = [
            'name' => $name,
            'role' => $role,
            'status' => $status,
        ];


        // 有輸入新密碼才更新密碼
        if ($password !== '') {

            $data['password'] = password_hash(
                $password,
                PASSWORD_DEFAULT
            );
        }


        // -----------------------------------------------------
        // 更新資料庫
        // -----------------------------------------------------

        $this->adminModel->update($id, $data);


        // =====================================================
        // 建立操作紀錄
        // =====================================================

        $logService = new AdminLogService();

        $logDescription =
            '修改管理員：' . $admin['username'];

        $changes = [];


        // -----------------------------------------------------
        // 姓名有變更
        // -----------------------------------------------------

        if ($admin['name'] !== $name) {

            $changes[] =
                '姓名：'
                . $admin['name']
                . ' → '
                . $name;
        }


        // -----------------------------------------------------
        // 角色有變更
        // -----------------------------------------------------

        if ($admin['role'] !== $role) {

            $oldRoleText =
                $admin['role'] === 'super_admin'
                    ? '最高管理員'
                    : '一般管理員';

            $newRoleText =
                $role === 'super_admin'
                    ? '最高管理員'
                    : '一般管理員';

            $changes[] =
                '角色：'
                . $oldRoleText
                . ' → '
                . $newRoleText;
        }


        // -----------------------------------------------------
        // 狀態有變更
        // -----------------------------------------------------

        if ($admin['status'] !== $status) {

            $oldStatusText =
                $admin['status'] === 'active'
                    ? '啟用'
                    : '停用';

            $newStatusText =
                $status === 'active'
                    ? '啟用'
                    : '停用';

            $changes[] =
                '狀態：'
                . $oldStatusText
                . ' → '
                . $newStatusText;
        }


        // -----------------------------------------------------
        // 密碼有變更
        // -----------------------------------------------------

        if ($password !== '') {

            $changes[] = '已修改密碼';
        }


        // -----------------------------------------------------
        // 如果有實際變更
        // 才建立操作紀錄
        // -----------------------------------------------------

        if (!empty($changes)) {

            $logDescription .=
                '（'
                . implode('、', $changes)
                . '）';

            $logService->log(
                '更新管理員帳號資料',
                $logDescription
            );
        }


        // -----------------------------------------------------
        // 完成
        // -----------------------------------------------------

        return redirect()
            ->to('/admin/admins')
            ->with(
                'success',
                '管理員資料更新成功。'
            );
    }
}