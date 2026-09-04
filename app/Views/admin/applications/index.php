<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/apply.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/admin.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>報名資料 - 後臺管理系統</title>
</head>

<body>

    <!-- 頂部導覽列 -->
    <?php include APPPATH . 'Views/admin/header.php'; ?>

    <!-- 主要內容區 -->
    <main class="apply-container">
        <section class="apply-content-card" style="padding: 2rem;">

            <!-- 頁面標題列 -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 2px solid #ddd6fe; padding-bottom: 0.75rem;">
                <h2 class="section-title" style="border: none; margin: 0; padding: 0;">
                    <i class="bi bi-file-earmark-text-fill"></i> 報名資料
                </h2>
            </div>

            <?php
                $currentPage = $pager->getCurrentPage();
                $totalPages = $pager->getPageCount();
                $totalItems = $pager->getTotal();
            ?>

            <!-- 搜尋區域 -->
            <form method="get" action="<?= site_url('admin/applications') ?>" style="display: flex; gap: 0.5rem; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap;">
                <div style="position: relative; flex: 1; max-width: 350px;">
                    <i class="bi bi-search" style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: #8b5cf6;"></i>
                    <input
                        type="text"
                        id="keyword"
                        name="keyword"
                        value="<?= esc($keyword ?? '') ?>"
                        placeholder="姓名、學測應試號碼或身分證字號"
                        style="width: 100%; padding: 0.5rem 0.75rem 0.5rem 2.25rem; border: 1px solid #ddd6fe; border-radius: 0.375rem; outline: none; font-size: 0.95rem;"
                    >
                </div>

                <button type="submit" class="primary-button" style="padding: 0.5rem 1rem; font-size: 0.95rem;">
                    搜尋
                </button>

                <?php if (!empty($keyword)): ?>
                    <a href="<?= site_url('admin/applications') ?>" class="secondary-button" style="text-decoration: none; padding: 0.5rem 0.8rem; font-size: 0.95rem;">
                        <i class="bi bi-x-circle"></i> 清除搜尋
                    </a>
                <?php endif; ?>

                <div style="color: #6b5b95; font-size: 0.9rem; margin-left: auto;">
                    第 <strong><?= $currentPage ?></strong> /
                    <strong><?= $totalPages ?></strong> 頁
                    ｜ 共 <strong><?= $totalItems ?></strong> 筆資料
                </div>

            </form>

            <!-- 搜尋提示文字 -->
            <?php if (!empty($keyword)): ?>
                <div style="margin-bottom: 1rem; font-size: 0.9rem; color: #6b5b95;">
                    <i class="bi bi-info-circle"></i> 搜尋關鍵字：<strong><?= esc($keyword) ?></strong>
                </div>
            <?php endif; ?>

            <!-- 報名資料表格 -->
            <?php if (empty($applications)): ?>
                <div style="text-align: center; color: #6b5b95; padding: 3rem; background-color: #fcfaff; border-radius: 0.5rem; border: 1px dashed #ddd6fe;">
                    <i class="bi bi-search-heart" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
                    目前沒有符合條件的報名資料。
                </div>
            <?php else: ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 8%;">
                                <a href="<?= site_url('admin/applications?sort=id&direction=' . (($sort === 'id' && $direction === 'DESC') ? 'ASC' : 'DESC') . (!empty($keyword) ? '&keyword=' . urlencode($keyword) : '')) ?>" style="color: inherit; text-decoration: none;">
                                    編號
                                    <?php if ($sort === 'id'): ?>
                                        <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                    <?php else: ?>
                                        <i class="bi bi-arrow-down-up" style="opacity: 0.4;"></i>
                                    <?php endif; ?>
                                </a>
                            </th>

                            <th style="width: 17%;">
                                <a href="<?= site_url('admin/applications?sort=name&direction=' . (($sort === 'name' && $direction === 'DESC') ? 'ASC' : 'DESC') . (!empty($keyword) ? '&keyword=' . urlencode($keyword) : '')) ?>" style="color: inherit; text-decoration: none;">
                                    考生姓名
                                    <?php if ($sort === 'name'): ?>
                                        <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                    <?php else: ?>
                                        <i class="bi bi-arrow-down-up" style="opacity: 0.4;"></i>
                                    <?php endif; ?>
                                </a>
                            </th>

                            <th style="width: 15%;">
                                <a href="<?= site_url('admin/applications?sort=exam_number&direction=' . (($sort === 'exam_number' && $direction === 'DESC') ? 'ASC' : 'DESC') . (!empty($keyword) ? '&keyword=' . urlencode($keyword) : '')) ?>" style="color: inherit; text-decoration: none;">
                                    學測應試號碼
                                    <?php if ($sort === 'exam_number'): ?>
                                        <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                    <?php else: ?>
                                        <i class="bi bi-arrow-down-up" style="opacity: 0.4;"></i>
                                    <?php endif; ?>
                                </a>
                            </th>

                            <th style="width: 15%;">
                                <a href="<?= site_url('admin/applications?sort=dept_count&direction=' . (($sort === 'dept_count' && $direction === 'DESC') ? 'ASC' : 'DESC') . (!empty($keyword) ? '&keyword=' . urlencode($keyword) : '')) ?>" style="color: inherit; text-decoration: none;">
                                    志願選填狀態
                                    <?php if ($sort === 'dept_count'): ?>
                                        <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                    <?php else: ?>
                                        <i class="bi bi-arrow-down-up" style="opacity: 0.4;"></i>
                                    <?php endif; ?>
                                </a>
                            </th>

                            <th style="width: 18%;">
                                <a href="<?= site_url('admin/applications?sort=created_at&direction=' . (($sort === 'created_at' && $direction === 'DESC') ? 'ASC' : 'DESC') . (!empty($keyword) ? '&keyword=' . urlencode($keyword) : '')) ?>" style="color: inherit; text-decoration: none;">
                                    建立時間
                                    <?php if ($sort === 'created_at'): ?>
                                        <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                    <?php else: ?>
                                        <i class="bi bi-arrow-down-up" style="opacity: 0.4;"></i>
                                    <?php endif; ?>
                                </a>
                            </th>

                            <th style="width: 18%;">
                                <a href="<?= site_url('admin/applications?sort=updated_at&direction=' . (($sort === 'updated_at' && $direction === 'DESC') ? 'ASC' : 'DESC') . (!empty($keyword) ? '&keyword=' . urlencode($keyword) : '')) ?>" style="color: inherit; text-decoration: none;">
                                    最後更新
                                    <?php if ($sort === 'updated_at'): ?>
                                        <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                    <?php else: ?>
                                        <i class="bi bi-arrow-down-up" style="opacity: 0.4;"></i>
                                    <?php endif; ?>
                                </a>
                            </th>

                            <th style="width: 9%;">操作</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($applications as $application): ?>
                            <tr>
                                <td title="<?= esc($application['id']) ?>">
                                    <strong><?= esc($application['id']) ?></strong>
                                </td>
                                <td title="<?= esc($application['name']) ?>">
                                    <strong><?= esc($application['name']) ?></strong>
                                </td>
                                <td title="<?= esc($application['exam_number']) ?>">
                                    <?= esc($application['exam_number']) ?>
                                </td>

                                <td>
                                    <?php if (!empty($application['dept_count']) && $application['dept_count'] > 0): ?>
                                        <span style="color: #16835a; font-weight: bold;">
                                            <i class="bi bi-check-circle-fill"></i> 已選填 (<?= $application['dept_count'] ?> 校)
                                        </span>
                                    <?php else: ?>
                                        <span style="color: #d64545; font-weight: bold;">
                                            <i class="bi bi-x-circle-fill"></i> 未選填
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td title="<?= esc($application['created_at'] ?? '') ?>">
                                    <?= esc($application['created_at'] ?? '') ?>
                                </td>
                                <td title="<?= esc($application['updated_at'] ?? '') ?>">
                                    <?= esc($application['updated_at'] ?? '') ?>
                                </td>
                                <td>
                                    <a href="<?= site_url('admin/applications/' . $application['id']) ?>" class="secondary-button" style="text-decoration: none; padding: 0.25rem 0.6rem; font-size: 0.875rem; display: inline-block;">
                                        <i class="bi bi-eye"></i> 查看
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- 分頁列 -->
                <?php
                    $queryParams = [
                        'keyword' => $keyword,
                        'sort' => $sort,
                        'direction' => $direction,
                    ];

                    $queryString = http_build_query(
                        array_filter(
                            $queryParams,
                            fn ($value) => $value !== null && $value !== ''
                        )
                    );
                ?>

                <?php if ($totalPages > 1): ?>

                    <div class="admin-pagination">

                        <!-- 上一頁 -->
                        <?php if ($currentPage > 1): ?>
                            <a href="<?= $pager->getPageURI($currentPage - 1) . ($queryString ? '&' . $queryString : '') ?>">
                                &lt;
                            </a>
                        <?php endif; ?>

                        <?php
                        $pages = [];
                        if ($totalPages <= 7) {
                            for ($i = 1; $i <= $totalPages; $i++) { $pages[] = $i; }
                        } elseif ($currentPage <= 5) {
                            for ($i = 1; $i <= 5; $i++) { $pages[] = $i; }
                            $pages[] = '...';
                            $pages[] = $totalPages;
                        } elseif ($currentPage >= $totalPages - 4) {
                            $pages[] = 1;
                            $pages[] = '...';
                            for ($i = $totalPages - 4; $i <= $totalPages; $i++) { $pages[] = $i; }
                        } else {
                            $pages[] = 1;
                            $pages[] = '...';
                            for ($i = $currentPage - 1; $i <= $currentPage + 1; $i++) { $pages[] = $i; }
                            $pages[] = '...';
                            $pages[] = $totalPages;
                        }
                        ?>

                        <?php foreach ($pages as $page): ?>
                            <?php if ($page === '...'): ?>
                                <span style="border: none; background: transparent;">...</span>
                            <?php elseif ($page == $currentPage): ?>
                                <span class="active"><?= $page ?></span>
                            <?php else: ?>
                                <a href="<?= $pager->getPageURI($page) . ($queryString ? '&' . $queryString : '') ?>">
                                    <?= $page ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <!-- 下一頁 -->
                        <?php if ($currentPage < $totalPages): ?>
                            <a href="<?= $pager->getPageURI($currentPage + 1) . ($queryString ? '&' . $queryString : '') ?>">
                                &gt;
                            </a>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>

            <?php endif; ?>

        </section>
    </main>

    <footer class="apply-footer" style="margin-top: 2rem;">
        Apply116 後臺管理系統
    </footer>

</body>
</html>