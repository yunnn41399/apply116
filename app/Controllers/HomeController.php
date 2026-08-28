<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnnouncementModel;
use App\Services\HomepagePageService;
use App\Services\HomepageMarqueeService;

class HomeController extends BaseController
{
    protected $announcementModel;
    protected $homepagePageService;
    protected $homepageMarqueeService;

    public function __construct()
    {
        $this->announcementModel = new AnnouncementModel();
        $this->homepagePageService = new HomepagePageService();
        $this->homepageMarqueeService = new HomepageMarqueeService();
    }

    public function index()
    {
        $perPage = 10; // 每頁顯示筆數

        // 取得發布狀態的公告並進行分頁
        $announcements = $this->announcementModel
            ->where('status', 'published')
            ->orderBy('publish_date', 'DESC')
            ->paginate($perPage);

        // 取得 Navbar 頁面設定
        $navbarPages = [];
        $pages = $this->homepagePageService->getPagesByLocation('navbar');

        foreach ($pages as $page) {
            $state = $this->homepagePageService->getPageState($page['page_key']);
            if ($state !== null) {
                $navbarPages[] = $state;
            }
        }

        // 取得首頁跑馬燈
        $marquee = $this->homepageMarqueeService->getVisibleMarquee();

        return view('Home/index', [
            'announcements' => $announcements,
            'pager'         => $this->announcementModel->pager,
            'navbarPages'   => $navbarPages,
            'marquee'       => $marquee,
        ]);
    }
}