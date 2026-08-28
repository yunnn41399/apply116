<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HomepagePageSeeder extends Seeder
{
    public function run()
    {
        /*
         * ========================================
         * homepage_page_groups
         * ========================================
         */

        $groupTable = $this->db->table('homepage_page_groups');

        $groupTable->truncate();

        // SQLite 重設自增 ID
        if ($this->db->DBDriver === 'SQLite3') {
            $this->db->query(
                "DELETE FROM sqlite_sequence WHERE name = 'homepage_page_groups'"
            );
        }

        $groups = [
            [
                'group_key'      => 'admission',
                'title'          => '招生資訊',
                'location'       => 'sidebar',
                'is_enabled'     => 1,
                'display_mode'   => 'always',
                'start_at'       => null,
                'end_at'         => null,
                'before_message' => null,
                'after_message'  => null,
            ],
            [
                'group_key'      => 'related',
                'title'          => '相關網站',
                'location'       => 'sidebar',
                'is_enabled'     => 1,
                'display_mode'   => 'always',
                'start_at'       => null,
                'end_at'         => null,
                'before_message' => null,
                'after_message'  => null,
            ],
        ];

        $groupTable->insertBatch($groups);


        /*
         * ========================================
         * homepage_pages
         * ========================================
         */

        $table = $this->db->table('homepage_pages');

        $table->truncate();

        // SQLite 重設自增 ID
        if ($this->db->DBDriver === 'SQLite3') {
            $this->db->query(
                "DELETE FROM sqlite_sequence WHERE name = 'homepage_pages'"
            );
        }

        $data = [
            [
                'page_key'       => 'department',
                'title'          => '校系分則查詢',
                'route'          => 'department',
                'location'       => 'navbar',
                'is_enabled'     => 1,
                'display_mode'   => 'always',
                'start_at'       => null,
                'end_at'         => null,
                'before_message' => null,
                'after_message'  => null,
            ],
            [
                'page_key'       => 'application_info',
                'title'          => '網路報名系統',
                'route'          => 'application-info',
                'location'       => 'navbar',
                'is_enabled'     => 1,
                'display_mode'   => 'message_when_closed',
                'start_at'       => null,
                'end_at'         => null,
                'before_message' => '系統尚未開放，目前尚無資料。',
                'after_message'  => '系統開放期限已過。',
            ],
            [
                'page_key'       => 'filter_result',
                'title'          => '篩選結果查詢',
                'route'          => 'filter-result',
                'location'       => 'navbar',
                'is_enabled'     => 1,
                'display_mode'   => 'message_when_closed',
                'start_at'       => null,
                'end_at'         => null,
                'before_message' => '系統尚未開放，目前尚無資料。',
                'after_message'  => '系統開放期限已過。',
            ],
            [
                'page_key'       => 'review_upload',
                'title'          => '審查資料上傳系統',
                'route'          => 'review-upload',
                'location'       => 'navbar',
                'is_enabled'     => 1,
                'display_mode'   => 'message_when_closed',
                'start_at'       => null,
                'end_at'         => null,
                'before_message' => '系統尚未開放，目前尚無資料。',
                'after_message'  => '系統開放期限已過。',
            ],
            [
                'page_key'       => 'online_selection',
                'title'          => '網路登記志願',
                'route'          => 'online-selection',
                'location'       => 'navbar',
                'is_enabled'     => 1,
                'display_mode'   => 'message_when_closed',
                'start_at'       => null,
                'end_at'         => null,
                'before_message' => '系統尚未開放，目前尚無資料。',
                'after_message'  => '系統開放期限已過。',
            ],
            [
                'page_key'       => 'distribution_result',
                'title'          => '分發結果查詢',
                'route'          => 'distribution-result',
                'location'       => 'navbar',
                'is_enabled'     => 1,
                'display_mode'   => 'message_when_closed',
                'start_at'       => null,
                'end_at'         => null,
                'before_message' => '系統尚未開放，目前尚無資料。',
                'after_message'  => '系統開放期限已過。',
            ],
            [
                'page_key'       => 'register',
                'title'          => '考生註冊',
                'route'          => 'register',
                'location'       => 'navbar',
                'is_enabled'     => 1,
                'display_mode'   => 'hide_when_closed',
                'start_at'       => null,
                'end_at'         => null,
                'before_message' => null,
                'after_message'  => null,
            ],
            [
                'page_key'       => 'login',
                'title'          => '考生登入',
                'route'          => 'login',
                'location'       => 'navbar',
                'is_enabled'     => 1,
                'display_mode'   => 'always',
                'start_at'       => null,
                'end_at'         => null,
                'before_message' => null,
                'after_message'  => null,
            ],

            /*
             * 招生資訊
             */
            [
                'page_key'       => 'admission_schedule',
                'title'          => '重要日程',
                'route'          => 'admission/schedule',
                'location'       => 'sidebar',
                'is_enabled'     => 1,
                'display_mode'   => 'always',
                'start_at'       => null,
                'end_at'         => null,
                'before_message' => null,
                'after_message'  => null,
            ],
            [
                'page_key'       => 'admission_brochure',
                'title'          => '網路購買簡章',
                'route'          => 'admission/brochure',
                'location'       => 'sidebar',
                'is_enabled'     => 1,
                'display_mode'   => 'always',
                'start_at'       => null,
                'end_at'         => null,
                'before_message' => null,
                'after_message'  => null,
            ],
            [
                'page_key'       => 'admission_regulations',
                'title'          => '招生相關規定',
                'route'          => 'admission/regulations',
                'location'       => 'sidebar',
                'is_enabled'     => 1,
                'display_mode'   => 'always',
                'start_at'       => null,
                'end_at'         => null,
                'before_message' => null,
                'after_message'  => null,
            ],
            [
                'page_key'       => 'admission_statistics',
                'title'          => '招生統計資料',
                'route'          => 'admission/statistics',
                'location'       => 'sidebar',
                'is_enabled'     => 1,
                'display_mode'   => 'always',
                'start_at'       => null,
                'end_at'         => null,
                'before_message' => null,
                'after_message'  => null,
            ],

            /*
             * 相關網站
             */
            [
                'page_key'       => 'related_organizations',
                'title'          => '招生單位',
                'route'          => 'related/organizations',
                'location'       => 'sidebar',
                'is_enabled'     => 1,
                'display_mode'   => 'always',
                'start_at'       => null,
                'end_at'         => null,
                'before_message' => null,
                'after_message'  => null,
            ],
            [
                'page_key'       => 'related_exams',
                'title'          => '考試單位',
                'route'          => 'related/exams',
                'location'       => 'sidebar',
                'is_enabled'     => 1,
                'display_mode'   => 'always',
                'start_at'       => null,
                'end_at'         => null,
                'before_message' => null,
                'after_message'  => null,
            ],
            [
                'page_key'       => 'related_other',
                'title'          => '其他網站',
                'route'          => 'related/other',
                'location'       => 'sidebar',
                'is_enabled'     => 1,
                'display_mode'   => 'always',
                'start_at'       => null,
                'end_at'         => null,
                'before_message' => null,
                'after_message'  => null,
            ],

            /*
             * 聯絡資訊
             */
            [
                'page_key'       => 'contact',
                'title'          => '聯絡資訊',
                'route'          => 'contact',
                'location'       => 'sidebar',
                'is_enabled'     => 1,
                'display_mode'   => 'always',
                'start_at'       => null,
                'end_at'         => null,
                'before_message' => null,
                'after_message'  => null,
            ],
        ];

        $this->db
            ->table('homepage_pages')
            ->insertBatch($data);
    }
}