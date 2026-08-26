<?php
namespace App\Controllers;
use App\Controllers\BaseController;
class SystemInfoController extends BaseController
{
    public function filterResult()
    {
        return view(
            'Home/system_info',
            [
                'title' => '篩選結果查詢',
                'icon' => 'bi bi-funnel',
                'description' =>
                    '查詢第一階段篩選結果及相關資訊。',
                'emptyMessage' =>
                    '系統尚未開放',
                'emptyHint' =>
                    '目前尚無資料。',
            ]
        );
    }
    public function reviewUpload()
    {
        return view(
            'Home/system_info',
            [
                'title' => '審查資料上傳系統',
                'icon' => 'bi bi-cloud-upload',
                'description' =>
                    '辦理第二階段指定項目甄試審查資料上傳作業。',
                'emptyMessage' =>
                    '系統尚未開放',
                'emptyHint' =>
                    '目前尚無資料。',
            ]
        );
    }
    public function onlineSelection()
    {
        return view(
            'Home/system_info',
            [
                'title' => '網路登記志願',
                'icon' => 'bi bi-list-check',
                'description' =>
                    '辦理網路登記志願相關作業。',
                'emptyMessage' =>
                    '系統尚未開放',
                'emptyHint' =>
                    '目前尚無資料。',
            ]
        );
    }
    public function distributionResult()
    {
        return view(
            'Home/system_info',
            [
                'title' => '分發結果查詢',
                'icon' => 'bi bi-bar-chart',
                'description' =>
                    '查詢統一分發結果及相關資訊。',
                'emptyMessage' =>
                    '系統尚未開放',
                'emptyHint' =>
                    '目前尚無資料。',
            ]
        );
    }
}