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
                <?php if ($title === '重要日程'): ?>
                    <div class="system-info-empty">
                        <i class="bi bi-info-circle"></i>
                        <div class="system-info-empty-content">
                            <strong>
                                詳細時程尚未公布
                            </strong>
                            <p>
                                目前尚無資料。
                            </p>
                        </div>
                    </div>
                <?php elseif ($title === '網路購買簡章'): ?>
                    <div class="system-info-empty">
                        <i class="bi bi-info-circle"></i>
                        <div class="system-info-empty-content">
                            <strong>
                                購買資訊尚未公布
                            </strong>
                            <p>
                                目前尚無資料。
                            </p>
                        </div>
                    </div>
                <?php elseif ($title === '招生相關規定'): ?>
                    <div class="system-info-empty">
                        <i class="bi bi-info-circle"></i>
                        <div class="system-info-empty-content">
                            <strong>
                                相關規定尚未公布
                            </strong>
                            <p>
                                目前尚無資料。
                            </p>
                        </div>
                    </div>
                <?php elseif ($title === '招生統計資料'): ?>
                    <div class="system-info-section">
                        <h3>
                            <span class="system-info-number">
                                1
                            </span>
                            招生學校
                        </h3>
                        <p>
                            共 64 所大學校院。
                        </p>
                    </div>
                    <div class="system-info-section">
                        <h3>
                            <span class="system-info-number">
                                2
                            </span>
                            招生學系(組)總數
                        </h3>
                        <p>
                            2,206 校系。
                        </p>
                    </div>
                    <div class="system-info-section">
                        <h3>
                            <span class="system-info-number">
                                3
                            </span>
                            招生名額總數
                        </h3>
                        <p>
                            50,450 個【國立：19,897 個，私立：30,553 個】。
                        </p>
                    </div>
                    <div class="system-info-highlight">
                        <i class="bi bi-info-circle"></i>
                        <span>
                            其餘相關資料陸續統計中...
                        </span>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>
    <script src="<?= base_url('JS/sidebar.js') ?>"></script>
</body>

</html>