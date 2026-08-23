<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ApplicationCartModel;
use App\Models\ApplicationModel;
class ApplicationSelectionController extends BaseController
{
    // ========================================
    // 選擇正式報名校系
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
                    '請先完成報名基本資料，才能選擇正式報名校系。'
                );
        }
        if (
            ($application['status'] ?? 'draft')
            === 'confirmed'
        ) {
            return redirect()
                ->to('/application-status')
                ->with(
                    'error',
                    '您的報名已確認送出，目前無法修改報名校系。'
                );
        }
        $cartModel =
            new ApplicationCartModel();
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
            'application_selection'
        );
        $pager = $cartModel->pager;
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
        if (!empty($selectedDepartmentIds)) {
            $validSelectedItems =
                $cartModel
                    ->db
                    ->table('application_cart')
                    ->select('department_id')
                    ->where(
                        'application_id',
                        $application['id']
                    )
                    ->whereIn(
                        'department_id',
                        $selectedDepartmentIds
                    )
                    ->get()
                    ->getResultArray();
            $validSelectedIds = array_map(
                'intval',
                array_column(
                    $validSelectedItems,
                    'department_id'
                )
            );
            $selectedDepartmentIds =
                array_values(
                    array_intersect(
                        $selectedDepartmentIds,
                        $validSelectedIds
                    )
                );
            $selectedDepartmentIds =
                array_slice(
                    $selectedDepartmentIds,
                    0,
                    6
                );
            session()->set(
                'application_selected_department_ids',
                $selectedDepartmentIds
            );
        }
        return view(
            'Apply/application_selection',
            [
                'application' =>
                    $application,
                'cartItems' =>
                    $cartItems,
                'pager' =>
                    $pager,
                'selectedDepartmentIds' =>
                    $selectedDepartmentIds,
                'selectedCount' =>
                    count(
                        $selectedDepartmentIds
                    ),
            ]
        );
    }
    public function toggleSelection()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'success' => false,
                    'message' => '登入資料已失效，請重新登入。',
                ]);
        }
        $candidateId = session()->get(
            'candidate_id'
        );
        if (empty($candidateId)) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'success' => false,
                    'message' => '登入資料已失效，請重新登入。',
                ]);
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
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'message' => '請先完成報名基本資料。',
                ]);
        }
        if (
            ($application['status'] ?? 'draft')
            !== 'draft'
        ) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'message' => '報名資料已確認送出，目前無法修改。',
                ]);
        }
        $departmentId = (int) (
            $this->request->getPost(
                'department_id'
            ) ?? 0
        );
        $isChecked =
            $this->request->getPost(
                'checked'
            ) === '1';
        if ($departmentId <= 0) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'message' => '無效的校系資料。',
                ]);
        }
        $cartModel =
            new ApplicationCartModel();
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
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'message' => '此校系不在您的候選清單中。',
                ]);
        }
        $selectedIds =
            session()->get(
                'application_selected_department_ids'
            );
        if (!is_array($selectedIds)) {
            $selectedIds = [];
        }
        $selectedIds = array_map(
            'intval',
            $selectedIds
        );
        if ($isChecked) {
            if (
                !in_array(
                    $departmentId,
                    $selectedIds,
                    true
                )
            ) {
                if (count($selectedIds) >= 6) {
                    return $this->response
                        ->setStatusCode(400)
                        ->setJSON([
                            'success' => false,
                            'message' =>
                                '正式報名校系最多只能選擇 6 個。',
                            'selectedCount' =>
                                count($selectedIds),
                        ]);
                }
                $selectedIds[] =
                    $departmentId;
            }
        } else {
            $selectedIds =
                array_values(
                    array_diff(
                        $selectedIds,
                        [$departmentId]
                    )
                );
        }
        session()->set(
            'application_selected_department_ids',
            $selectedIds
        );
        return $this->response->setJSON([
            'success' => true,
            'selectedCount' =>
                count($selectedIds),
        ]);
    }
    public function saveSelection()
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
                    '報名資料已確認送出，目前無法修改。'
                );
        }
        $selectedIds =
            session()->get(
                'application_selected_department_ids'
            );
        if (!is_array($selectedIds)) {
            $selectedIds = [];
        }
        $selectedIds = array_map(
            'intval',
            $selectedIds
        );
        if (count($selectedIds) < 1) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    '請至少選擇 1 個正式報名校系。'
                );
        }
        if (count($selectedIds) > 6) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    '正式報名校系最多只能選擇 6 個。'
                );
        }
        $cartModel =
            new ApplicationCartModel();
        $validItems = $cartModel
            ->select(
                'department_id'
            )
            ->where(
                'application_id',
                $application['id']
            )
            ->whereIn(
                'department_id',
                $selectedIds
            )
            ->findAll();
        $validIds = array_map(
            'intval',
            array_column(
                $validItems,
                'department_id'
            )
        );
        if (
            count($validIds)
            !== count($selectedIds)
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    '部分選擇的校系已不在候選清單中，請重新選擇。'
                );
        }
        return redirect()
            ->to('/application/confirm');
    }
}