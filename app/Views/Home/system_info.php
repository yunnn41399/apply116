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
                <div class="system-info-empty">
                    <i class="bi bi-info-circle"></i>
                    <div class="system-info-empty-content">
                        <strong>
                            <?= esc($emptyMessage) ?>
                        </strong>
                        <p>
                            <?= esc($emptyHint) ?>
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>

</html>