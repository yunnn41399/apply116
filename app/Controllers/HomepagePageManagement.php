<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HomepagePageModel;
use App\Models\HomepagePageGroupModel;
use App\Models\HomepageMarqueeModel;
use App\Services\AdminLogService;

class HomepagePageManagement extends BaseController
{
    protected $homepagePageModel;
    protected $homepagePageGroupModel;
    protected $homepageMarqueeModel;

    public function __construct()
    {
        $this->homepagePageModel = new HomepagePageModel();
        $this->homepagePageGroupModel = new HomepagePageGroupModel();
        $this->homepageMarqueeModel = new HomepageMarqueeModel();
    }

    // 首頁頁面設定列表
    public function index()
    {
        $pages = $this->homepagePageModel
            ->orderBy('location', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();

        $groups = $this->homepagePageGroupModel
            ->orderBy('location', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();

        $marquee = $this->homepageMarqueeModel
            ->first();

        return view('admin/homepage_pages/index', [
            'pages'   => $pages,
            'groups'  => $groups,
            'marquee' => $marquee,
        ]);
    }

    // 編輯首頁頁面設定
    public function edit($id)
    {
        $page = $this->homepagePageModel->find($id);

        if (!$page) {
            return redirect()
                ->to('/admin/homepage-pages')
                ->with('error', '找不到指定的首頁頁面。');
        }

        return view('admin/homepage_pages/edit', [
            'page' => $page,
        ]);
    }

    // 更新首頁頁面設定
    public function update($id)
    {
        $page = $this->homepagePageModel->find($id);

        if (!$page) {
            return redirect()
                ->to('/admin/homepage-pages')
                ->with('error', '找不到指定的首頁頁面。');
        }

        $isEnabled = $this->request->getPost('is_enabled') ? 1 : 0;

        $displayMode = $this->request->getPost('display_mode');

        $allowedDisplayModes = [
            'always',
            'message_when_closed',
            'hide_when_closed',
        ];

        if (!in_array($displayMode, $allowedDisplayModes, true)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '無效的顯示方式。');
        }

        $startAt = trim($this->request->getPost('start_at') ?? '');
        $endAt   = trim($this->request->getPost('end_at') ?? '');

        $startAt = $startAt !== '' ? $startAt : null;
        $endAt   = $endAt !== '' ? $endAt : null;

        if ($startAt !== null && $endAt !== null) {
            if (strtotime($startAt) === false || strtotime($endAt) === false) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', '開放時間格式不正確。');
            }

            if (strtotime($startAt) >= strtotime($endAt)) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', '開放開始時間必須早於結束時間。');
            }
        }

        $beforeMessage = trim(
            $this->request->getPost('before_message') ?? ''
        );

        $afterMessage = trim(
            $this->request->getPost('after_message') ?? ''
        );

        $data = [
            'is_enabled'     => $isEnabled,
            'display_mode'   => $displayMode,
            'start_at'       => $startAt,
            'end_at'         => $endAt,
            'before_message' => $beforeMessage !== '' ? $beforeMessage : null,
            'after_message'  => $afterMessage !== '' ? $afterMessage : null,
        ];

        $this->homepagePageModel->update($id, $data);

        return redirect()
            ->to('/admin/homepage-pages')
            ->with('success', '首頁頁面設定已更新。');
    }

    // 編輯首頁跑馬燈
    public function marqueeEdit($id)
    {
        $marquee = $this->homepageMarqueeModel->find($id);

        if (!$marquee) {
            return redirect()
                ->to('/admin/homepage-pages')
                ->with('error', '找不到指定的首頁跑馬燈。');
        }

        return view('admin/homepage_pages/marquee_edit', [
            'marquee' => $marquee,
        ]);
    }

    // 更新首頁跑馬燈
    public function marqueeUpdate($id)
    {
        $marquee = $this->homepageMarqueeModel->find($id);

        if (!$marquee) {
            return redirect()
                ->to('/admin/homepage-pages')
                ->with('error', '找不到指定的首頁跑馬燈。');
        }

        $content = trim(
            $this->request->getPost('content') ?? ''
        );

        if ($content === '') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '跑馬燈內容不可為空。');
        }

        $isEnabled = $this->request->getPost('is_enabled') ? 1 : 0;

        $startAt = trim(
            $this->request->getPost('start_at') ?? ''
        );

        $endAt = trim(
            $this->request->getPost('end_at') ?? ''
        );

        $startAt = $startAt !== '' ? $startAt : null;
        $endAt   = $endAt !== '' ? $endAt : null;

        if ($startAt !== null && strtotime($startAt) === false) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '開始時間格式不正確。');
        }

        if ($endAt !== null && strtotime($endAt) === false) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '結束時間格式不正確。');
        }

        if (
            $startAt !== null &&
            $endAt !== null &&
            strtotime($startAt) >= strtotime($endAt)
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '開始時間必須早於結束時間。');
        }

        $this->homepageMarqueeModel->update($id, [
            'content'    => $content,
            'is_enabled' => $isEnabled,
            'start_at'   => $startAt,
            'end_at'     => $endAt,
        ]);

        return redirect()
            ->to('/admin/homepage-pages')
            ->with('success', '首頁跑馬燈設定已更新。');
    }
}