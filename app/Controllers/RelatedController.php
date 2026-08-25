<?php
namespace App\Controllers;
use App\Controllers\BaseController;
class RelatedController extends BaseController
{
    public function organizations()
    {
        return view(
            'Home/related_organizations',
            [
                'title' => '招生單位',
                'icon' => 'bi bi-building',
                'description' =>
                    '提供與招生、升學及人才招募相關之單位網站。',
            ]
        );
    }
    public function exams()
    {
        return view(
            'Home/related_exams',
            [
                'title' => '考試單位',
                'icon' => 'bi bi-pencil-square',
                'description' =>
                    '提供與大學及技專校院相關考試之單位網站。',
            ]
        );
    }
    public function other()
    {
        return view(
            'Home/related_other',
            [
                'title' => '其他網站',
                'icon' => 'bi bi-link-45deg',
                'description' =>
                    '提供升學、教育及大學選才相關網站。',
            ]
        );
    }
}