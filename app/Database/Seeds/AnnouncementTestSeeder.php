<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AnnouncementTestSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title'         => '系統公告測試',
                'category'      => '系統公告',
                'type'          => '純文字',
                'content'       => '這是一則系統公告測試資料。',
                'attachment'    => null,
                'external_url'  => null,
                'publish_date'  => '2026-08-14 10:00:00',
                'status'        => 'published',
                'created_at'    => '2026-08-14 10:00:00',
                'updated_at'    => '2026-08-14 10:00:00',
            ],
            [
                'title'         => '招生資訊測試',
                'category'      => '甄選甄試',
                'type'          => '超連結',
                'content'       => null,
                'attachment'    => null,
                'external_url'  => 'https://www.google.com/',
                'publish_date'  => '2026-08-14 11:00:00',
                'status'        => 'published',
                'created_at'    => '2026-08-14 11:00:00',
                'updated_at'    => '2026-08-14 11:00:00',
            ],
            [
                'title'         => 'PDF公告測試',
                'category'      => '系統公告',
                'type'          => 'PDF文件',
                'content'       => null,
                'attachment'    => 'uploads/announcements/test.pdf',
                'external_url'  => null,
                'publish_date'  => '2026-08-14 13:00:00',
                'status'        => 'published',
                'created_at'    => '2026-08-14 13:00:00',
                'updated_at'    => '2026-08-14 13:00:00',
            ],
            [
                'title'         => '尚未發布的公告',
                'category'      => '系統公告',
                'type'          => '純文字',
                'content'       => '這是一則草稿公告。',
                'attachment'    => null,
                'external_url'  => null,
                'publish_date'  => null,
                'status'        => 'draft',
                'created_at'    => '2026-08-14 12:00:00',
                'updated_at'    => '2026-08-14 12:00:00',
            ],
        ];

        $this->db->table('announcements')->insertBatch($data);
    }
}