<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Apply 116 - <?= esc($title) ?>
    </title>
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/home.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/system-info.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
    <?= $this->include('Layout/navbar') ?>
    <?= $this->include('Layout/sidebar') ?>
    <main class="home-main">
        <div class="home-content">
            <section class="system-info-header">
                <h2>
                    <i class="<?= esc($icon) ?>"></i>
                    <?= esc($title) ?>
                </h2>
                <p>
                    <?= esc($description) ?>
                </p>
            </section>
            <section class="system-info-card">
                <div class="system-info-section">
                    <h3>
                        <i class="bi bi-box-arrow-up-right"></i>
                        教育部
                    </h3>
                    <a href="https://www.edu.tw/Default.aspx" target="_blank" rel="noopener noreferrer"
                        class="system-info-primary-button">
                        <i class="bi bi-box-arrow-up-right"></i>
                        前往網站
                    </a>
                </div>
                <div class="system-info-section">
                    <h3>
                        <i class="bi bi-box-arrow-up-right"></i>
                        教育部高教司
                    </h3>
                    <a href="https://depart.moe.edu.tw/ED2200/Default.aspx" target="_blank" rel="noopener noreferrer"
                        class="system-info-primary-button">
                        <i class="bi bi-box-arrow-up-right"></i>
                        前往網站
                    </a>
                </div>
                <div class="system-info-section">
                    <h3>
                        <i class="bi bi-box-arrow-up-right"></i>
                        國立中正大學
                    </h3>
                    <a href="https://www.ccu.edu.tw/" target="_blank" rel="noopener noreferrer"
                        class="system-info-primary-button">
                        <i class="bi bi-box-arrow-up-right"></i>
                        前往網站
                    </a>
                </div>
                <div class="system-info-section">
                    <h3>
                        <i class="bi bi-box-arrow-up-right"></i>
                        ColleGo! 大學選才與高中育才輔助系統
                    </h3>
                    <a href="https://collego.edu.tw/" target="_blank" rel="noopener noreferrer"
                        class="system-info-primary-button">
                        <i class="bi bi-box-arrow-up-right"></i>
                        前往網站
                    </a>
                </div>
                <div class="system-info-section">
                    <h3>
                        <i class="bi bi-box-arrow-up-right"></i>
                        大學多元入學升學網
                    </h3>
                    <a href="https://nsdua.moe.edu.tw/#/" target="_blank" rel="noopener noreferrer"
                        class="system-info-primary-button">
                        <i class="bi bi-box-arrow-up-right"></i>
                        前往網站
                    </a>
                </div>
                <div class="system-info-section">
                    <h3>
                        <i class="bi bi-box-arrow-up-right"></i>
                        大學網路博覽會
                    </h3>
                    <a href="https://www.testnews.com.tw/shibao/" target="_blank" rel="noopener noreferrer"
                        class="system-info-primary-button">
                        <i class="bi bi-box-arrow-up-right"></i>
                        前往網站
                    </a>
                </div>
                <div class="system-info-section">
                    <h3>
                        <i class="bi bi-box-arrow-up-right"></i>
                        大學程式設計先修檢測（APCS）
                    </h3>
                    <a href="https://apcs.csie.ntnu.edu.tw/" target="_blank" rel="noopener noreferrer"
                        class="system-info-primary-button">
                        <i class="bi bi-box-arrow-up-right"></i>
                        前往網站
                    </a>
                </div>
            </section>
        </div>
    </main>
    <script src="<?= base_url('JS/sidebar.js') ?>"></script>
</body>

</html>