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
        <div class="apply-header-user">
            <strong>
                <?= esc(session()->get('exam_number')) ?>
                <?= esc($candidate['name']) ?>
            </strong>
            您好！ 
        </div>
    </header>
    <main class="apply-container">
        <!-- 歡迎區 -->
        <section class="apply-welcome">
            <h2>
                歡迎您！
            </h2>
            <p>
                <span class="exam-number">
                    <?= esc(session()->get('exam_number')) ?>
                </span>
                號
                <span class="candidate-name">
                    <?= esc($candidate['name']) ?>
                </span>
                考生，歡迎使用網路報名系統。
            </p>
        </section>
        <!-- 功能區 -->
        <div class="apply-menu">
            <!-- 查詢校系 -->
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
            <!-- 立即報名 -->
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
            <!-- 登出 -->
            <a href="<?= site_url('logout') ?>" class="apply-card">
                <div class="apply-card-icon">
                    <i class="bi bi-box-arrow-right"></i>
                </div>
                <div class="apply-card-title">
                    登出系統
                </div>
                <div class="apply-card-description">
                    登出網路報名系統
                </div>
            </a>
        </div>
    </main>
    <footer class="apply-footer">
        Apply116 網路報名系統
    </footer>
</body>

</html>