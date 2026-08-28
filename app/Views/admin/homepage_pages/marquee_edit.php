<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/apply.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/admin.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <title>編輯首頁跑馬燈 - 後臺管理系統</title>
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
                    <i class="bi bi-megaphone"></i>
                    編輯首頁跑馬燈
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
                action="<?= site_url('admin/homepage-marquee/update/' . $marquee['id']) ?>"
                method="post"
            >

                <?= csrf_field() ?>

                <!-- 跑馬燈內容 -->
                <div style="margin-bottom: 1.5rem;">

                    <h3 style="
                        font-size: 1.1rem;
                        color: #5b21b6;
                        margin-bottom: 1rem;
                    ">
                        <i class="bi bi-info-circle"></i>
                        跑馬燈內容
                    </h3>

                    <div>

                        <textarea
                            id="content"
                            name="content"
                            rows="4"
                            required
                            maxlength="1000"
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
                        ><?= esc(old('content', $marquee['content'] ?? '')) ?></textarea>

                        <div style="
                            margin-top: 0.4rem;
                            color: #6b5b95;
                            font-size: 0.875rem;
                        ">
                            請輸入首頁上方跑馬燈要顯示的文字。
                        </div>
                    </div>

                </div>

                <!-- 顯示與時間設定 -->
                <div style="margin-bottom: 1.5rem;">

                    <h3 style="
                        font-size: 1.1rem;
                        color: #5b21b6;
                        margin-bottom: 1rem;
                    ">
                        <i class="bi bi-display"></i>
                        顯示與時間設定
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
                                <?= old('is_enabled', $marquee['is_enabled'] ?? 0) ? 'checked' : '' ?>
                            >

                            啟用首頁跑馬燈
                        </label>

                        <div style="
                            margin-top: 0.4rem;
                            margin-left: 1.5rem;
                            color: #6b5b95;
                            font-size: 0.875rem;
                        ">
                            停用後，前台首頁將不顯示跑馬燈。
                        </div>

                    </div>

                    <!-- 開始與結束時間 -->
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
                                開始時間
                            </label>

                            <input
                                type="datetime-local"
                                id="start_at"
                                name="start_at"
                                value="<?= old('start_at', !empty($marquee['start_at']) ? date('Y-m-d\TH:i', strtotime($marquee['start_at'])) : '') ?>"
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

                            <div style="
                                margin-top: 0.4rem;
                                color: #6b5b95;
                                font-size: 0.875rem;
                            ">
                                留白表示不限制開始時間。
                            </div>
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
                                結束時間
                            </label>

                            <input
                                type="datetime-local"
                                id="end_at"
                                name="end_at"
                                value="<?= old('end_at', !empty($marquee['end_at']) ? date('Y-m-d\TH:i', strtotime($marquee['end_at'])) : '') ?>"
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

                            <div style="
                                margin-top: 0.4rem;
                                color: #6b5b95;
                                font-size: 0.875rem;
                            ">
                                留白表示不限制結束時間。
                            </div>
                        </div>

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

    <!-- 頁尾 -->
    <footer class="apply-footer" style="margin-top: 2rem;">
        Apply116 後臺管理系統
    </footer>

</body>

</html>