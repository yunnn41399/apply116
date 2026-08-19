<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ApplicationCartModel;
use App\Models\ApplicationModel;
use App\Models\DepartmentModel;
class ApplicationCartController extends BaseController
{
    // ========================================
    // 我的校系清單
    // ========================================
    public function index()
    {
        // ========================================
        // 1. 檢查是否已登入
        // ========================================
        if (!session()->get('isLoggedIn')) {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    '請先登入後再進入網路報名系統。'
                );
        }
        // ========================================
        // 2. 取得目前考生 ID
        // ========================================
        $candidateId = session()->get(
            'candidate_id'
        );
        if (empty($candidateId)) {
            session()->destroy();
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    '登入資料已失效，請重新登入。'
                );
        }
        // ========================================
        // 3. 找到目前考生的 applications
        // ========================================
        $applicationModel = new ApplicationModel();
        $application = $applicationModel
            ->where(
                'candidate_id',
                $candidateId
            )
            ->first();
        // 如果還沒有建立報名資料
        if (!$application) {
            return redirect()
                ->to('/application')
                ->with(
                    'error',
                    '請先完成報名基本資料。'
                );
        }
        // ========================================
        // 4. 如果已正式確認報名
        // ========================================
        if (
            $application['status']
            === 'confirmed'
        ) {
            return view(
                'Apply/application_cart',
                [
                    'application' =>
                        $application,
                    'cartItems' =>
                        [],
                    'isConfirmed' =>
                        true,
                ]
            );
        }
        // ========================================
        // 5. 取得購物車
        // ========================================
        $cartModel = new ApplicationCartModel();
        $cartItems = $cartModel
            ->select(
                'application_cart.*, '
                . 'departments.university_code, '
                . 'departments.university_name, '
                . 'departments.department_code, '
                . 'departments.department_name, '
                . 'departments.admission_quota'
            )
            ->join(
                'departments',
                'departments.id = application_cart.department_id'
            )
            ->where(
                'application_cart.application_id',
                $application['id']
            )
            ->orderBy(
                'application_cart.created_at',
                'ASC'
            )
            ->findAll();
        // ========================================
        // 6. 傳送給 View
        // ========================================
        return view(
            'Apply/application_cart',
            [
                'application' =>
                    $application,
                'cartItems' =>
                    $cartItems,
                'isConfirmed' =>
                    false,
            ]
        );
    }
    // ========================================
    // 加入校系
    // ========================================
    public function add($departmentId = null)
    {
        // ========================================
        // 1. 檢查登入
        // ========================================
        if (!session()->get('isLoggedIn')) {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    '請先登入後再進行此操作。'
                );
        }
        // ========================================
        // 2. 檢查 department ID
        // ========================================
        if (empty($departmentId)) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    '無效的校系資料。'
                );
        }
        // ========================================
        // 3. 取得 candidate ID
        // ========================================
        $candidateId = session()->get(
            'candidate_id'
        );
        if (empty($candidateId)) {
            session()->destroy();
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    '登入資料已失效，請重新登入。'
                );
        }
        // ========================================
        // 4. 查詢 applications
        // ========================================
        $applicationModel = new ApplicationModel();
        $application = $applicationModel
            ->where(
                'candidate_id',
                $candidateId
            )
            ->first();
        if (!$application) {
            return redirect()
                ->to('/application')
                ->with(
                    'error',
                    '請先完成報名基本資料。'
                );
        }
        // ========================================
        // 5. 確認是否仍為 draft
        // ========================================
        if (
            $application['status']
            !== 'draft'
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    '報名資料已確認送出，目前無法修改。'
                );
        }
        // ========================================
        // 6. 確認校系是否存在
        // ========================================
        $departmentModel = new DepartmentModel();
        $department = $departmentModel
            ->where(
                'id',
                $departmentId
            )
            ->first();
        if (!$department) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    '找不到指定的校系資料。'
                );
        }
        // ========================================
        // 7. 檢查是否已經加入
        // ========================================
        $cartModel = new ApplicationCartModel();
        $existing = $cartModel
            ->where(
                'application_id',
                $application['id']
            )
            ->where(
                'department_id',
                $departmentId
            )
            ->first();
        if ($existing) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    '此校系已經加入您的校系清單。'
                );
        }
        // ========================================
        // 8. 加入購物車
        // ========================================
        $inserted = $cartModel->insert([
            'application_id' =>
                $application['id'],
            'department_id' =>
                $departmentId,
        ]);
        if (!$inserted) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    '加入校系失敗，請稍後再試。'
                );
        }
        return redirect()
            ->back()
            ->with(
                'success',
                '已將「'
                . $department['university_name']
                . ' '
                . $department['department_name']
                . '」加入校系清單。'
            );
    }
    // ========================================
    // 移除校系
    // ========================================
    public function remove($departmentId = null)
    {
        // ========================================
        // 1. 檢查登入
        // ========================================
        if (!session()->get('isLoggedIn')) {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    '請先登入後再進行此操作。'
                );
        }
        // ========================================
        // 2. 檢查 department ID
        // ========================================
        if (empty($departmentId)) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    '無效的校系資料。'
                );
        }
        // ========================================
        // 3. 取得 candidate ID
        // ========================================
        $candidateId = session()->get(
            'candidate_id'
        );
        if (empty($candidateId)) {
            session()->destroy();
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    '登入資料已失效，請重新登入。'
                );
        }
        // ========================================
        // 4. 找到 application
        // ========================================
        $applicationModel = new ApplicationModel();
        $application = $applicationModel
            ->where(
                'candidate_id',
                $candidateId
            )
            ->first();
        if (!$application) {
            return redirect()
                ->to('/application')
                ->with(
                    'error',
                    '請先完成報名基本資料。'
                );
        }
        // ========================================
        // 5. 確認仍為 draft
        // ========================================
        if (
            $application['status']
            !== 'draft'
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    '報名資料已確認送出，目前無法修改。'
                );
        }
        // ========================================
        // 6. 找到購物車資料
        // ========================================
        $cartModel = new ApplicationCartModel();
        $cartItem = $cartModel
            ->where(
                'application_id',
                $application['id']
            )
            ->where(
                'department_id',
                $departmentId
            )
            ->first();
        if (!$cartItem) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    '此校系不在您的校系清單中。'
                );
        }
        // ========================================
        // 7. 移除
        // ========================================
        $deleted = $cartModel->delete(
            $cartItem['id']
        );
        if (!$deleted) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    '移除校系失敗，請稍後再試。'
                );
        }
        return redirect()
            ->back()
            ->with(
                'success',
                '已從校系清單移除此校系。'
            );
    }
}