<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title><?= esc($announcement['title']) ?></title>
</head>
<body>

<h1><?= esc($announcement['title']) ?></h1>

<p>
    類別：
    <?= esc($announcement['category']) ?>
</p>

<p>
    發布日期：
    <?= esc($announcement['publish_date'] ?? '') ?>
</p>

<hr>

<div>
    <?= nl2br(esc($announcement['content'] ?? '')) ?>
</div>

<hr>

<a href="<?= base_url('announcement') ?>">
    返回公告列表
</a>

</body>
</html>