<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title><?= esc($announcement['title']) ?></title>
</head>
<body>

<h1><?= esc($announcement['title']) ?></h1>

<p>類別：<?= esc($announcement['category']) ?></p>
<p>發布日期：<?= esc($announcement['publish_date'] ?? '') ?></p>

<hr>

<!-- 內文 -->
<div>
    <?= nl2br(esc($announcement['content'] ?? '')) ?>
</div>

<!-- 文末附件區塊 -->
<?php if (!empty($announcement['attachment'])): ?>
    <hr>
    <div>
        <h3>相關附件：</h3>
        <a href="<?= base_url($announcement['attachment']) ?>" target="_blank" download>
            點此下載/檢視附件
        </a>
    </div>
<?php endif; ?>

<hr>

<a href="<?= base_url('announcement') ?>">返回公告列表</a>

</body>
</html>