<?php
namespace App\Commands;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\DepartmentModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
class ImportDepartments extends BaseCommand
{
    protected $group = 'Departments';
    protected $name = 'import:departments';
    protected $description = '從 Excel 匯入校系資料到 departments 資料表';
    public function run(array $params)
    {
        CLI::write('開始匯入校系資料...', 'yellow');
        // Excel 檔案位置
        $filePath = ROOTPATH . '115申請入學校系資料.xlsx';
        // 檢查 Excel 是否存在
        if (!file_exists($filePath)) {
            CLI::error('找不到 Excel 檔案：');
            CLI::error($filePath);
            return;
        }
        try {
            // 讀取 Excel
            $spreadsheet = IOFactory::load($filePath);
            // 取得第一個工作表
            $worksheet = $spreadsheet->getActiveSheet();
            // 取得所有資料
            $rows = $worksheet->toArray();
            CLI::write(
                '成功讀取 Excel，共 ' . count($rows) . ' 列。',
                'green'
            );
        } catch (\Throwable $e) {
            CLI::error('讀取 Excel 失敗：');
            CLI::error($e->getMessage());
            return;
        }
        //建立 Department Model
        $departmentModel = new DepartmentModel();
        $data = [];
        foreach ($rows as $index => $row) {
            // 跳過第一列標題
            if ($index === 0) {
                continue;
            }
            if (
                empty(array_filter($row, function ($value) {
                    return $value !== null && $value !== '';
                }))
            ) {
                continue;
            }
            $data[] = [
                'university_code' =>
                    trim((string) $row[0]),
                'university_name' =>
                    trim((string) $row[1]),
                'department_code' =>
                    trim((string) $row[2]),
                'department_name' =>
                    trim((string) $row[3]),
                'admission_quota' =>
                    (int) $row[4],
                'chinese_requirement' =>
                    trim((string) $row[5]),
                'english_requirement' =>
                    trim((string) $row[6]),
                'math_a_requirement' =>
                    trim((string) $row[7]),
                'math_b_requirement' =>
                    trim((string) $row[8]),
                'social_requirement' =>
                    trim((string) $row[9]),
                'natural_requirement' =>
                    trim((string) $row[10]),
                'english_listening_requirement' =>
                    trim((string) $row[11]),
            ];
        }
        //檢查資料筆數
        CLI::write(
            '準備匯入 ' . count($data) . ' 筆資料...',
            'yellow'
        );
        //批次寫入資料庫
        if (!empty($data)) {
            try {
                $departmentModel->insertBatch($data);
            } catch (\Throwable $e) {
                CLI::error('資料匯入失敗：');
                CLI::error($e->getMessage());
                return;
            }
        }
        CLI::write(
            '校系資料匯入完成！',
            'green'
        );
        CLI::write(
            '成功匯入：' . count($data) . ' 筆',
            'green'
        );
    }
}