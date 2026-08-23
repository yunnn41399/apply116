<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/apply.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/admin.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>後臺管理系統 - 首頁</title>
</head>

<body>
    <?php $adminName = session()->get('admin_name') ?? session()->get('admin_username') ?? '管理員'; ?>

    <!-- 頂部導覽列 -->
    <?php include APPPATH . 'Views/admin/header.php'; ?>

    <!-- 主要內容區 -->
    <main class="apply-container">
        <section class="apply-welcome">
            <h2>歡迎回來！</h2>
            <p>
                <span class="candidate-name"><?= esc($adminName) ?></span> 您好，歡迎使用後臺管理系統。
            </p>
        </section>

        <!-- 功能選單卡片網格 -->
        <div class="admin-menu">
            <a href="<?= site_url('admin/profile') ?>" class="apply-card">
                <div class="apply-card-icon">
                    <i class="bi bi-person-gear"></i>
                </div>
                <div class="apply-card-title">我的帳號</div>
                <div class="apply-card-description">管理與修改個人帳號設定</div>
            </a>

            <?php if (session()->get('admin_role') === 'super_admin'): ?>
                <a href="<?= site_url('admin/admins') ?>" class="apply-card">
                    <div class="apply-card-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="apply-card-title">管理員帳號管理</div>
                    <div class="apply-card-description">管理後臺管理員帳號與權限</div>
                </a>
            <?php endif; ?>

            <a href="<?= site_url('admin/announcement') ?>" class="apply-card">
                <div class="apply-card-icon">
                    <i class="bi bi-megaphone"></i>
                </div>
                <div class="apply-card-title">公告管理</div>
                <div class="apply-card-description">新增與修改前台系統公告內容</div>
            </a>

            <a href="<?= site_url('admin/candidates') ?>" class="apply-card">
                <div class="apply-card-icon">
                    <i class="bi bi-person-lines-fill"></i>
                </div>
                <div class="apply-card-title">考生資料</div>
                <div class="apply-card-description">查詢與管理考生基本資料</div>
            </a>

            <a href="<?= site_url('admin/applications') ?>" class="apply-card">
                <div class="apply-card-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <div class="apply-card-title">報名資料</div>
                <div class="apply-card-description">審核與查詢考生報名紀錄</div>
            </a>

            <a href="#" class="apply-card">
                <div class="apply-card-icon">
                    <i class="bi bi-layout-text-window-reverse"></i>
                </div>
                <div class="apply-card-title">首頁管理</div>
                <div class="apply-card-description">管理首頁展示資訊與區塊</div>
            </a>
        </div>
    </main>

    <footer class="apply-footer">
        Apply116 後臺管理系統
    </footer>
</body>

</html>