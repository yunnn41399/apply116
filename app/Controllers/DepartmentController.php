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
                ->with(
                    'error',
                    '請先登入後再進入網路報名系統。'
                );
        }
        // 取得搜尋條件
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
        // Model
        $departmentModel = new DepartmentModel();
        // 取得所有學校
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
        // 關鍵字搜尋
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
        // 學校篩選
        if ($university !== '') {
            $departmentModel->where(
                'university_code',
                $university
            );
        }
        // 檢定科目設定
        $requirementFields = [
            'chinese' => [
                'field' => 'chinese_requirement',
                'name' => '國文'
            ],
            'english' => [
                'field' => 'english_requirement',
                'name' => '英文'
            ],
            'math_a' => [
                'field' => 'math_a_requirement',
                'name' => '數學A'
            ],
            'math_b' => [
                'field' => 'math_b_requirement',
                'name' => '數學B'
            ],
            'social' => [
                'field' => 'social_requirement',
                'name' => '社會'
            ],
            'natural' => [
                'field' => 'natural_requirement',
                'name' => '自然'
            ],
        ];
        // 套用各科檢定條件
        foreach (
            $requirementFields as $key => $info
        ) {
            $status = $requirementsStatus[$key]
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
        // 英聽篩選
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
        // 分頁設定
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
                'department'
            );
        $pager = $departmentModel->pager;
        // 建立查詢條件提示
        $conditionTexts = [];
        foreach (
            $requirementFields as $key => $info
        ) {
            $status = $requirementsStatus[$key]
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
        // 英聽條件
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
        // 傳送資料給 View
        return view(
            'Apply/department',
            [
                'departments' =>
                    $departments,
                'pager' =>
                    $pager,
                'keyword' =>
                    $keyword,
                'university' =>
                    $university,
                'universities' =>
                    $universities,
                'englishListening' =>
                    $englishListening,
                'requirementsStatus' =>
                    $requirementsStatus,
                'conditionTexts' =>
                    $conditionTexts,
            ]
        );
    }
}