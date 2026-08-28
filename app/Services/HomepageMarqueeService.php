<?php

namespace App\Services;

use App\Models\HomepageMarqueeModel;

class HomepageMarqueeService
{
    protected $homepageMarqueeModel;

    public function __construct()
    {
        $this->homepageMarqueeModel = new HomepageMarqueeModel();
    }

    /**
     * 取得首頁跑馬燈
     */
    public function getMarquee(): ?array
    {
        return $this->homepageMarqueeModel
            ->orderBy('id', 'ASC')
            ->first();
    }

    /**
     * 判斷跑馬燈目前是否應該顯示
     */
    public function isVisible(array $marquee): bool
    {
        // 管理員停用
        if ((int) ($marquee['is_enabled'] ?? 0) !== 1) {
            return false;
        }

        $now = time();

        // 尚未到開始時間
        if (!empty($marquee['start_at'])) {
            $startAt = strtotime($marquee['start_at']);

            if ($startAt !== false && $now < $startAt) {
                return false;
            }
        }

        // 已超過結束時間
        if (!empty($marquee['end_at'])) {
            $endAt = strtotime($marquee['end_at']);

            if ($endAt !== false && $now >= $endAt) {
                return false;
            }
        }

        return true;
    }

    /**
     * 取得目前應顯示的跑馬燈
     */
    public function getVisibleMarquee(): ?array
    {
        $marquee = $this->getMarquee();

        if (!$marquee) {
            return null;
        }

        if (!$this->isVisible($marquee)) {
            return null;
        }

        return $marquee;
    }
}