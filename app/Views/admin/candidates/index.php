<!DOCTYPE html>
<html lang="zh-Hant">
    <head>
        <meta charset="UTF-8">
        <title>考生資料</title>

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
            
        <h1>考生資料</h1>

        <!-- 搜尋區域 -->
        <form method="get" action="<?= site_url('admin/candidates') ?>">

            <label for="keyword">搜尋考生：</label>

            <input
                type="text"
                id="keyword"
                name="keyword"
                value="<?= esc($keyword ?? '') ?>"
                placeholder="姓名、學測應試號碼或身分證字號"
            >

            <button type="submit">搜尋</button>

            <?php if (!empty($keyword)): ?>

                <a href="<?= site_url('admin/candidates') ?>">
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


        <?php if (empty($candidates)): ?>

            <p>找不到符合條件的考生資料。</p>

        <?php else: ?>

            <table border="1" cellpadding="8" cellspacing="0">

                <thead>
                    <tr>

                        <!-- 編號 -->
                        <th>
                            <a href="<?= site_url('admin/candidates?keyword=' . urlencode($keyword ?? '') . '&sort=id&direction=' . (($sort === 'id' && $direction === 'DESC') ? 'ASC' : 'DESC')) ?>">
                                編號

                                <?php if ($sort === 'id'): ?>

                                    <?= $direction === 'ASC' ? '▲' : '▼' ?>

                                <?php else: ?>

                                    ⮃

                                <?php endif; ?>

                            </a>
                        </th>


                        <!-- 考生姓名 -->
                        <th>
                            <a href="<?= site_url('admin/candidates?keyword=' . urlencode($keyword ?? '') . '&sort=name&direction=' . (($sort === 'name' && $direction === 'DESC') ? 'ASC' : 'DESC')) ?>">
                                考生姓名

                                <?php if ($sort === 'name'): ?>

                                    <?= $direction === 'ASC' ? '▲' : '▼' ?>

                                <?php else: ?>

                                    ⮃

                                <?php endif; ?>

                            </a>
                        </th>


                        <!-- 學測應試號碼 -->
                        <th>
                            <a href="<?= site_url('admin/candidates?keyword=' . urlencode($keyword ?? '') . '&sort=exam_number&direction=' . (($sort === 'exam_number' && $direction === 'DESC') ? 'ASC' : 'DESC')) ?>">
                                學測應試號碼

                                <?php if ($sort === 'exam_number'): ?>

                                    <?= $direction === 'ASC' ? '▲' : '▼' ?>

                                <?php else: ?>

                                    ⮃

                                <?php endif; ?>

                            </a>
                        </th>


                        <!-- 身分證字號 -->
                        <th>
                            <a href="<?= site_url('admin/candidates?keyword=' . urlencode($keyword ?? '') . '&sort=id_number&direction=' . (($sort === 'id_number' && $direction === 'DESC') ? 'ASC' : 'DESC')) ?>">
                                身分證字號

                                <?php if ($sort === 'id_number'): ?>

                                    <?= $direction === 'ASC' ? '▲' : '▼' ?>

                                <?php else: ?>

                                    ⮃

                                <?php endif; ?>

                            </a>
                        </th>


                        <!-- 註冊時間 -->
                        <th>
                            <a href="<?= site_url('admin/candidates?keyword=' . urlencode($keyword ?? '') . '&sort=created_at&direction=' . (($sort === 'created_at' && $direction === 'DESC') ? 'ASC' : 'DESC')) ?>">
                                註冊時間

                                <?php if ($sort === 'created_at'): ?>

                                    <?= $direction === 'ASC' ? '▲' : '▼' ?>

                                <?php else: ?>

                                    ⮃

                                <?php endif; ?>

                            </a>
                        </th>

                        <th>操作</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($candidates as $candidate): ?>

                        <tr>

                            <td>
                                <?= esc($candidate['id']) ?>
                            </td>

                            <td>
                                <?= esc($candidate['name']) ?>
                            </td>

                            <td>
                                <?= esc($candidate['exam_number']) ?>
                            </td>

                            <?php
                                $idNumber = $candidate['id_number'] ?? '';

                                if (strlen($idNumber) === 10) {
                                    $maskedIdNumber =
                                        substr($idNumber, 0, 5) .
                                        '****' .
                                        substr($idNumber, 9, 1);
                                } else {
                                    $maskedIdNumber = $idNumber;
                                }
                                ?>

                            <td>
                                <?= esc($maskedIdNumber) ?>
                            </td>

                            <td>
                                <?= esc($candidate['created_at'] ?? '') ?>
                            </td>

                            <td>
                                <a href="<?= site_url('admin/candidates/' . $candidate['id']) ?>">
                                    查看
                                </a>
                            </td>
                        </tr>

                    <?php endforeach; ?>

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
                            'admin/candidates?keyword=' . urlencode($keyword ?? '') .
                            '&sort=' . urlencode($sort) .
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

                        for ($i = $totalPages - 4; $i <= $totalPages; $i++) {
                            $pages[] = $i;
                        }

                    } else {

                        $pages[] = 1;
                        $pages[] = '...';

                        for ($i = $currentPage - 1; $i <= $currentPage + 1; $i++) {
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
                                'admin/candidates?keyword=' . urlencode($keyword ?? '') .
                                '&sort=' . urlencode($sort) .
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
                            'admin/candidates?keyword=' . urlencode($keyword ?? '') .
                            '&sort=' . urlencode($sort) .
                            '&direction=' . urlencode($direction) .
                            '&page=' . ($currentPage + 1)
                        ) ?>">
                            &gt;
                        </a>

                    <?php endif; ?>

                </div>

            <?php endif; ?>

        <?php endif; ?>

    </body>
</html>