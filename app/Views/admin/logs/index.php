<!DOCTYPE html>
<html lang="zh-Hant">

    <head>
        <meta charset="UTF-8">
        <title>管理員操作紀錄</title>

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

        <h1>管理員操作紀錄</h1>

        <p>
            <a href="<?= site_url('admin') ?>">
                返回後臺首頁
            </a>
        </p>


        <!-- 搜尋 -->
        <form method="get" action="<?= site_url('admin/logs') ?>">

            <label for="keyword">搜尋操作紀錄：</label>

            <input
                type="text"
                id="keyword"
                name="keyword"
                value="<?= esc($keyword ?? '') ?>"
                placeholder="管理員帳號、姓名或操作內容"
            >

            <button type="submit">搜尋</button>

            <?php if (!empty($keyword)): ?>

                <a href="<?= site_url('admin/logs') ?>">
                    清除搜尋
                </a>

            <?php endif; ?>

        </form>

        <br>


        <?php if (!empty($keyword)): ?>

            <p>
                搜尋關鍵字：
                <strong><?= esc($keyword) ?></strong>
            </p>

        <?php endif; ?>


        <?php if (empty($logs)): ?>

            <p>目前沒有符合條件的操作紀錄。</p>

        <?php else: ?>

            <table border="1" cellpadding="8" cellspacing="0">

                <thead>

                    <tr>
                        <th>編號</th>
                        <th>管理員帳號</th>
                        <th>管理員姓名</th>
                        <th>操作</th>
                        <th>操作內容</th>
                        <th>操作時間</th>
                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($logs as $log): ?>

                        <tr>

                            <td>
                                <?= esc($log['id']) ?>
                            </td>

                            <td>
                                <?= esc($log['username'] ?? '未知管理員') ?>
                            </td>

                            <td>
                                <?= esc($log['admin_name'] ?? '') ?>
                            </td>

                            <td>
                                <?= esc($log['action']) ?>
                            </td>

                            <td>
                                <?= esc($log['description']) ?>
                            </td>

                            <td>
                                <?= esc($log['created_at'] ?? '') ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>


            <!-- 分頁 -->

            <?php
                $currentPage = $pager->getCurrentPage();
                $totalPages = $pager->getPageCount();

                $queryParams = [
                    'keyword' => $keyword,
                ];

                $queryString = http_build_query(
                    array_filter(
                        $queryParams,
                        fn ($value) => $value !== null && $value !== ''
                    )
                );
            ?>

            <?php if ($totalPages > 1): ?>

                <div class="pagination">

                    <!-- 上一頁 -->

                    <?php if ($currentPage > 1): ?>

                        <a href="<?= $pager->getPageURI($currentPage - 1) .
                            ($queryString ? '&' . $queryString : '') ?>">
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

                            <a href="<?= $pager->getPageURI($page) .
                                ($queryString ? '&' . $queryString : '') ?>">
                                <?= $page ?>
                            </a>

                        <?php endif; ?>

                    <?php endforeach; ?>


                    <!-- 下一頁 -->

                    <?php if ($currentPage < $totalPages): ?>

                        <a href="<?= $pager->getPageURI($currentPage + 1) .
                            ($queryString ? '&' . $queryString : '') ?>">
                            &gt;
                        </a>

                    <?php endif; ?>

                </div>

            <?php endif; ?>

        <?php endif; ?>

    </body>

</html>