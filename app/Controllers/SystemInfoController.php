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
                    '查詢目前的篩選結果及相關資訊。',
                'emptyMessage' =>
                    '目前尚無篩選結果資料。',
                'emptyHint' =>
                    '相關功能開放後，將於此顯示您的篩選結果。',
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
                    '辦理審查資料相關文件的上傳作業。',
                'emptyMessage' =>
                    '目前尚無審查資料上傳資訊。',
                'emptyHint' =>
                    '相關功能開放後，將於此提供審查資料上傳作業。',
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
                    '目前尚無志願登記資料。',
                'emptyHint' =>
                    '相關功能開放後，將於此提供網路登記志願功能。',
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
                    '查詢您的分發結果及相關資訊。',
                'emptyMessage' =>
                    '目前尚無分發結果資料。',
                'emptyHint' =>
                    '分發結果公布後，將於此顯示相關結果。',
            ]
        );
    }
}