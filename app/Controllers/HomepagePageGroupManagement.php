<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HomepagePageGroupModel;
use App\Services\AdminLogService;

class HomepagePageGroupManagement extends BaseController
{
    protected $homepagePageGroupModel;

    public function __construct()
    {
        $this->homepagePageGroupModel = new HomepagePageGroupModel();
    }

    // 首頁群組設定列表
    public function index()
    {
        $groups = $this->homepagePageGroupModel
            ->orderBy('location', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();

        return view('admin/homepage_page_groups/index', [
            'groups' => $groups,
        ]);
    }

    // 編輯首頁群組設定
    public function edit($id)
    {
        $group = $this->homepagePageGroupModel->find($id);

        if (!$group) {
            return redirect()
                ->to('/admin/homepage-pages')
                ->with('error', '找不到指定的首頁群組。');
        }

        return view('admin/homepage_page_groups/edit', [
            'group' => $group,
        ]);
    }

    // 更新首頁群組設定
    public function update($id)
    {
        $group = $this->homepagePageGroupModel->find($id);

        if (!$group) {
            return redirect()
                ->to('/admin/homepage-pages')
                ->with('error', '找不到指定的首頁群組。');
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

        $startAt = trim(
            $this->request->getPost('start_at') ?? ''
        );

        $endAt = trim(
            $this->request->getPost('end_at') ?? ''
        );

        $startAt = $startAt !== '' ? $startAt : null;
        $endAt   = $endAt !== '' ? $endAt : null;

        if ($startAt !== null && $endAt !== null) {

            if (
                strtotime($startAt) === false ||
                strtotime($endAt) === false
            ) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', '開放時間格式不正確。');
            }

            if (strtotime($startAt) >= strtotime($endAt)) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        '開放開始時間必須早於結束時間。'
                    );
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
            'before_message' => $beforeMessage !== ''
                ? $beforeMessage
                : null,
            'after_message'  => $afterMessage !== ''
                ? $afterMessage
                : null,
        ];

        $this->homepagePageGroupModel->update($id, $data);

        return redirect()
            ->to('/admin/homepage-pages')
            ->with('success', '首頁群組設定已更新。');
    }
}