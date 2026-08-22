<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ApplicationModel;
use App\Models\ApplicationDepartmentModel;
use App\Models\CandidateModel;
class ApplicationStatusController extends BaseController
{
    // ========================================
    // 查詢報名狀態
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
            return view(
                'Apply/application_status',
                [
                    'candidate' =>
                        $candidate,
                    'application' =>
                        null,
                    'formalDepartments' =>
                        [],
                ]
            );
        }
        $formalDepartments = [];
        $confirmedAt = null;
        if (
            ($application['status'] ?? 'draft')
            === 'confirmed'
        ) {
            $applicationDepartmentModel =
                new ApplicationDepartmentModel();
            $formalDepartments =
                $applicationDepartmentModel
                    ->select(
                        'application_departments.*, '
                        . 'departments.department_code, '
                        . 'departments.university_name, '
                        . 'departments.department_name'
                    )
                    ->join(
                        'departments',
                        'departments.id = application_departments.department_id'
                    )
                    ->where(
                        'application_departments.application_id',
                        $application['id']
                    )
                    ->orderBy(
                        'application_departments.id',
                        'ASC'
                    )
                    ->findAll();
            if (!empty($formalDepartments)) {
                $confirmedAt =
                    $formalDepartments[0][
                        'confirmed_at'
                    ];
            }
        }
        return view(
            'Apply/application_status',
            [
                'candidate' =>
                    $candidate,
                'application' =>
                    $application,
                'formalDepartments' =>
                    $formalDepartments,
                'confirmedAt' =>
                    $confirmedAt,
            ]
        );
    }
}