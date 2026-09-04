<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/apply.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/admin.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <title>編輯首頁群組 - 後臺管理系統</title>
</head>

<body>

    <!-- 主要內容區 -->
    <main class="admin-announcement-container">
        <section class="apply-content-card" style="padding: 2rem; max-width: 900px; margin: 0 auto;">

            <!-- 頁面標題 -->
            <div style="
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1.5rem;
                border-bottom: 2px solid #ddd6fe;
                padding-bottom: 0.75rem;
            ">
                <h2 class="section-title" style="border: none; margin: 0; padding: 0;">
                    <i class="bi bi-collection"></i>
                    編輯首頁群組
                </h2>

                <a
                    href="<?= site_url('admin/homepage-pages') ?>"
                    class="secondary-button"
                    style="text-decoration: none; padding: 0.5rem 1rem;"
                >
                    <i class="bi bi-arrow-left"></i>
                    返回列表
                </a>
            </div>

            <!-- 錯誤訊息 -->
            <?php if (session()->has('error')): ?>
                <div
                    style="
                        margin-bottom: 1.25rem;
                        padding: 0.75rem 1rem;
                        background-color: #fef2f2;
                        border: 1px solid #fecaca;
                        color: #b91c1c;
                        border-radius: 0.375rem;
                    "
                >
                    <i class="bi bi-exclamation-circle"></i>
                    <?= esc(session('error')) ?>
                </div>
            <?php endif; ?>

            <!-- 編輯表單 -->
            <form
                method="post"
                action="<?= site_url('admin/homepage-page-groups/update/' . $group['id']) ?>"
            >

                <?= csrf_field() ?>

                <!-- 群組基本資訊 -->
                <div style="margin-bottom: 1.5rem;">

                    <h3 style="
                        font-size: 1.1rem;
                        color: #5b21b6;
                        margin-bottom: 1rem;
                    ">
                        <i class="bi bi-info-circle"></i>
                        群組基本資訊
                    </h3>

                    <!-- 群組名稱 -->
                    <div style="margin-bottom: 1rem;">
                        <label
                            for="title"
                            style="display: block; font-weight: 600; margin-bottom: 0.4rem;"
                        >
                            群組名稱
                        </label>

                        <input
                            type="text"
                            id="title"
                            value="<?= esc($group['title'] ?? '') ?>"
                            readonly
                            style="
                                width: 100%;
                                padding: 0.6rem 0.75rem;
                                border: 1px solid #ddd6fe;
                                border-radius: 0.375rem;
                                background-color: #f5f3ff;
                                color: #6b5b95;
                                box-sizing: border-box;
                            "
                        >
                    </div>

                    <!-- 群組代碼 -->
                    <div>
                        <label
                            for="group_key"
                            style="display: block; font-weight: 600; margin-bottom: 0.4rem;"
                        >
                            群組代碼
                        </label>

                        <input
                            type="text"
                            id="group_key"
                            value="<?= esc($group['group_key'] ?? '') ?>"
                            readonly
                            style="
                                width: 100%;
                                padding: 0.6rem 0.75rem;
                                border: 1px solid #ddd6fe;
                                border-radius: 0.375rem;
                                background-color: #f5f3ff;
                                color: #6b5b95;
                                box-sizing: border-box;
                            "
                        >
                    </div>

                </div>

                <!-- 顯示設定 -->
                <div style="margin-bottom: 1.5rem;">

                    <h3 style="
                        font-size: 1.1rem;
                        color: #5b21b6;
                        margin-bottom: 1rem;
                    ">
                        <i class="bi bi-display"></i>
                        顯示設定
                    </h3>

                    <!-- 是否啟用 -->
                    <div style="
                        margin-bottom: 1rem;
                        padding: 0.9rem 1rem;
                        background-color: #faf5ff;
                        border: 1px solid #ddd6fe;
                        border-radius: 0.375rem;
                    ">

                        <label
                            style="
                                display: flex;
                                align-items: center;
                                gap: 0.5rem;
                                cursor: pointer;
                                font-weight: 600;
                            "
                        >
                            <input
                                type="checkbox"
                                name="is_enabled"
                                value="1"
                                <?= (int) ($group['is_enabled'] ?? 0) === 1 ? 'checked' : '' ?>
                            >

                            啟用此群組
                        </label>

                        <div style="
                            margin-top: 0.4rem;
                            margin-left: 1.5rem;
                            color: #6b5b95;
                            font-size: 0.875rem;
                        ">
                            關閉後，該群組將不會依照原本設定顯示。
                        </div>

                    </div>

                    <!-- 顯示方式 -->
                    <div style="margin-bottom: 1rem;">

                        <label
                            for="display_mode"
                            style="
                                display: block;
                                font-weight: 600;
                                margin-bottom: 0.4rem;
                            "
                        >
                            顯示方式
                        </label>

                        <select
                            id="display_mode"
                            name="display_mode"
                            style="
                                width: 100%;
                                padding: 0.6rem 0.75rem;
                                border: 1px solid #ddd6fe;
                                border-radius: 0.375rem;
                                outline: none;
                                font-size: 0.95rem;
                                background-color: #fff;
                                box-sizing: border-box;
                            "
                        >

                            <option
                                value="always"
                                <?= ($group['display_mode'] ?? '') === 'always' ? 'selected' : '' ?>
                            >
                                永遠顯示
                            </option>

                            <option
                                value="message_when_closed"
                                <?= ($group['display_mode'] ?? '') === 'message_when_closed' ? 'selected' : '' ?>
                            >
                                關閉時顯示提示訊息
                            </option>

                            <option
                                value="hide_when_closed"
                                <?= ($group['display_mode'] ?? '') === 'hide_when_closed' ? 'selected' : '' ?>
                            >
                                關閉時隱藏
                            </option>

                        </select>

                    </div>

                    <!-- 開放時間 -->
                    <div
                        style="
                            display: grid;
                            grid-template-columns: 1fr 1fr;
                            gap: 1rem;
                            margin-bottom: 1rem;
                        "
                    >

                        <div>
                            <label
                                for="start_at"
                                style="
                                    display: block;
                                    font-weight: 600;
                                    margin-bottom: 0.4rem;
                                "
                            >
                                開放開始時間
                            </label>

                            <input
                                type="datetime-local"
                                id="start_at"
                                name="start_at"
                                value="<?= !empty($group['start_at']) ? date('Y-m-d\TH:i', strtotime($group['start_at'])) : '' ?>"
                                style="
                                    width: 100%;
                                    padding: 0.6rem 0.75rem;
                                    border: 1px solid #ddd6fe;
                                    border-radius: 0.375rem;
                                    outline: none;
                                    font-size: 0.95rem;
                                    box-sizing: border-box;
                                "
                            >
                        </div>

                        <div>
                            <label
                                for="end_at"
                                style="
                                    display: block;
                                    font-weight: 600;
                                    margin-bottom: 0.4rem;
                                "
                            >
                                開放結束時間
                            </label>

                            <input
                                type="datetime-local"
                                id="end_at"
                                name="end_at"
                                value="<?= !empty($group['end_at']) ? date('Y-m-d\TH:i', strtotime($group['end_at'])) : '' ?>"
                                style="
                                    width: 100%;
                                    padding: 0.6rem 0.75rem;
                                    border: 1px solid #ddd6fe;
                                    border-radius: 0.375rem;
                                    outline: none;
                                    font-size: 0.95rem;
                                    box-sizing: border-box;
                                "
                            >
                        </div>

                    </div>

                    <!-- 開放前訊息 -->
                    <div style="margin-bottom: 1rem;">
                        <label
                            for="before_message"
                            style="
                                display: block;
                                font-weight: 600;
                                margin-bottom: 0.4rem;
                            "
                        >
                            開放前顯示訊息
                        </label>

                        <textarea
                            name="before_message"
                            id="before_message"
                            rows="3"
                            style="
                                width: 100%;
                                padding: 0.6rem 0.75rem;
                                border: 1px solid #ddd6fe;
                                border-radius: 0.375rem;
                                outline: none;
                                font-size: 0.95rem;
                                resize: vertical;
                                box-sizing: border-box;
                            "
                        ><?= esc($group['before_message'] ?? '') ?></textarea>
                    </div>

                    <!-- 關閉後訊息 -->
                    <div>
                        <label
                            for="after_message"
                            style="
                                display: block;
                                font-weight: 600;
                                margin-bottom: 0.4rem;
                            "
                        >
                            開放結束後顯示訊息
                        </label>

                        <textarea
                            name="after_message"
                            id="after_message"
                            rows="3"
                            style="
                                width: 100%;
                                padding: 0.6rem 0.75rem;
                                border: 1px solid #ddd6fe;
                                border-radius: 0.375rem;
                                outline: none;
                                font-size: 0.95rem;
                                resize: vertical;
                                box-sizing: border-box;
                            "
                        ><?= esc($group['after_message'] ?? '') ?></textarea>
                    </div>

                </div>

                <!-- 操作按鈕 -->
                <div style="
                    display: flex;
                    justify-content: flex-start;
                    gap: 0.75rem;
                    padding-top: 1rem;
                    border-top: 1px solid #e5e7eb;
                ">

                    <a
                        href="<?= site_url('admin/homepage-pages') ?>"
                        class="secondary-button"
                        style="
                            text-decoration: none;
                            padding: 0.6rem 1.25rem;
                        "
                    >
                        取消
                    </a>

                    <button
                        type="submit"
                        class="primary-button"
                        style="
                            padding: 0.6rem 1.25rem;
                        "
                    >
                        <i class="bi bi-check-lg"></i>
                        儲存設定
                    </button>

                </div>

            </form>

        </section>
    </main>

    <footer class="apply-footer" style="margin-top: 2rem;">
        Apply116 後臺管理系統
    </footer>

</body>

</html>