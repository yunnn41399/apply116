<?php

namespace App\Services;

use App\Models\HomepagePageModel;
use App\Models\HomepagePageGroupModel;

class HomepagePageService
{
    protected $homepagePageModel;
    protected $homepagePageGroupModel;

    public function __construct()
    {
        $this->homepagePageModel = new HomepagePageModel();
        $this->homepagePageGroupModel = new HomepagePageGroupModel();
    }

    /**
     * 取得指定頁面的設定
     */
    public function getPage(string $pageKey): ?array
    {
        return $this->homepagePageModel
            ->where('page_key', $pageKey)
            ->first();
    }

    /**
     * 取得指定群組的設定
     */
    public function getGroup(string $groupKey): ?array
    {
        return $this->homepagePageGroupModel
            ->where('group_key', $groupKey)
            ->first();
    }

    /**
     * 判斷頁面／群組目前是否處於開放期間
     *
     * 回傳：
     * - before：尚未開放
     * - open：目前開放
     * - after：已經截止
     */
    public function getStatus(array $page): string
    {
        // 沒有設定開始時間與結束時間
        // 視為沒有時間限制
        if (empty($page['start_at']) && empty($page['end_at'])) {
            return 'open';
        }

        $now = time();

        // 尚未到開始時間
        if (!empty($page['start_at'])) {
            $startAt = strtotime($page['start_at']);

            if ($startAt !== false && $now < $startAt) {
                return 'before';
            }
        }

        // 已超過結束時間
        if (!empty($page['end_at'])) {
            $endAt = strtotime($page['end_at']);

            if ($endAt !== false && $now >= $endAt) {
                return 'after';
            }
        }

        return 'open';
    }

    /**
     * 取得頁面的完整狀態
     */
    public function getPageState(string $pageKey): ?array
    {
        $page = $this->getPage($pageKey);

        if (!$page) {
            return null;
        }

        // 管理員停用頁面
        if ((int) $page['is_enabled'] !== 1) {
            return [
                'page'    => $page,
                'status'  => 'disabled',
                'visible' => false,
                'message' => null,
            ];
        }

        $status = $this->getStatus($page);

        $visible = true;
        $message = null;

        switch ($page['display_mode']) {

            case 'always':

                $visible = true;

                break;

            case 'message_when_closed':

                if ($status === 'before') {

                    $visible = true;
                    $message = $page['before_message'] ?? null;

                } elseif ($status === 'after') {

                    $visible = true;
                    $message = $page['after_message'] ?? null;

                } else {

                    $visible = true;

                }

                break;

            case 'hide_when_closed':

                if ($status === 'before' || $status === 'after') {
                    $visible = false;
                }

                break;

            default:

                $visible = true;

                break;
        }

        return [
            'page'    => $page,
            'status'  => $status,
            'visible' => $visible,
            'message' => $message,
        ];
    }

    /**
     * 取得群組的完整狀態
     */
    public function getGroupState(string $groupKey): ?array
    {
        $group = $this->getGroup($groupKey);

        if (!$group) {
            return null;
        }

        // 管理員停用群組
        if ((int) $group['is_enabled'] !== 1) {
            return [
                'group'   => $group,
                'status'  => 'disabled',
                'visible' => false,
                'message' => null,
            ];
        }

        $status = $this->getStatus($group);

        $visible = true;
        $message = null;

        switch ($group['display_mode']) {

            case 'always':

                $visible = true;

                break;

            case 'message_when_closed':

                if ($status === 'before') {

                    $visible = true;
                    $message = $group['before_message'] ?? null;

                } elseif ($status === 'after') {

                    $visible = true;
                    $message = $group['after_message'] ?? null;

                } else {

                    $visible = true;

                }

                break;

            case 'hide_when_closed':

                if ($status === 'before' || $status === 'after') {
                    $visible = false;
                }

                break;

            default:

                $visible = true;

                break;
        }

        return [
            'group'   => $group,
            'status'  => $status,
            'visible' => $visible,
            'message' => $message,
        ];
    }

    /**
     * 取得指定位置的所有頁面設定
     *
     * 例如：
     * navbar
     * sidebar
     */
    public function getPagesByLocation(string $location): array
    {
        return $this->homepagePageModel
            ->where('location', $location)
            ->orderBy('id', 'ASC')
            ->findAll();
    }

    /**
     * 取得指定位置的所有頁面完整狀態
     */
    public function getPageStatesByLocation(string $location): array
    {
        $pages = $this->getPagesByLocation($location);

        $result = [];

        foreach ($pages as $page) {

            $state = $this->getPageState($page['page_key']);

            if ($state !== null) {
                $result[] = $state;
            }
        }

        return $result;
    }
}