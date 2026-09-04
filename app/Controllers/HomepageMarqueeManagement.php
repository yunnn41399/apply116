<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HomepageMarqueeModel;

class HomepageMarqueeManagement extends BaseController
{
    protected $homepageMarqueeModel;

    public function __construct()
    {
        $this->homepageMarqueeModel = new HomepageMarqueeModel();
    }

    // 跑馬燈列表
    public function index()
    {
        $marquees = $this->homepageMarqueeModel
            ->orderBy('display_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();

        return view('admin/homepage_marquees/index', [
            'marquees' => $marquees,
        ]);
    }

    // 新增跑馬燈頁面
    public function create()
    {
        return view('admin/homepage_marquees/create');
    }

    // 儲存新增跑馬燈
    public function store()
    {
        $content = trim(
            $this->request->getPost('content') ?? ''
        );

        $url = trim(
            $this->request->getPost('url') ?? ''
        );

        $target = $this->request->getPost('target') ?? '_self';

        $isEnabled = $this->request->getPost('is_enabled') ? 1 : 0;

        $displayOrder = (int) (
            $this->request->getPost('display_order') ?? 0
        );

        $startAt = trim(
            $this->request->getPost('start_at') ?? ''
        );

        $endAt = trim(
            $this->request->getPost('end_at') ?? ''
        );

        $startAt = $startAt !== '' ? $startAt : null;
        $endAt   = $endAt !== '' ? $endAt : null;

        // 內容不能為空
        if ($content === '') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '跑馬燈內容不能為空。');
        }

        // 檢查開啟方式
        if (!in_array($target, ['_self', '_blank'], true)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '開啟方式設定不正確。');
        }

        // 檢查時間
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

        $data = [
            'content'       => $content,
            'url'           => $url !== '' ? $url : null,
            'target'        => $target,
            'is_enabled'    => $isEnabled,
            'display_order' => $displayOrder,
            'start_at'      => $startAt,
            'end_at'        => $endAt,
        ];

        if (!$this->homepageMarqueeModel->insert($data)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '跑馬燈新增失敗。');
        }

        return redirect()
            ->to('/admin/homepage-marquees')
            ->with('success', '跑馬燈新增成功。');
    }

    // 編輯跑馬燈頁面
    public function edit($id)
    {
        $marquee = $this->homepageMarqueeModel->find($id);

        if (!$marquee) {
            return redirect()
                ->to('/admin/homepage-marquees')
                ->with('error', '找不到指定的跑馬燈。');
        }

        return view('admin/homepage_marquees/edit', [
            'marquee' => $marquee,
        ]);
    }

    // 更新跑馬燈
    public function update($id)
    {
        $marquee = $this->homepageMarqueeModel->find($id);

        if (!$marquee) {
            return redirect()
                ->to('/admin/homepage-marquees')
                ->with('error', '找不到指定的跑馬燈。');
        }

        $content = trim(
            $this->request->getPost('content') ?? ''
        );

        $url = trim(
            $this->request->getPost('url') ?? ''
        );

        $target = $this->request->getPost('target') ?? '_self';

        $isEnabled = $this->request->getPost('is_enabled') ? 1 : 0;

        $displayOrder = (int) (
            $this->request->getPost('display_order') ?? 0
        );

        $startAt = trim(
            $this->request->getPost('start_at') ?? ''
        );

        $endAt = trim(
            $this->request->getPost('end_at') ?? ''
        );

        $startAt = $startAt !== '' ? $startAt : null;
        $endAt   = $endAt !== '' ? $endAt : null;

        // 內容不能為空
        if ($content === '') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '跑馬燈內容不能為空。');
        }

        // 檢查開啟方式
        if (!in_array($target, ['_self', '_blank'], true)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '開啟方式設定不正確。');
        }

        // 檢查時間
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

        $data = [
            'content'       => $content,
            'url'           => $url !== '' ? $url : null,
            'target'        => $target,
            'is_enabled'    => $isEnabled,
            'display_order' => $displayOrder,
            'start_at'      => $startAt,
            'end_at'        => $endAt,
        ];

        if (!$this->homepageMarqueeModel->update($id, $data)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '跑馬燈更新失敗。');
        }

        return redirect()
            ->to('/admin/homepage-marquees')
            ->with('success', '跑馬燈設定已更新。');
    }

    // 刪除跑馬燈
    public function delete($id)
    {
        $marquee = $this->homepageMarqueeModel->find($id);

        if (!$marquee) {
            return redirect()
                ->to('/admin/homepage-marquees')
                ->with('error', '找不到指定的跑馬燈。');
        }

        if (!$this->homepageMarqueeModel->delete($id)) {
            return redirect()
                ->to('/admin/homepage-marquees')
                ->with('error', '跑馬燈刪除失敗。');
        }

        return redirect()
            ->to('/admin/homepage-marquees')
            ->with('success', '跑馬燈已刪除。');
    }
}