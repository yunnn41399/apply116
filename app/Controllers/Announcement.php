<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnnouncementModel;

class Announcement extends BaseController
{
    protected $announcementModel;

    public function __construct()
    {
        $this->announcementModel = new AnnouncementModel();
    }

    // 公告列表
    public function index()
    {
        $announcements = $this->announcementModel
            ->where('status', 'published')
            ->orderBy('publish_date', 'DESC')
            ->findAll();

        return view('announcement/index', [
            'announcements' => $announcements
        ]);
    }

    // 公告詳細內容
    public function detail($id)
    {
        $announcement = $this->announcementModel
            ->where('id', $id)
            ->where('status', 'published')
            ->first();

        if (!$announcement) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                '找不到此公告'
            );
        }

        // 超連結公告：直接跳轉外部網址
        if (
            $announcement['type'] === '超連結'
            && !empty($announcement['external_url'])
        ) {
            return redirect()->to($announcement['external_url']);
        }

        // PDF公告：開啟PDF檔案
        if (
            $announcement['type'] === 'PDF文件'
            && !empty($announcement['attachment'])
        ) {
            return redirect()->to(base_url($announcement['attachment']));
        }

        return view('announcement/detail', [
            'announcement' => $announcement
        ]);
    }
}