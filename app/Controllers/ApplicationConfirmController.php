<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ApplicationModel;
use App\Models\ApplicationCartModel;
use App\Models\CandidateModel;
use App\Models\ApplicationDepartmentModel;
class ApplicationConfirmController extends BaseController
{
    // ========================================
    // 報名資料核對頁面
    // ========================================
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    '請先登入後再進行報名。'
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
        $candidateModel =
            new CandidateModel();
        $candidate = $candidateModel
            ->where(
                'id',
                $candidateId
            )
            ->first();
        if (!$candidate) {
            session()->destroy();
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    '找不到考生資料，請重新登入。'
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
                ->to('/application-status')
                ->with(
                    'error',
                    '您的報名已確認送出，無法再次修改。'
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
                    '報名資料尚未填寫完整，請先完成報名資料。'
                );
        }
        $selectedDepartmentIds =
            session()->get(
                'application_selected_department_ids'
            );
        if (!is_array($selectedDepartmentIds)) {
            $selectedDepartmentIds = [];
        }
        $selectedDepartmentIds = array_map(
            'intval',
            $selectedDepartmentIds
        );
        $selectedDepartmentIds =
            array_values(
                array_unique(
                    $selectedDepartmentIds
                )
            );
        if (
            count($selectedDepartmentIds) < 1
        ) {
            return redirect()
                ->to('/application/selection')
                ->with(
                    'error',
                    '請至少選擇 1 個正式報名校系。'
                );
        }
        if (
            count($selectedDepartmentIds) > 6
        ) {
            return redirect()
                ->to('/application/selection')
                ->with(
                    'error',
                    '正式報名校系最多只能選擇 6 個。'
                );
        }
        $cartModel =
            new ApplicationCartModel();
        $cartItems = $cartModel
            ->select(
                'application_cart.department_id, '
                . 'departments.department_code, '
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
            ->whereIn(
                'application_cart.department_id',
                $selectedDepartmentIds
            )
            ->findAll();
        if (
            count($cartItems)
            !== count($selectedDepartmentIds)
        ) {
            return redirect()
                ->to('/application/selection')
                ->with(
                    'error',
                    '部分選擇的校系已不存在於您的候選清單，請重新選擇。'
                );
        }
        $cartItemsByDepartmentId = [];
        foreach ($cartItems as $item) {
            $cartItemsByDepartmentId[
                (int) $item['department_id']
            ] = $item;
        }
        $selectedDepartments = [];
        foreach (
            $selectedDepartmentIds
            as $departmentId
        ) {
            if (
                isset(
                $cartItemsByDepartmentId[
                    $departmentId
                ]
            )
            ) {
                $selectedDepartments[] =
                    $cartItemsByDepartmentId[
                        $departmentId
                    ];
            }
        }
        return view(
            'Apply/application_confirm',
            [
                'candidate' =>
                    $candidate,
                'application' =>
                    $application,
                'selectedDepartments' =>
                    $selectedDepartments,
            ]
        );
    }
    public function submit()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    '登入資料已失效，請重新登入。'
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
        $applicationModel =
            new ApplicationModel();
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
                    '找不到報名資料。'
                );
        }
        if (
            ($application['status'] ?? 'draft')
            !== 'draft'
        ) {
            return redirect()
                ->to('/application-status')
                ->with(
                    'error',
                    '報名已確認送出，無法重複送出。'
                );
        }
        $selectedDepartmentIds =
            session()->get(
                'application_selected_department_ids'
            );
        if (!is_array($selectedDepartmentIds)) {
            $selectedDepartmentIds = [];
        }
        $selectedDepartmentIds = array_values(
            array_unique(
                array_map(
                    'intval',
                    $selectedDepartmentIds
                )
            )
        );
        if (
            count($selectedDepartmentIds) < 1
            || count($selectedDepartmentIds) > 6
        ) {
            return redirect()
                ->to('/application/selection')
                ->with(
                    'error',
                    '正式報名校系必須選擇 1～6 個。'
                );
        }
        $cartModel =
            new ApplicationCartModel();
        $cartItems = $cartModel
            ->where(
                'application_id',
                $application['id']
            )
            ->whereIn(
                'department_id',
                $selectedDepartmentIds
            )
            ->findAll();
        if (
            count($cartItems)
            !== count($selectedDepartmentIds)
        ) {
            return redirect()
                ->to('/application/selection')
                ->with(
                    'error',
                    '部分正式報名校系資料已變更，請重新確認。'
                );
        }
        $db = \Config\Database::connect();
        $db->transStart();
        try {
            $applicationDepartmentModel =
                new ApplicationDepartmentModel();
            $confirmedAt = date(
                'Y-m-d H:i:s'
            );
            foreach (
                $selectedDepartmentIds
                as $departmentId
            ) {
                $applicationDepartmentModel->insert([
                    'application_id' =>
                        $application['id'],
                    'department_id' =>
                        $departmentId,
                    'confirmed_at' =>
                        $confirmedAt,
                ]);
            }
            $updated =
                $applicationModel->update(
                    $application['id'],
                    [
                        'status' =>
                            'confirmed',
                    ]
                );
            if (!$updated) {
                throw new \RuntimeException(
                    '報名狀態更新失敗。'
                );
            }
            $db->transComplete();
            if (!$db->transStatus()) {
                throw new \RuntimeException(
                    '資料庫交易失敗。'
                );
            }
            session()->remove(
                'application_selected_department_ids'
            );
            return redirect()
                ->to('/application-status')
                ->with(
                    'success',
                    '報名已正式送出，請查看您的報名狀態。'
                );
        } catch (
            \Throwable $e
        ) {
            $db->transRollback();
            log_message(
                'error',
                '正式報名送出失敗：'
                . $e->getMessage()
            );
            return redirect()
                ->back()
                ->with(
                    'error',
                    '報名送出失敗，請稍後再試。'
                );
        }
    }
}