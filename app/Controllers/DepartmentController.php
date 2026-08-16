<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\DepartmentModel;
class DepartmentController extends BaseController
{
    public function index()
    {
        // ========================================
        // 1. 檢查是否已登入
        // ========================================
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')
                ->with(
                    'error',
                    '請先登入後再進入網路報名系統。'
                );
        }
        // ========================================
        // 2. 取得搜尋條件
        // ========================================
        // 關鍵字
        $keyword = trim(
            $this->request->getGet('keyword') ?? ''
        );
        // 學校
        $university = trim(
            $this->request->getGet('university') ?? ''
        );
        // 英聽
        $englishListening = trim(
            $this->request->getGet('english_listening') ?? ''
        );
        // 各科檢定條件
        $requirementsStatus =
            $this->request->getGet(
                'requirements_status'
            );
        // 確保一定是陣列
        if (!is_array($requirementsStatus)) {
            $requirementsStatus = [];
        }
        // ========================================
        // 3. 建立 Model
        // ========================================
        $departmentModel =
            new DepartmentModel();
        // ========================================
        // 4. 取得所有學校
        // ========================================
        $universities =
            (new DepartmentModel())
                ->select(
                    'university_code, university_name'
                )
                ->distinct()
                ->orderBy(
                    'university_code',
                    'ASC'
                )
                ->findAll();
        // ========================================
        // 5. 關鍵字搜尋
        // ========================================
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
        // ========================================
        // 6. 學校篩選
        // ========================================
        if ($university !== '') {
            $departmentModel
                ->where(
                    'university_code',
                    $university
                );
        }
        // ========================================
        // 7. 檢定科目設定
        // ========================================
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
        // ========================================
        // 8. 套用各科檢定條件
        // ========================================
        foreach (
            $requirementFields as $key => $info
        ) {
            // 沒有設定 → 不篩選
            $status =
                $requirementsStatus[$key]
                ?? 'any';
            if ($status === 'any') {
                continue;
            }
            $field = $info['field'];
            // ------------------------------------
            // 參採
            // ------------------------------------
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
            }
            // ------------------------------------
            // 不參採
            // ------------------------------------
            elseif (
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
        // ========================================
        // 9. 英聽篩選
        // ========================================
        if (
            $englishListening === 'required'
        ) {
            // 有英聽檢定要求
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
            // 無英聽檢定要求
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
        // ========================================
        // 10. 查詢資料
        // ========================================
        $departments =
            $departmentModel
                ->orderBy(
                    'university_code',
                    'ASC'
                )
                ->orderBy(
                    'department_code',
                    'ASC'
                )
                ->findAll();
        // ========================================
        // 11. 建立查詢條件提示
        // ========================================
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
        // 英聽條件也加入提示
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
        // ========================================
        // 12. 傳送資料給 View
        // ========================================
        return view(
            'Apply/department',
            [
                'departments' =>
                    $departments,
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