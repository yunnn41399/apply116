<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply 116</title>
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/home.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <?= $this->include('Layout/navbar') ?>
    <?= $this->include('Layout/sidebar') ?>
    <main class="home-main">
        <div class="home-content">

            <div class="home-announcement-section">

                <div class="home-section-title">
                    <i class="bi bi-megaphone"></i>
                    <h2>訊息公告</h2>
                </div>

                <?php if (empty($announcements)): ?>

                    <div class="home-no-announcement">
                        目前沒有公告。
                    </div>

                <?php else: ?>

                    <div class="home-announcement-list">

                        <?php foreach ($announcements as $announcement): ?>

                            <div class="home-announcement-item">

                                <div class="home-announcement-date">
                                    <?= esc(date(
                                        'Y/m/d',
                                        strtotime($announcement['publish_date'])
                                    )) ?>
                                </div>

                                <div class="home-announcement-category">
                                    <?= esc($announcement['category']) ?>
                                </div>

                                <div class="home-announcement-title">

                                    <?php if (
                                        $announcement['type'] === '純檔案'
                                        && !empty($announcement['attachment'])
                                    ): ?>

                                        <a
                                            href="<?= base_url($announcement['attachment']) ?>"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >
                                            <?= esc($announcement['title']) ?>
                                        </a>

                                    <?php elseif (
                                        $announcement['type'] === '超連結'
                                        && !empty($announcement['external_url'])
                                    ): ?>

                                        <a
                                            href="<?= esc($announcement['external_url']) ?>"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >
                                            <?= esc($announcement['title']) ?>
                                        </a>

                                    <?php else: ?>

                                        <a
                                            href="<?= site_url('announcement/' . $announcement['id']) ?>"
                                        >
                                            <?= esc($announcement['title']) ?>
                                        </a>

                                    <?php endif; ?>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>

            </div>

        </div>
    </main>
    <script src="<?= base_url('JS/sidebar.js') ?>"></script>
</body>
</html>