<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/apply.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/admin.css') ?>">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <title>首頁管理 - 後臺管理系統</title>
</head>

<body>

    <!-- 頂部導覽列 -->
    <?php include APPPATH . 'Views/admin/header.php'; ?>

    <!-- 主要內容區 -->
    <main class="apply-container">

        <section class="apply-content-card" style="padding: 2rem;">

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
                    <i class="bi bi-layout-text-window-reverse"></i>
                    首頁管理
                </h2>

            </div>

            <!-- 成功訊息 -->
            <?php if (session()->has('success')): ?>

                <div class="success-message" style="margin-bottom: 1.25rem;">
                    <?= esc(session('success')) ?>
                </div>

            <?php endif; ?>

            <!-- 錯誤訊息 -->
            <?php if (session()->has('error')): ?>

                <div style="
                    margin-bottom: 1.25rem;
                    padding: 0.75rem 1rem;
                    background-color: #fff1f2;
                    border: 1px solid #fecdd3;
                    border-radius: 0.375rem;
                    color: #be123c;
                ">
                    <i class="bi bi-exclamation-circle"></i>
                    <?= esc(session('error')) ?>
                </div>

            <?php endif; ?>

            <!-- 首頁跑馬燈設定 -->
            <h3 style="
                margin-top: 2rem;
                margin-bottom: 1rem;
                color: #4c3b6e;
            ">
                <i class="bi bi-megaphone"></i>
                首頁跑馬燈設定
            </h3>

            <?php if (!$marquee): ?>

                <div style="
                    padding: 1rem;
                    background-color: #f8f5ff;
                    border: 1px solid #ddd6fe;
                    border-radius: 0.5rem;
                    color: #6b5b95;
                ">
                    目前沒有首頁跑馬燈設定。
                </div>

            <?php else: ?>

                <table class="admin-table">

                    <thead>
                        <tr>

                            <th style="width: 8%;">
                                編號
                            </th>

                            <th style="width: 42%;">
                                跑馬燈內容
                            </th>

                            <th style="width: 15%;">
                                啟用狀態
                            </th>

                            <th style="width: 15%;">
                                開放時間
                            </th>

                            <th style="width: 20%;">
                                操作
                            </th>

                        </tr>
                    </thead>

                    <tbody>

                        <tr>

                            <!-- 編號 -->
                            <td>
                                <strong>
                                    <?= esc($marquee['id']) ?>
                                </strong>
                            </td>

                            <!-- 跑馬燈內容 -->
                            <td>
                                <?= esc($marquee['content']) ?>
                            </td>

                            <!-- 啟用狀態 -->
                            <td>

                                <?php if ((int) $marquee['is_enabled'] === 1): ?>

                                    <span style="
                                        color: #16835a;
                                        font-weight: 600;
                                    ">
                                        🟢 啟用
                                    </span>

                                <?php else: ?>

                                    <span style="
                                        color: #d64545;
                                        font-weight: 600;
                                    ">
                                        🔴 停用
                                    </span>

                                <?php endif; ?>

                            </td>

                            <!-- 開放時間 -->
                            <td>

                                <?php if (
                                    empty($marquee['start_at']) &&
                                    empty($marquee['end_at'])
                                ): ?>

                                    無時間限制

                                <?php else: ?>

                                    <?php if (!empty($marquee['start_at'])): ?>
                                        <?= esc($marquee['start_at']) ?>
                                    <?php else: ?>
                                        不限開始時間
                                    <?php endif; ?>

                                    <br>

                                    <?php if (!empty($marquee['end_at'])): ?>
                                        <?= esc($marquee['end_at']) ?>
                                    <?php else: ?>
                                        不限結束時間
                                    <?php endif; ?>

                                <?php endif; ?>

                            </td>

                            <!-- 操作 -->
                            <td style="text-align: center;">

                                <a
                                    href="<?= site_url('admin/homepage-marquee/edit/' . $marquee['id']) ?>"
                                    class="secondary-button"
                                    style="
                                        text-decoration: none;
                                        padding: 0.25rem 0.6rem;
                                        font-size: 0.875rem;
                                    "
                                >
                                    <i class="bi bi-pencil"></i>
                                    編輯
                                </a>

                            </td>

                        </tr>

                    </tbody>

                </table>

            <?php endif; ?>

            <hr style="border: 0; border-top: 1px solid #ddd6fe; margin: 1.5rem 0;">

            <!-- 說明文字 -->
            <div style="
                margin-bottom: 0.5rem;
                padding: 0.9rem 1rem;
                background-color: #f8f5ff;
                border: 1px solid #ddd6fe;
                border-radius: 0.5rem;
                color: #6b5b95;
                font-size: 0.9rem;
                line-height: 1.6;
            ">
                <i class="bi bi-info-circle"></i>
                可在此管理前台首頁導覽列與側邊欄各功能的顯示狀態、開放時間及關閉時顯示的訊息。
            </div>

            <!-- 首頁群組設定 -->
            <h3 style="
                margin: 1rem 0;
                color: #4c3b6e;
            ">
                <i class="bi bi-collection"></i>
                首頁群組設定
            </h3>

            <table class="admin-table">

                <thead>
                    <tr>

                        <th style="width: 7%;">
                            編號
                        </th>

                        <th style="width: 15%;">
                            顯示位置
                        </th>

                        <th style="width: 25%;">
                            群組名稱
                        </th>

                        <th style="width: 18%;">
                            群組代碼
                        </th>

                        <th style="width: 15%;">
                            啟用狀態
                        </th>

                        <th style="width: 20%;">
                            操作
                        </th>

                    </tr>
                </thead>

                <tbody>

                    <?php if (empty($groups)): ?>

                        <tr>
                            <td colspan="6" style="
                                text-align: center;
                                color: #6b5b95;
                                padding: 2rem;
                            ">
                                目前沒有首頁群組設定。
                            </td>
                        </tr>

                    <?php else: ?>

                        <?php foreach ($groups as $group): ?>

                            <tr>

                                <!-- 編號 -->
                                <td>
                                    <strong>
                                        <?= esc($group['id']) ?>
                                    </strong>
                                </td>

                                <!-- 顯示位置 -->
                                <td>

                                    <?php if ($group['location'] === 'sidebar'): ?>

                                        <span style="
                                            color: #2563eb;
                                            font-weight: 600;
                                        ">
                                            <i class="bi bi-layout-sidebar"></i>
                                            側邊欄
                                        </span>

                                    <?php else: ?>

                                        <?= esc($group['location']) ?>

                                    <?php endif; ?>

                                </td>

                                <!-- 群組名稱 -->
                                <td>
                                    <strong>
                                        <?= esc($group['title']) ?>
                                    </strong>
                                </td>

                                <!-- 群組代碼 -->
                                <td>
                                    <code>
                                        <?= esc($group['group_key']) ?>
                                    </code>
                                </td>

                                <!-- 啟用狀態 -->
                                <td>

                                    <?php if ((int) $group['is_enabled'] === 1): ?>

                                        <span style="
                                            color: #16835a;
                                            font-weight: 600;
                                        ">
                                            🟢 啟用
                                        </span>

                                    <?php else: ?>

                                        <span style="
                                            color: #d64545;
                                            font-weight: 600;
                                        ">
                                            🔴 停用
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <!-- 操作 -->
                                <td style="text-align: center;">

                                    <a
                                        href="<?= site_url('admin/homepage-page-groups/edit/' . $group['id']) ?>"
                                        class="secondary-button"
                                        style="
                                            text-decoration: none;
                                            padding: 0.25rem 0.6rem;
                                            font-size: 0.875rem;
                                        "
                                    >
                                        <i class="bi bi-pencil"></i>
                                        編輯
                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </tbody>

            </table>


            <!-- 首頁功能設定表格 -->
             <h3 style="
                margin-top: 2rem;
                margin-bottom: 1rem;
                color: #4c3b6e;
            ">
                <i class="bi bi-grid"></i>
                首頁功能設定
            </h3>

            <table class="admin-table">

                <thead>
                    <tr>

                        <!-- 編號 -->
                        <th style="width: 7%;">
                            編號
                        </th>

                        <!-- 顯示位置 -->
                        <th style="width: 12%;">
                            顯示位置
                        </th>

                        <!-- 頁面名稱 -->
                        <th style="width: 23%;">
                            頁面名稱
                        </th>

                        <!-- 路由 -->
                        <th style="width: 18%;">
                            路由
                        </th>

                        <!-- 啟用狀態 -->
                        <th style="width: 12%;">
                            啟用狀態
                        </th>

                        <!-- 顯示方式 -->
                        <th style="width: 18%;">
                            顯示方式
                        </th>

                        <!-- 操作 -->
                        <th style="width: 10%;">
                            操作
                        </th>

                    </tr>
                </thead>

                <tbody>

                    <?php if (empty($pages)): ?>

                        <tr>
                            <td colspan="7" style="
                                text-align: center;
                                color: #6b5b95;
                                padding: 2rem;
                            ">
                                目前沒有首頁頁面設定。
                            </td>
                        </tr>

                    <?php else: ?>

                        <?php foreach ($pages as $page): ?>

                            <tr>

                                <!-- 編號 -->
                                <td>
                                    <strong>
                                        <?= esc($page['id']) ?>
                                    </strong>
                                </td>

                                <!-- 顯示位置 -->
                                <td>

                                    <?php if ($page['location'] === 'navbar'): ?>

                                        <span style="
                                            color: #6d28d9;
                                            font-weight: 600;
                                        ">
                                            <i class="bi bi-menu-button-wide"></i>
                                            導覽列
                                        </span>

                                    <?php elseif ($page['location'] === 'sidebar'): ?>

                                        <span style="
                                            color: #2563eb;
                                            font-weight: 600;
                                        ">
                                            <i class="bi bi-layout-sidebar"></i>
                                            側邊欄
                                        </span>

                                    <?php else: ?>

                                        <?= esc($page['location']) ?>

                                    <?php endif; ?>

                                </td>

                                <!-- 頁面名稱 -->
                                <td>
                                    <strong>
                                        <?= esc($page['title']) ?>
                                    </strong>
                                </td>

                                <!-- 路由 -->
                                <td>
                                    <code>
                                        <?= esc($page['route']) ?>
                                    </code>
                                </td>

                                <!-- 啟用狀態 -->
                                <td>

                                    <?php if ((int) $page['is_enabled'] === 1): ?>

                                        <span style="
                                            color: #16835a;
                                            font-weight: 600;
                                        ">
                                            🟢 啟用
                                        </span>

                                    <?php else: ?>

                                        <span style="
                                            color: #d64545;
                                            font-weight: 600;
                                        ">
                                            🔴 停用
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <!-- 顯示方式 -->
                                <td>

                                    <?php if ($page['display_mode'] === 'always'): ?>

                                        永遠顯示

                                    <?php elseif ($page['display_mode'] === 'message_when_closed'): ?>

                                        關閉時顯示訊息

                                    <?php elseif ($page['display_mode'] === 'hide_when_closed'): ?>

                                        關閉時隱藏

                                    <?php else: ?>

                                        <?= esc($page['display_mode']) ?>

                                    <?php endif; ?>

                                </td>

                                <!-- 操作 -->
                                <td style="text-align: center;">

                                    <a
                                        href="<?= site_url('admin/homepage-pages/edit/' . $page['id']) ?>"
                                        class="secondary-button"
                                        style="
                                            text-decoration: none;
                                            padding: 0.25rem 0.6rem;
                                            font-size: 0.875rem;
                                        "
                                    >
                                        <i class="bi bi-pencil"></i>
                                        編輯
                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </tbody>

            </table>

        </section>

    </main>

    <!-- 頁尾 -->
    <footer class="apply-footer" style="margin-top: 2rem;">
        Apply116 後臺管理系統
    </footer>

</body>

</html>