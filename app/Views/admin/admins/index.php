<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <title>管理員帳號管理</title>

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

    <h1>管理員帳號管理</h1>


    <?php if (session()->has('success')): ?>

        <p>
            <?= esc(session('success')) ?>
        </p>

    <?php endif; ?>


    <?php if (session()->has('error')): ?>

        <p>
            <?= esc(session('error')) ?>
        </p>

    <?php endif; ?>


    <!-- 功能 -->
    <p>
        <a href="<?= site_url('admin/admins/create') ?>">
            新增管理員
        </a>

        |

        <a href="<?= site_url('admin/logs') ?>">
            查看操作紀錄
        </a>
    </p>


    <hr>


    <!-- ========================= -->
    <!-- 搜尋 -->
    <!-- ========================= -->

    <form method="get" action="<?= site_url('admin/admins') ?>">

        <label for="keyword">
            搜尋管理員：
        </label>

        <input
            type="text"
            id="keyword"
            name="keyword"
            value="<?= esc($keyword ?? '') ?>"
            placeholder="管理員帳號或姓名"
        >

        <button type="submit">
            搜尋
        </button>


        <?php if (!empty($keyword)): ?>

            <a href="<?= site_url('admin/admins') ?>">
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


    <!-- ========================= -->
    <!-- 管理員列表 -->
    <!-- ========================= -->

    <?php if (empty($admins)): ?>

        <p>
            找不到符合條件的管理員資料。
        </p>

    <?php else: ?>

        <table border="1" cellpadding="8" cellspacing="0">

            <thead>

                <tr>

                    <!-- 編號 -->
                    <th>
                        <a href="<?= site_url(
                            'admin/admins?keyword=' . urlencode($keyword ?? '') .
                            '&sort=id&direction=' .
                            (($sort === 'id' && $direction === 'DESC') ? 'ASC' : 'DESC')
                        ) ?>">

                            編號

                            <?php if ($sort === 'id'): ?>

                                <?= $direction === 'ASC' ? '▲' : '▼' ?>

                            <?php else: ?>

                                ⮃

                            <?php endif; ?>

                        </a>
                    </th>


                    <!-- 管理員帳號 -->
                    <th>
                        <a href="<?= site_url(
                            'admin/admins?keyword=' . urlencode($keyword ?? '') .
                            '&sort=username&direction=' .
                            (($sort === 'username' && $direction === 'DESC') ? 'ASC' : 'DESC')
                        ) ?>">

                            管理員帳號

                            <?php if ($sort === 'username'): ?>

                                <?= $direction === 'ASC' ? '▲' : '▼' ?>

                            <?php else: ?>

                                ⮃

                            <?php endif; ?>

                        </a>
                    </th>


                    <!-- 姓名 -->
                    <th>
                        <a href="<?= site_url(
                            'admin/admins?keyword=' . urlencode($keyword ?? '') .
                            '&sort=name&direction=' .
                            (($sort === 'name' && $direction === 'DESC') ? 'ASC' : 'DESC')
                        ) ?>">

                            姓名

                            <?php if ($sort === 'name'): ?>

                                <?= $direction === 'ASC' ? '▲' : '▼' ?>

                            <?php else: ?>

                                ⮃

                            <?php endif; ?>

                        </a>
                    </th>


                    <!-- 角色 -->
                    <th>
                        <a href="<?= site_url(
                            'admin/admins?keyword=' . urlencode($keyword ?? '') .
                            '&sort=role&direction=' .
                            (($sort === 'role' && $direction === 'DESC') ? 'ASC' : 'DESC')
                        ) ?>">

                            角色

                            <?php if ($sort === 'role'): ?>

                                <?= $direction === 'ASC' ? '▲' : '▼' ?>

                            <?php else: ?>

                                ⮃

                            <?php endif; ?>

                        </a>
                    </th>


                    <!-- 狀態 -->
                    <th>
                        <a href="<?= site_url(
                            'admin/admins?keyword=' . urlencode($keyword ?? '') .
                            '&sort=status&direction=' .
                            (($sort === 'status' && $direction === 'DESC') ? 'ASC' : 'DESC')
                        ) ?>">

                            狀態

                            <?php if ($sort === 'status'): ?>

                                <?= $direction === 'ASC' ? '▲' : '▼' ?>

                            <?php else: ?>

                                ⮃

                            <?php endif; ?>

                        </a>
                    </th>


                    <!-- 建立時間 -->
                    <th>
                        <a href="<?= site_url(
                            'admin/admins?keyword=' . urlencode($keyword ?? '') .
                            '&sort=created_at&direction=' .
                            (($sort === 'created_at' && $direction === 'DESC') ? 'ASC' : 'DESC')
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

                <?php foreach ($admins as $admin): ?>

                    <?php

                    // 角色中文名稱
                    $roleName = match ($admin['role']) {
                        'super_admin' => '最高管理員',
                        'admin'       => '一般管理員',
                        default       => '未知角色',
                    };

                    // 狀態中文名稱
                    $statusName = match ($admin['status']) {
                        'active'   => '啟用',
                        'inactive' => '停用',
                        default    => '未知狀態',
                    };

                    ?>

                    <tr>

                        <td>
                            <?= esc($admin['id']) ?>
                        </td>

                        <td>
                            <?= esc($admin['username']) ?>
                        </td>

                        <td>
                            <?= esc($admin['name']) ?>
                        </td>

                        <td>
                            <?= esc($roleName) ?>
                        </td>

                        <td>
                            <?= esc($statusName) ?>
                        </td>

                        <td>
                            <?= esc($admin['created_at'] ?? '') ?>
                        </td>

                        <td>
                            <a href="<?= site_url(
                                'admin/admins/edit/' . $admin['id']
                            ) ?>">
                                編輯
                            </a>
                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>


        <!-- ========================= -->
        <!-- 分頁 -->
        <!-- ========================= -->

        <?php

        $currentPage = $pager->getCurrentPage();
        $totalPages = $pager->getPageCount();

        ?>

        <?php if ($totalPages > 1): ?>

            <div class="pagination">

                <!-- 上一頁 -->
                <?php if ($currentPage > 1): ?>

                    <a href="<?= site_url(
                        'admin/admins?keyword=' . urlencode($keyword ?? '') .
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


                <!-- 頁碼 -->
                <?php foreach ($pages as $page): ?>

                    <?php if ($page === '...'): ?>

                        <span>
                            ...
                        </span>

                    <?php elseif ($page == $currentPage): ?>

                        <span class="active">
                            <?= $page ?>
                        </span>

                    <?php else: ?>

                        <a href="<?= site_url(
                            'admin/admins?keyword=' . urlencode($keyword ?? '') .
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
                        'admin/admins?keyword=' . urlencode($keyword ?? '') .
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