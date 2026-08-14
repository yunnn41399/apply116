<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>公告列表</title>
</head>
<body>

<h1>公告列表</h1>

<?php if (empty($announcements)): ?>
    <p>目前沒有公告。</p>
<?php else: ?>

    <?php foreach ($announcements as $announcement): ?>

        <div>
            <h2>
                <a href="<?= base_url('announcement/' . $announcement['id']) ?>">
                    <?= esc($announcement['title']) ?>
                </a>
            </h2>

            <p>
                類別：<?= esc($announcement['category']) ?>
            </p>

            <p>
                發布日期：<?= esc($announcement['publish_date'] ?? '') ?>
            </p>

            <p>
                狀態：<?= esc($announcement['status']) ?>
            </p>
        </div>

        <hr>

    <?php endforeach; ?>

<?php endif; ?>

</body>
</html>