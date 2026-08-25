<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Apply 116 -
        <?= esc($title) ?>
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
                        財團法人大學入學考試中心基金會
                    </h3>
                    <a href="https://www.ceec.edu.tw/" target="_blank" rel="noopener noreferrer"
                        class="system-info-primary-button">
                        <i class="bi bi-box-arrow-up-right"></i>
                        前往網站
                    </a>
                </div>
                <div class="system-info-section">
                    <h3>
                        <i class="bi bi-box-arrow-up-right"></i>
                        大學術科考試委員會聯合會
                    </h3>
                    <a href="https://www.cape.edu.tw/" target="_blank" rel="noopener noreferrer"
                        class="system-info-primary-button">
                        <i class="bi bi-box-arrow-up-right"></i>
                        前往網站
                    </a>
                </div>
                <div class="system-info-section">
                    <h3>
                        <i class="bi bi-box-arrow-up-right"></i>
                        財團法人技專校院入學測驗中心基金會
                    </h3>
                    <a href="https://www.tcte.edu.tw/" target="_blank" rel="noopener noreferrer"
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