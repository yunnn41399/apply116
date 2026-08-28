<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HomepageMarqueeSeeder extends Seeder
{
    public function run()
    {
        $table = $this->db->table('homepage_marquees');

        // 清除既有資料
        $table->truncate();

        // SQLite 重設自增 ID
        if ($this->db->DBDriver === 'SQLite3') {
            $this->db->query(
                "DELETE FROM sqlite_sequence WHERE name = 'homepage_marquees'"
            );
        }

        $data = [
            'content' => '請留意！甄選委員會發送之簡訊，不會要求考生回撥及告知個人資料。聯絡專線：05-2721799。',
            'is_enabled' => 1,
            'start_at' => null,
            'end_at' => null,
        ];

        $table->insert($data);
    }
}