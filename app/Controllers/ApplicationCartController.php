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
        if (!session()->get('isLoggedIn')) {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    '請先登入後再進入網路報名系統。'
                );
        }
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
        $hasBasicData =
            !empty($application['birth_date'])
            && !empty($application['phone'])
            && !empty($application['address'])
            && !empty($application['email']);
        if (!$hasBasicData) {
            return redirect()
                ->to('/application')
                ->with(
                    'error',
                    '請先完成報名基本資料，才能查看我的校系清單。'
                );
        }
        $isConfirmed =
            ($application['status'] ?? 'draft')
            === 'confirmed';
        $cartModel = new ApplicationCartModel();
        $cartModel
            ->select(
                'application_cart.*, '
                . 'departments.university_code, '
                . 'departments.university_name, '
                . 'departments.department_code, '
                . 'departments.department_name, '
                . 'departments.admission_quota, '
                . 'departments.chinese_requirement, '
                . 'departments.english_requirement, '
                . 'departments.math_a_requirement, '
                . 'departments.math_b_requirement, '
                . 'departments.social_requirement, '
                . 'departments.natural_requirement, '
                . 'departments.english_listening_requirement'
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
            );
        $perPage = 30;
        $cartItems = $cartModel->paginate(
            $perPage,
            'application_cart'
        );
        $pager = $cartModel->pager;
        return view(
            'Apply/application_cart',
            [
                'application' =>
                    $application,
                'cartItems' =>
                    $cartItems,
                'pager' => $pager,
                'isConfirmed' =>
                    $isConfirmed,
            ]
        );
    }
    public function add($departmentId = null)
    {
        if (!session()->get('isLoggedIn')) {
            return $this->ajaxOrRedirect(
                '請先登入後再進行此操作。'
            );
        }
        if (empty($departmentId)) {
            return $this->ajaxOrRedirect(
                '無效的校系資料。'
            );
        }
        $candidateId = session()->get(
            'candidate_id'
        );
        if (empty($candidateId)) {
            session()->destroy();
            return $this->ajaxOrRedirect(
                '登入資料已失效，請重新登入。'
            );
        }
        $applicationModel =
            new ApplicationModel();
        $application = $applicationModel
            ->where(
                'candidate_id',
                $candidateId
            )
            ->first();
        if (!$application) {
            return $this->ajaxOrRedirect(
                '請先完成報名基本資料。'
            );
        }
        if (
            ($application['status'] ?? 'draft')
            !== 'draft'
        ) {
            return $this->ajaxOrRedirect(
                '報名資料已確認送出，目前無法修改。'
            );
        }
        $departmentModel =
            new DepartmentModel();
        $department = $departmentModel
            ->where(
                'id',
                $departmentId
            )
            ->first();
        if (!$department) {
            return $this->ajaxOrRedirect(
                '找不到指定的校系資料。'
            );
        }
        $cartModel =
            new ApplicationCartModel();
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
            return $this->ajaxOrRedirect(
                '此校系已經加入您的校系清單。'
            );
        }
        $inserted = $cartModel->insert([
            'application_id' =>
                $application['id'],
            'department_id' =>
                $departmentId,
        ]);
        if (!$inserted) {
            return $this->ajaxOrRedirect(
                '加入校系失敗，請稍後再試。'
            );
        }
        $message =
            '已將「'
            . $department['university_name']
            . ' '
            . $department['department_name']
            . '」加入校系清單。';
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => $message,
                'department_id' =>
                    (int) $departmentId,
            ]);
        }
        return redirect()
            ->back()
            ->with(
                'success',
                $message
            );
    }
    public function remove($departmentId = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    '請先登入後再進行此操作。'
                );
        }
        if (empty($departmentId)) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    '無效的校系資料。'
                );
        }
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
        if (
            ($application['status'] ?? 'draft')
            !== 'draft'
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    '報名資料已確認送出，目前無法修改。'
                );
        }
        $cartModel = new ApplicationCartModel();
        $cartItem = $cartModel
            ->select(
                'application_cart.*, '
                . 'departments.university_name, '
                . 'departments.department_name'
            )
            ->join(
                'departments',
                'departments.id = application_cart.department_id'
            )
            ->where(
                'application_cart.application_id',
                $application['id']
            )
            ->where(
                'application_cart.department_id',
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
        $deleted = $cartModel->delete(
            $cartItem['id']
        );
        if (!$deleted) {
            return $this->ajaxOrRedirect(
                '移除校系失敗，請稍後再試。'
            );
        }
        $message = '已從校系清單移除「'
            . $cartItem['university_name']
            . ' '
            . $cartItem['department_name']
            . '」。';
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => $message,
                'department_id' => (int) $departmentId,
            ]);
        }
        return redirect()
            ->back()
            ->with(
                'success',
                $message
            );
    }
    private function ajaxOrRedirect(
        string $message,
        bool $success = false
    ) {
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => $success,
                'message' => $message,
            ]);
        }
        return redirect()
            ->back()
            ->with(
                $success ? 'success' : 'error',
                $message
            );
    }
}