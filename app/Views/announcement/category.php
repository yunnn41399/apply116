<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($category) ?> - 訊息公告</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    >
</head>

<body>

<h1><?= esc($category) ?></h1>

<?php if (empty($announcements)): ?>

    <p>目前沒有此類別的公告。</p>

<?php else: ?>

    <ul style="list-style: none; padding-left: 0;">

        <?php foreach ($announcements as $announcement): ?>

            <li>

                <!-- 發布日期 -->
                <?= esc(
                    date(
                        'Y/m/d',
                        strtotime($announcement['publish_date'])
                    )
                ) ?>

                <!-- 公告標題 -->
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

                    <?php
                    $extension = strtolower(
                        pathinfo(
                            $announcement['attachment'],
                            PATHINFO_EXTENSION
                        )
                    );
                    ?>

                    <?php if ($extension === 'pdf'): ?>

                        <a
                            href="<?= base_url($announcement['attachment']) ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <i class="bi bi-file-earmark-pdf"></i>
                        </a>

                    <?php endif; ?>

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
                        href="<?= site_url(
                            'announcement/' . $announcement['id']
                        ) ?>"
                    >
                        <?= esc($announcement['title']) ?>
                    </a>

                <?php endif; ?>

            </li>

            <hr>

        <?php endforeach; ?>

    </ul>


    <!-- 分頁 -->

    <?php if ($pager->getPageCount() > 1): ?>

        <div style="margin-top: 20px;">

            <?php
            $currentPage = $pager->getCurrentPage();
            $totalPages  = $pager->getPageCount();
            ?>

            <?php if ($currentPage > 1): ?>

                <a href="<?= $pager->getPageURI($currentPage - 1) ?>">
                    &lt;
                </a>

                &nbsp;

            <?php endif; ?>


            <?php for ($page = 1; $page <= $totalPages; $page++): ?>

                <?php if ($page == $currentPage): ?>

                    <strong><?= $page ?></strong>

                <?php else: ?>

                    <a href="<?= $pager->getPageURI($page) ?>">
                        <?= $page ?>
                    </a>

                <?php endif; ?>

                <?php if ($page < $totalPages): ?>
                    &nbsp;
                <?php endif; ?>

            <?php endfor; ?>


            <?php if ($currentPage < $totalPages): ?>

                &nbsp;

                <a href="<?= $pager->getPageURI($currentPage + 1) ?>">
                    &gt;
                </a>

            <?php endif; ?>

        </div>

    <?php endif; ?>

<?php endif; ?>


<hr>

<a href="<?= base_url('/') ?>">
    返回首頁
</a>

</body>
</html>