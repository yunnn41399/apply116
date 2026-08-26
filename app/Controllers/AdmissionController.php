<?php
namespace App\Controllers;
use App\Controllers\BaseController;
class AdmissionController extends BaseController
{
    public function schedule()
    {
        return view(
            'Home/admission_info',
            [
                'title' => '重要日程',
                'icon' => 'bi bi-calendar-event',
                'description' =>
                    '提供本年度招生相關重要日程及時程說明。',
            ]
        );
    }
    public function brochure()
    {
        return view(
            'Home/admission_info',
            [
                'title' => '網路購買簡章',
                'icon' => 'bi bi-journal-text',
                'description' =>
                    '提供招生簡章購買方式及相關注意事項。',
            ]
        );
    }
    public function regulations()
    {
        return view(
            'Home/admission_info',
            [
                'title' => '招生相關規定',
                'icon' => 'bi bi-file-earmark-text',
                'description' =>
                    '提供本年度招生相關規定及注意事項。',
            ]
        );
    }
    public function statistics()
    {
        return view(
            'Home/admission_info',
            [
                'title' => '招生統計資料',
                'icon' => 'bi bi-bar-chart',
                'description' =>
                    '提供各大學校院相關招生統計資料及說明。',
            ]
        );
    }
}