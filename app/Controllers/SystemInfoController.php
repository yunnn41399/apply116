<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\HomepagePageService;

class SystemInfoController extends BaseController
{
    protected $homepagePageService;

    public function __construct()
    {
        $this->homepagePageService = new HomepagePageService();
    }

    public function filterResult()
    {
        // 傳入資料庫中對應該頁面的 page_key (例如 'filter_result')
        $pageState = $this->homepagePageService->getPageState('filter_result');

        return view('Home/system_info', [
            'title'       => '篩選結果查詢',
            'icon'        => 'bi bi-funnel',
            'description' => '查詢第一階段篩選結果及相關資訊。',
            'pageState'   => $pageState, // 包含 status, message, visible ...
        ]);
    }

    public function reviewUpload()
    {
        $pageState = $this->homepagePageService->getPageState('review_upload');

        return view('Home/system_info', [
            'title'       => '審查資料上傳系統',
            'icon'        => 'bi bi-cloud-upload',
            'description' => '辦理第二階段指定項目甄試審查資料上傳作業。',
            'pageState'   => $pageState,
        ]);
    }

    public function onlineSelection()
    {
        $pageState = $this->homepagePageService->getPageState('online_selection');

        return view('Home/system_info', [
            'title'       => '網路登記志願',
            'icon'        => 'bi bi-list-check',
            'description' => '辦理網路登記志願相關作業。',
            'pageState'   => $pageState,
        ]);
    }

    public function distributionResult()
    {
        $pageState = $this->homepagePageService->getPageState('distribution_result');

        return view('Home/system_info', [
            'title'       => '分發結果查詢',
            'icon'        => 'bi bi-bar-chart',
            'description' => '查詢統一分發結果及相關資訊。',
            'pageState'   => $pageState,
        ]);
    }
}