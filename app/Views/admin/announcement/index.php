<!DOCTYPE html>
<html lang="zh-Hant">
    <head>
        <meta charset="UTF-8">
        <title>後臺公告管理</title>

        <style>
            .pagination {
                display: flex;
                gap: 8px;
                align-items: center;
                margin-top: 20px;
            }

            .pagination a,
            .pagination span {
                padding: 4px 8px;
                text-decoration: none;
            }

            .pagination .active {
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        
        <?php include APPPATH . 'Views/admin/header.php'; ?>

        <h1>公告管理</h1>

        <!-- 新增公告按鈕 -->
        <p>
            <a href="<?= site_url('admin/announcement/create') ?>">新增公告</a>
        </p>

        <?php if (session()->has('success')): ?>
            <div style="color: green;">
                <?= esc(session('success')) ?>
            </div>
        <?php endif; ?>

        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>

                    <!-- 編號 -->
                    <th>
                        <a href="<?= site_url('admin/announcement?sort=id&direction=' . (($sort === 'id' && $direction === 'DESC') ? 'ASC' : 'DESC')) ?>">
                            編號
                            <?php if ($sort === 'id'): ?>
                                <?= $direction === 'ASC' ? '▲' : '▼' ?>
                            <?php else: ?>
                                ⮃
                            <?php endif; ?>
                        </a>
                    </th>

                    <!-- 公告標題 -->
                    <th>
                        <a href="<?= site_url('admin/announcement?sort=title&direction=' . (($sort === 'title' && $direction === 'DESC') ? 'ASC' : 'DESC')) ?>">
                            公告標題
                            <?php if ($sort === 'title'): ?>
                                <?= $direction === 'ASC' ? '▲' : '▼' ?>
                            <?php else: ?>
                                ⮃
                            <?php endif; ?>
                        </a>
                    </th>

                    <!-- 最後編輯時間 -->
                    <th>
                        <a href="<?= site_url('admin/announcement?sort=updated_at&direction=' . (($sort === 'updated_at' && $direction === 'DESC') ? 'ASC' : 'DESC')) ?>">
                            最後編輯時間
                            <?php if ($sort === 'updated_at'): ?>
                                <?= $direction === 'ASC' ? '▲' : '▼' ?>
                            <?php else: ?>
                                ⮃
                            <?php endif; ?>
                        </a>
                    </th>

                    <!-- 發佈時間 -->
                    <th>
                        <a href="<?= site_url('admin/announcement?sort=publish_date&direction=' . (($sort === 'publish_date' && $direction === 'DESC') ? 'ASC' : 'DESC')) ?>">
                            發佈時間
                            <?php if ($sort === 'publish_date'): ?>
                                <?= $direction === 'ASC' ? '▲' : '▼' ?>
                            <?php else: ?>
                                ⮃
                            <?php endif; ?>
                        </a>
                    </th>

                    <!-- 發佈狀態 -->
                    <th>
                        <a href="<?= site_url('admin/announcement?sort=status&direction=' . (($sort === 'status' && $direction === 'DESC') ? 'ASC' : 'DESC')) ?>">
                            發佈狀態
                            <?php if ($sort === 'status'): ?>
                                <?= $direction === 'ASC' ? '▲' : '▼' ?>
                            <?php else: ?>
                                ⮃
                            <?php endif; ?>
                        </a>
                    </th>

                    <!-- 操作 -->
                    <th>操作</th>

                </tr>
            </thead>

            <tbody>
                <?php if (empty($announcements)): ?>
                    <tr>
                        <td colspan="6">目前沒有公告。</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($announcements as $announcement): ?>
                        <tr>
                            <td><?= esc($announcement['id']) ?></td>
                            <td><?= esc($announcement['title']) ?></td>
                            <td><?= esc($announcement['updated_at'] ?? '') ?></td>
                            <td><?= esc($announcement['publish_date'] ?? '') ?></td>
                            <td>
                                <?= $announcement['status'] === 'published' ? '已發布' : '草稿' ?>
                            </td>
                            <td>
                                <!-- 編輯按鈕 -->
                                <a href="<?= site_url('admin/announcement/edit/' . $announcement['id']) ?>">
                                    編輯
                                </a>
                                
                                |

                                <!-- 刪除表單 -->
                                <form action="<?= site_url('admin/announcement/delete/' . $announcement['id']) ?>" 
                                    method="post" 
                                    style="display: inline;" 
                                    onsubmit="return confirm('確定要刪除這筆公告嗎？刪除後將無法復原！');">
                                    
                                    <?= csrf_field() ?>
                                    <button type="submit" style="color: red; background: none; border: none; padding: 0; cursor: pointer; text-decoration: underline;">
                                        刪除
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- 分頁 -->
        <?php
            $currentPage = $pager->getCurrentPage();
            $totalPages = $pager->getPageCount();
        ?>

        <?php if ($totalPages > 1): ?>

            <div class="pagination">

                <!-- 上一頁 -->
                <?php if ($currentPage > 1): ?>

                    <a href="<?= site_url(
                        'admin/announcement?sort=' . urlencode($sort) .
                        '&direction=' . urlencode($direction) .
                        '&page=' . ($currentPage - 1)
                    ) ?>">
                        &lt;
                    </a>

                <?php endif; ?>


                <?php

                $pages = [];

                if ($totalPages <= 7) {

                    for ($i = 1; $i <= $totalPages; $i++) {
                        $pages[] = $i;
                    }

                } elseif ($currentPage <= 5) {

                    for ($i = 1; $i <= 5; $i++) {
                        $pages[] = $i;
                    }

                    $pages[] = '...';
                    $pages[] = $totalPages;

                } elseif ($currentPage >= $totalPages - 4) {

                    $pages[] = 1;
                    $pages[] = '...';

                    for (
                        $i = $totalPages - 4;
                        $i <= $totalPages;
                        $i++
                    ) {
                        $pages[] = $i;
                    }

                } else {

                    $pages[] = 1;
                    $pages[] = '...';

                    for (
                        $i = $currentPage - 1;
                        $i <= $currentPage + 1;
                        $i++
                    ) {
                        $pages[] = $i;
                    }

                    $pages[] = '...';
                    $pages[] = $totalPages;
                }

                ?>


                <?php foreach ($pages as $page): ?>

                    <?php if ($page === '...'): ?>

                        <span>...</span>

                    <?php elseif ($page == $currentPage): ?>

                        <span class="active">
                            <?= $page ?>
                        </span>

                    <?php else: ?>

                        <a href="<?= site_url(
                            'admin/announcement?sort=' . urlencode($sort) .
                            '&direction=' . urlencode($direction) .
                            '&page=' . $page
                        ) ?>">
                            <?= $page ?>
                        </a>

                    <?php endif; ?>

                <?php endforeach; ?>


                <!-- 下一頁 -->
                <?php if ($currentPage < $totalPages): ?>

                    <a href="<?= site_url(
                        'admin/announcement?sort=' . urlencode($sort) .
                        '&direction=' . urlencode($direction) .
                        '&page=' . ($currentPage + 1)
                    ) ?>">
                        &gt;
                    </a>

                <?php endif; ?>

            </div>

        <?php endif; ?>

    </body>
</html>