<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/apply.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/admin.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <title>編輯首頁頁面 - 後臺管理系統</title>
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
                    <i class="bi bi-pencil-square"></i>
                    編輯首頁頁面
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
                action="<?= site_url('admin/homepage-pages/update/' . $page['id']) ?>"
            >

                <?= csrf_field() ?>

                <!-- 頁面基本資訊 -->
                <div style="margin-bottom: 1.5rem;">

                    <h3 style="
                        font-size: 1.1rem;
                        color: #5b21b6;
                        margin-bottom: 1rem;
                    ">
                        <i class="bi bi-info-circle"></i>
                        頁面基本資訊
                    </h3>

                    <!-- 頁面名稱 -->
                    <div style="margin-bottom: 1rem;">
                        <label
                            for="title"
                            style="display: block; font-weight: 600; margin-bottom: 0.4rem;"
                        >
                            頁面名稱
                        </label>

                        <input
                            type="text"
                            id="title"
                            value="<?= esc($page['title'] ?? '') ?>"
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

                    <!-- Page Key -->
                    <div style="margin-bottom: 1rem;">
                        <label
                            for="page_key"
                            style="display: block; font-weight: 600; margin-bottom: 0.4rem;"
                        >
                            頁面識別名稱
                        </label>

                        <input
                            type="text"
                            id="page_key"
                            value="<?= esc($page['page_key'] ?? '') ?>"
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

                    <!-- 路由 -->
                    <div style="margin-bottom: 1rem;">
                        <label
                            for="route"
                            style="display: block; font-weight: 600; margin-bottom: 0.4rem;"
                        >
                            路由
                        </label>

                        <input
                            type="text"
                            id="route"
                            value="<?= esc($page['route'] ?? '') ?>"
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

                    <!-- 顯示位置 -->
                    <div>
                        <label
                            for="location"
                            style="display: block; font-weight: 600; margin-bottom: 0.4rem;"
                        >
                            顯示位置
                        </label>

                        <input
                            type="text"
                            id="location"
                            value="<?= esc($page['location'] ?? '') ?>"
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
                                <?= !empty($page['is_enabled']) ? 'checked' : '' ?>
                            >

                            啟用此頁面
                        </label>

                        <div style="
                            margin-top: 0.4rem;
                            margin-left: 1.5rem;
                            color: #6b5b95;
                            font-size: 0.875rem;
                        ">
                            關閉後，該頁面將不會依照原本設定顯示。
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
                                <?= ($page['display_mode'] ?? '') === 'always' ? 'selected' : '' ?>
                            >
                                永遠顯示
                            </option>

                            <option
                                value="message_when_closed"
                                <?= ($page['display_mode'] ?? '') === 'message_when_closed' ? 'selected' : '' ?>
                            >
                                關閉時顯示提示訊息
                            </option>

                            <option
                                value="hide_when_closed"
                                <?= ($page['display_mode'] ?? '') === 'hide_when_closed' ? 'selected' : '' ?>
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
                                value="<?= !empty($page['start_at']) ? date('Y-m-d\TH:i', strtotime($page['start_at'])) : '' ?>"
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
                                value="<?= !empty($page['end_at']) ? date('Y-m-d\TH:i', strtotime($page['end_at'])) : '' ?>"
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

                    <div style="
                        color: #6b5b95;
                        font-size: 0.875rem;
                        background-color: #faf5ff;
                        padding: 0.75rem 1rem;
                        border-radius: 0.375rem;
                    ">
                        <i class="bi bi-info-circle"></i>
                        若未設定開放時間，則不會以時間限制判斷頁面是否開放。
                    </div>

                </div>


                <!-- 提示訊息設定 -->
                <div style="margin-bottom: 1.5rem;">

                    <h3 style="
                        font-size: 1.1rem;
                        color: #5b21b6;
                        margin-bottom: 1rem;
                    ">
                        <i class="bi bi-chat-square-text"></i>
                        關閉時提示訊息
                    </h3>

                    <!-- 尚未開放 -->
                    <div style="margin-bottom: 1rem;">

                        <label
                            for="before_message"
                            style="
                                display: block;
                                font-weight: 600;
                                margin-bottom: 0.4rem;
                            "
                        >
                            尚未開放時訊息
                        </label>

                        <textarea
                            id="before_message"
                            name="before_message"
                            rows="3"
                            placeholder="例如：系統尚未開放，目前尚無資料。"
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
                        ><?= esc($page['before_message'] ?? '') ?></textarea>

                    </div>


                    <!-- 已經結束 -->
                    <div>

                        <label
                            for="after_message"
                            style="
                                display: block;
                                font-weight: 600;
                                margin-bottom: 0.4rem;
                            "
                        >
                            開放期限已過訊息
                        </label>

                        <textarea
                            id="after_message"
                            name="after_message"
                            rows="3"
                            placeholder="例如：系統開放期限已過。"
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
                        ><?= esc($page['after_message'] ?? '') ?></textarea>

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
