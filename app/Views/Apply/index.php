<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/apply.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>網路報名系統</title>
</head>

<body>
    <header class="apply-header">
        <h1 class="apply-header-title">
            網路報名系統
        </h1>
        <nav class="apply-nav">
            <a href="<?= site_url('apply') ?>" class="apply-nav-link active">
                首頁
            </a>
            <a href="<?= site_url('department') ?>" class="apply-nav-link">
                查詢校系資料
            </a>
            <a href="<?= site_url('apply/register') ?>" class="apply-nav-link">
                立即報名
            </a>
            <a href="<?= site_url('application-status') ?>" class="apply-nav-link">
                報名狀態查詢
            </a>
        </nav>
        <div class="apply-header-right">
            <div class="apply-header-user">
                <span class="apply-header-text">
                    學測應試號碼：
                    <?= esc(session()->get('exam_number')) ?>
                </span>
                <span class="apply-header-text">
                    姓名：
                    <?= esc(session()->get('candidate_name') ?? '') ?>
                </span>
            </div>
            <a href="<?= site_url('logout') ?>" class="apply-logout-button">
                <i class="bi bi-box-arrow-right"></i>
                登出
            </a>
        </div>
    </header>
    <main class="apply-container">
        <section class="apply-welcome">
            <h2>
                歡迎您！
            </h2>
            <p>
                <span class="exam-number">
                    <?= esc($candidate['exam_number']) ?>
                </span>
                號
                <span class="candidate-name">
                    <?= esc($candidate['name']) ?>
                </span>
                考生，歡迎使用網路報名系統。
            </p>
        </section>
        <div class="apply-menu">
            <a href="<?= site_url('department') ?>" class="apply-card">
                <div class="apply-card-icon">
                    <i class="bi bi-search"></i>
                </div>
                <div class="apply-card-title">
                    查詢校系資料
                </div>
                <div class="apply-card-description">
                    查詢各大學校系及相關招生資訊
                </div>
            </a>
            <a href="<?= site_url('apply/register') ?>" class="apply-card">
                <div class="apply-card-icon">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <div class="apply-card-title">
                    立即報名
                </div>
                <div class="apply-card-description">
                    填寫報名資料並選擇欲報名的校系
                </div>
            </a>
            <a href="<?= site_url('application-status') ?>" class="apply-card">
                <div class="apply-card-icon">
                    <i class="bi bi-clipboard-check"></i>
                </div>
                <div class="apply-card-title">
                    報名狀態查詢
                </div>
                <div class="apply-card-description">
                    查詢目前的報名資料及狀態
                </div>
            </a>
        </div>
    </main>
    <footer class="apply-footer">
        Apply116 網路報名系統
    </footer>
</body>

</html>