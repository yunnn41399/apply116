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
                <?php if (isset($pageState) && $pageState['status'] !== 'open' && !empty($pageState['message'])): ?>
                    <!-- 頁面尚未開放或已結束時顯示後臺設定的提醒文字 -->
                    <div class="system-info-empty">
                        <i class="bi bi-info-circle"></i>
                        <div class="system-info-empty-content">
                            <strong>系統提醒</strong>
                            <p><?= esc($pageState['message']) ?></p>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- 頁面開放時顯示的原本內容 -->
                    <div class="system-info-empty">
                        <i class="bi bi-info-circle"></i>
                        <div class="system-info-empty-content">
                            <strong><?= esc($emptyMessage ?? '系統尚未開放') ?></strong>
                            <p><?= esc($emptyHint ?? '目前尚無資料。') ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>
    <script src="<?= base_url('JS/sidebar.js') ?>"></script>
</body>

</html>