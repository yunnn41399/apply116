<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class DepartmentsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'university_name' => '國立臺灣大學',
                'department_name' => '資訊工程學系',
                'public_private' => '國立',
                'location' => '臺北市',
                'college_group' => '資訊學群',
                'admission_quota' => 50,
                'description' => '資訊工程相關課程與研究。',
            ],
            [
                'university_name' => '國立政治大學',
                'department_name' => '資訊管理學系',
                'public_private' => '國立',
                'location' => '臺北市',
                'college_group' => '資訊學群',
                'admission_quota' => 45,
                'description' => '資訊管理與資訊科技相關課程。',
            ],
            [
                'university_name' => '國立中央大學',
                'department_name' => '資訊工程學系',
                'public_private' => '國立',
                'location' => '桃園市',
                'college_group' => '資訊學群',
                'admission_quota' => 55,
                'description' => '資訊工程與相關科技研究。',
            ],
            [
                'university_name' => '國立清華大學',
                'department_name' => '電機工程學系',
                'public_private' => '國立',
                'location' => '新竹市',
                'college_group' => '工程學群',
                'admission_quota' => 60,
                'description' => '電機工程相關課程與研究。',
            ],
            [
                'university_name' => '國立成功大學',
                'department_name' => '資訊工程學系',
                'public_private' => '國立',
                'location' => '臺南市',
                'college_group' => '資訊學群',
                'admission_quota' => 65,
                'description' => '資訊工程相關課程與研究。',
            ],
            [
                'university_name' => '國立成功大學',
                'department_name' => '企業管理學系',
                'public_private' => '國立',
                'location' => '臺南市',
                'college_group' => '商管學群',
                'admission_quota' => 50,
                'description' => '企業管理與商業相關課程。',
            ],
            [
                'university_name' => '國立中興大學',
                'department_name' => '資訊管理學系',
                'public_private' => '國立',
                'location' => '臺中市',
                'college_group' => '資訊學群',
                'admission_quota' => 45,
                'description' => '資訊管理與資訊科技相關課程。',
            ],
            [
                'university_name' => '東海大學',
                'department_name' => '資訊工程學系',
                'public_private' => '私立',
                'location' => '臺中市',
                'college_group' => '資訊學群',
                'admission_quota' => 40,
                'description' => '資訊工程與軟體相關課程。',
            ],
        ];
        $this->db->table('departments')->insertBatch($data);
    }
}