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

    // 前台公告列表
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

    // 後臺公告列表
    public function adminIndex()
    {
        $announcements = $this->announcementModel
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('admin/announcement/index', [
            'announcements' => $announcements
        ]);
    }

    // 公告詳細內容
    public function detail($id)
    {
        $announcement = $this->announcementModel->find($id);

        if (!$announcement) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                '找不到此公告'
            );
        }

        // 超連結公告：直接跳轉到外部網址
        if ($announcement['type'] === '超連結') {
            return redirect()->to($announcement['external_url']);
        }

        // PDF 公告：開啟 PDF
        if ($announcement['type'] === 'PDF文件') {
            return redirect()->to(
                base_url($announcement['attachment'])
            );
        }

        // 純文字公告：顯示詳細內容
        return view('announcement/detail', [
            'announcement' => $announcement
        ]);
    }
}