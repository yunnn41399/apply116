<!DOCTYPE html>
<html lang="zh-Hant">

    <head>
        <meta charset="UTF-8">
        <title>報名資料</title>

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
        
        <h1>報名資料</h1>

        <p>
            <a href="<?= site_url('admin') ?>">返回後臺首頁</a>
        </p>


        <!-- 搜尋 -->
        <form method="get" action="<?= site_url('admin/applications') ?>">

            <label for="keyword">搜尋報名資料：</label>

            <input
                type="text"
                id="keyword"
                name="keyword"
                value="<?= esc($keyword ?? '') ?>"
                placeholder="姓名、學測應試號碼或身分證字號"
            >

            <button type="submit">搜尋</button>

            <?php if (!empty($keyword)): ?>

                <a href="<?= site_url('admin/applications') ?>">
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


        <?php if (empty($applications)): ?>

            <p>目前沒有符合條件的報名資料。</p>

        <?php else: ?>

            <table border="1" cellpadding="8" cellspacing="0">

                <thead>

                    <tr>

                        <!-- 編號 -->
                        <th>
                            <a href="<?= site_url(
                                'admin/applications?sort=id&direction=' .
                                (($sort === 'id' && $direction === 'DESC')
                                    ? 'ASC'
                                    : 'DESC') .
                                (!empty($keyword)
                                    ? '&keyword=' . urlencode($keyword)
                                    : '')
                            ) ?>">
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
                            <a href="<?= site_url(
                                'admin/applications?sort=name&direction=' .
                                (($sort === 'name' && $direction === 'DESC')
                                    ? 'ASC'
                                    : 'DESC') .
                                (!empty($keyword)
                                    ? '&keyword=' . urlencode($keyword)
                                    : '')
                            ) ?>">
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
                            <a href="<?= site_url(
                                'admin/applications?sort=exam_number&direction=' .
                                (($sort === 'exam_number' && $direction === 'DESC')
                                    ? 'ASC'
                                    : 'DESC') .
                                (!empty($keyword)
                                    ? '&keyword=' . urlencode($keyword)
                                    : '')
                            ) ?>">
                                學測應試號碼

                                <?php if ($sort === 'exam_number'): ?>
                                    <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                <?php else: ?>
                                    ⮃
                                <?php endif; ?>

                            </a>
                        </th>

                        <!-- 出生年月日 -->
                        <th>
                            <a href="<?= site_url(
                                'admin/applications?sort=birth_date&direction=' .
                                (($sort === 'birth_date' && $direction === 'DESC')
                                    ? 'ASC'
                                    : 'DESC') .
                                (!empty($keyword)
                                    ? '&keyword=' . urlencode($keyword)
                                    : '')
                            ) ?>">
                                出生年月日

                                <?php if ($sort === 'birth_date'): ?>
                                    <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                <?php else: ?>
                                    ⮃
                                <?php endif; ?>

                            </a>
                        </th>


                        <!-- 建立時間 -->
                        <th>
                            <a href="<?= site_url(
                                'admin/applications?sort=created_at&direction=' .
                                (($sort === 'created_at' && $direction === 'DESC')
                                    ? 'ASC'
                                    : 'DESC') .
                                (!empty($keyword)
                                    ? '&keyword=' . urlencode($keyword)
                                    : '')
                            ) ?>">
                                建立時間

                                <?php if ($sort === 'created_at'): ?>
                                    <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                <?php else: ?>
                                    ⮃
                                <?php endif; ?>

                            </a>
                        </th>


                        <!-- 操作 -->
                        <th>
                            操作
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <?php foreach ($applications as $application): ?>

                        <tr>

                            <td>
                                <?= esc($application['id']) ?>
                            </td>

                            <td>
                                <?= esc($application['name']) ?>
                            </td>

                            <td>
                                <?= esc($application['exam_number']) ?>
                            </td>

                            <td>
                                <?= esc($application['birth_date']) ?>
                            </td>

                            <td>
                                <?= esc($application['created_at'] ?? '') ?>
                            </td>

                            <td>
                                <a href="<?= site_url(
                                    'admin/application/' . $application['id']
                                ) ?>">
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

                        <a href="<?= $pager->getPageURI($currentPage - 1) ?>">
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

                            <a href="<?= $pager->getPageURI($page) ?>">
                                <?= $page ?>
                            </a>

                        <?php endif; ?>

                    <?php endforeach; ?>


                    <!-- 下一頁 -->

                    <?php if ($currentPage < $totalPages): ?>

                        <a href="<?= $pager->getPageURI($currentPage + 1) ?>">
                            &gt;
                        </a>

                    <?php endif; ?>

                </div>

            <?php endif; ?>


        <?php endif; ?>

    </body>

</html>