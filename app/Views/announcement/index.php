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

            <ul style="list-style: none; padding-left: 0;">

                <?php foreach ($announcements as $announcement): ?>

                    <li>

                        <!-- 發布日期 -->
                        <?= esc(date('Y/m/d', strtotime($announcement['publish_date']))) ?>

                        <!-- 公告類別 -->
                        [<?= esc($announcement['category']) ?>]

                        <!-- 公告標題 -->
                        <?php if ($announcement['type'] === '純檔案' && !empty($announcement['attachment'])): ?>

                            <!-- 純檔案：直接開啟附件 -->
                            <a
                                href="<?= base_url($announcement['attachment']) ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <?= esc($announcement['title']) ?>
                            </a>

                        <?php elseif ($announcement['type'] === '超連結' && !empty($announcement['external_url'])): ?>

                            <!-- 超連結：直接開啟外部網址 -->
                            <a
                                href="<?= esc($announcement['external_url']) ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <?= esc($announcement['title']) ?>
                            </a>

                        <?php else: ?>

                            <!-- 一般公告：開啟公告詳細頁 -->
                            <a
                                href="<?= site_url('announcement/' . $announcement['id']) ?>"
                                target="_blank"
                                rel="noopener noreferrer"
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

                    <!-- 上一頁 -->
                    <?php if ($currentPage > 1): ?>
                        <a href="<?= $pager->getPageURI($currentPage - 1) ?>">
                            &lt;
                        </a>

                        &nbsp;
                    <?php endif; ?>

                    <?php if ($currentPage <= 5): ?>

                        <!-- 前五頁固定顯示 1～5 -->

                        <?php for ($page = 1; $page <= min(5, $totalPages); $page++): ?>

                            <?php if ($page == $currentPage): ?>

                                <strong><?= $page ?></strong>

                            <?php else: ?>

                                <a href="<?= $pager->getPageURI($page) ?>">
                                    <?= $page ?>
                                </a>

                            <?php endif; ?>

                            &nbsp;

                        <?php endfor; ?>


                        <?php if ($totalPages > 6): ?>

                            ..&nbsp;

                            <a href="<?= $pager->getPageURI($totalPages) ?>">
                                <?= $totalPages ?>
                            </a>

                        <?php elseif ($totalPages == 6): ?>

                            <a href="<?= $pager->getPageURI(6) ?>">
                                6
                            </a>

                        <?php endif; ?>


                    <?php elseif ($currentPage >= $totalPages - 4): ?>

                        <!-- 最後五頁 -->

                        <a href="<?= $pager->getPageURI(1) ?>">
                            1
                        </a>

                        &nbsp;..&nbsp;

                        <?php for (
                            $page = max(1, $totalPages - 4);
                            $page <= $totalPages;
                            $page++
                        ): ?>

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


                    <?php else: ?>

                        <!-- 中間頁 -->

                        <a href="<?= $pager->getPageURI(1) ?>">
                            1
                        </a>

                        &nbsp;..&nbsp;

                        <?php for (
                            $page = $currentPage - 2;
                            $page <= $currentPage + 2;
                            $page++
                        ): ?>

                            <?php if ($page == $currentPage): ?>

                                <strong><?= $page ?></strong>

                            <?php else: ?>

                                <a href="<?= $pager->getPageURI($page) ?>">
                                    <?= $page ?>
                                </a>

                            <?php endif; ?>

                            &nbsp;

                        <?php endfor; ?>

                        ..&nbsp;

                        <a href="<?= $pager->getPageURI($totalPages) ?>">
                            <?= $totalPages ?>
                        </a>

                    <?php endif; ?>


                    <!-- 下一頁 -->
                    <?php if ($currentPage < $totalPages): ?>

                        &nbsp;

                        <a href="<?= $pager->getPageURI($currentPage + 1) ?>">
                            &gt;
                        </a>

                    <?php endif; ?>

                </div>

            <?php endif; ?>

        <?php endif; ?>

    </body>
</html>