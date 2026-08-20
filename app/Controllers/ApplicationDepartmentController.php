<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ApplicationCartModel;
use App\Models\ApplicationModel;
use App\Models\DepartmentModel;
class ApplicationDepartmentController extends BaseController
{
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
        $candidateId = session()->get('candidate_id');
        if (empty($candidateId)) {
            session()->destroy();
            return redirect()
                ->to('/login')
                ->with(
                    'error',
                    '登入資料已失效，請重新登入。'
                );
        }
        // 查詢目前考生的報名資料
        $applicationModel = new ApplicationModel();
        $application = $applicationModel
            ->where(
                'candidate_id',
                $candidateId
            )
            ->first();
        // 沒有報名資料 → 返回 /application
        if (!$application) {
            return redirect()
                ->to('/application')
                ->with(
                    'error',
                    '請先完成報名基本資料，才能開始選擇校系。'
                );
        }
        // 檢查基本資料是否完整
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
                    '請先完成報名基本資料，才能開始選擇校系。'
                );
        }
        // 已正式確認 → 不允許再修改
        if (
            ($application['status'] ?? 'draft')
            === 'confirmed'
        ) {
            return redirect()
                ->to('/application')
                ->with(
                    'error',
                    '您的報名資料已確認送出，目前無法再選擇或修改校系。'
                );
        }
        $keyword = trim(
            $this->request->getGet('keyword') ?? ''
        );
        $university = trim(
            $this->request->getGet('university') ?? ''
        );
        $englishListening = trim(
            $this->request->getGet('english_listening') ?? ''
        );
        $requirementsStatus = $this->request->getGet(
            'requirements_status'
        );
        if (!is_array($requirementsStatus)) {
            $requirementsStatus = [];
        }
        $departmentModel = new DepartmentModel();
        $universities = (new DepartmentModel())
            ->select(
                'university_code, university_name'
            )
            ->distinct()
            ->orderBy(
                'university_code',
                'ASC'
            )
            ->findAll();
        if ($keyword !== '') {
            $departmentModel
                ->groupStart()
                ->like(
                    'university_name',
                    $keyword
                )
                ->orLike(
                    'department_name',
                    $keyword
                )
                ->groupEnd();
        }
        if ($university !== '') {
            $departmentModel->where(
                'university_code',
                $university
            );
        }
        $requirementFields = [
            'chinese' => [
                'field' => 'chinese_requirement',
                'name' => '國文',
            ],
            'english' => [
                'field' => 'english_requirement',
                'name' => '英文',
            ],
            'math_a' => [
                'field' => 'math_a_requirement',
                'name' => '數學A',
            ],
            'math_b' => [
                'field' => 'math_b_requirement',
                'name' => '數學B',
            ],
            'social' => [
                'field' => 'social_requirement',
                'name' => '社會',
            ],
            'natural' => [
                'field' => 'natural_requirement',
                'name' => '自然',
            ],
        ];
        foreach (
            $requirementFields as $key => $info
        ) {
            $status =
                $requirementsStatus[$key]
                ?? 'any';
            if ($status === 'any') {
                continue;
            }
            $field = $info['field'];
            if ($status === 'required') {
                $departmentModel
                    ->where(
                        $field . ' !=',
                        '--'
                    )
                    ->where(
                        $field . ' !=',
                        ''
                    )
                    ->where(
                        $field . ' IS NOT NULL',
                        null,
                        false
                    );
            } elseif (
                $status === 'not_required'
            ) {
                $departmentModel
                    ->groupStart()
                    ->where(
                        $field,
                        '--'
                    )
                    ->orWhere(
                        $field,
                        ''
                    )
                    ->orWhere(
                        $field . ' IS NULL',
                        null,
                        false
                    )
                    ->groupEnd();
            }
        }
        if (
            $englishListening === 'required'
        ) {
            $departmentModel
                ->where(
                    'english_listening_requirement !=',
                    '--'
                )
                ->where(
                    'english_listening_requirement !=',
                    ''
                )
                ->where(
                    'english_listening_requirement IS NOT NULL',
                    null,
                    false
                );
        } elseif (
            $englishListening === 'not_required'
        ) {
            $departmentModel
                ->groupStart()
                ->where(
                    'english_listening_requirement',
                    '--'
                )
                ->orWhere(
                    'english_listening_requirement',
                    ''
                )
                ->orWhere(
                    'english_listening_requirement IS NULL',
                    null,
                    false
                )
                ->groupEnd();
        }
        $perPage = 30;
        $departments = $departmentModel
            ->orderBy(
                'university_code',
                'ASC'
            )
            ->orderBy(
                'department_code',
                'ASC'
            )
            ->paginate(
                $perPage,
                'application_department'
            );
        $pager = $departmentModel->pager;
        // 取得目前已加入候選清單的校系
        $cartModel = new ApplicationCartModel();
        $cartItems = $cartModel
            ->select('department_id')
            ->where(
                'application_id',
                $application['id']
            )
            ->findAll();
        $cartDepartmentIds = array_map(
            'intval',
            array_column(
                $cartItems,
                'department_id'
            )
        );
        $conditionTexts = [];
        foreach (
            $requirementFields as $key => $info
        ) {
            $status =
                $requirementsStatus[$key]
                ?? 'any';
            if ($status === 'required') {
                $conditionTexts[] =
                    $info['name'] . '參採';
            } elseif (
                $status === 'not_required'
            ) {
                $conditionTexts[] =
                    $info['name'] . '不參採';
            }
        }
        if (
            $englishListening === 'required'
        ) {
            $conditionTexts[] =
                '英聽參採';
        } elseif (
            $englishListening === 'not_required'
        ) {
            $conditionTexts[] =
                '英聽不參採';
        }
        return view(
            'Apply/application_departments',
            [
                'application' =>
                    $application,
                'departments' =>
                    $departments,
                'pager' =>
                    $pager,
                'universities' =>
                    $universities,
                'keyword' =>
                    $keyword,
                'university' =>
                    $university,
                'englishListening' =>
                    $englishListening,
                'requirementsStatus' =>
                    $requirementsStatus,
                'conditionTexts' =>
                    $conditionTexts,
                'cartDepartmentIds' =>
                    $cartDepartmentIds,
            ]
        );
    }
}