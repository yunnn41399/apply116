<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\DepartmentModel;
class DepartmentController extends BaseController
{
    public function index()
    {
        // 檢查是否已登入
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')
                ->with('error', '請先登入後再查詢校系資料。');
        }
        // 建立 Department Model
        $departmentModel = new DepartmentModel();
        // 取得所有校系資料
        $departments = $departmentModel
            ->orderBy('university_name', 'ASC')
            ->orderBy('department_name', 'ASC')
            ->findAll();
        // 傳送資料給 View
        return view('Apply/department', [
            'departments' => $departments
        ]);
    }
}