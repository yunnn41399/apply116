<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/apply.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/admin.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>管理員操作紀錄 - 後臺管理系統</title>
</head>

<body>

    <!-- 頂部導覽列 -->
    <?php include APPPATH . 'Views/admin/header.php'; ?>

    <!-- 主要內容區 -->
    <main class="apply-container">
        <section class="apply-content-card" style="padding: 2rem;">

            <!-- 頁面標題列 -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 2px solid #ddd6fe; padding-bottom: 0.75rem;">
                <h2 class="section-title">
                    <i class="bi bi-journal-text"></i> 管理員操作紀錄
                </h2>
                <div>
                    <a href="<?= site_url('admin/admins') ?>" class="secondary-button" style="text-decoration: none; padding: 0.5rem 1rem; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 0.3rem;">
                        <i class="bi bi-arrow-left"></i> 返回帳號管理
                    </a>
                </div>
            </div>

            <!-- 搜尋區域 -->
            <form method="get" action="<?= site_url('admin/logs') ?>" style="display: flex; gap: 0.5rem; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap;">
                <div style="position: relative; flex: 1; max-width: 350px;">
                    <i class="bi bi-search" style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: #8b5cf6;"></i>
                    <input
                        type="text"
                        id="keyword"
                        name="keyword"
                        value="<?= esc($keyword ?? '') ?>"
                        placeholder="管理員帳號、姓名或操作內容"
                        style="width: 100%; padding: 0.5rem 0.75rem 0.5rem 2.25rem; border: 1px solid #ddd6fe; border-radius: 0.375rem; outline: none; font-size: 0.95rem;"
                    >
                </div>

                <button type="submit" class="primary-button" style="padding: 0.5rem 1rem; font-size: 0.95rem;">
                    搜尋
                </button>

                <?php if (!empty($keyword)): ?>
                    <a href="<?= site_url('admin/logs') ?>" class="secondary-button" style="text-decoration: none; padding: 0.5rem 0.8rem; font-size: 0.95rem;">
                        <i class="bi bi-x-circle"></i> 清除搜尋
                    </a>
                <?php endif; ?>
            </form>

            <!-- 搜尋提示文字 -->
            <?php if (!empty($keyword)): ?>
                <div style="margin-bottom: 1rem; font-size: 0.9rem; color: #6b5b95;">
                    <i class="bi bi-info-circle"></i> 搜尋關鍵字：<strong><?= esc($keyword) ?></strong>
                </div>
            <?php endif; ?>

            <!-- 操作紀錄列表表格 -->
            <?php if (empty($logs)): ?>
                <div style="text-align: center; color: #6b5b95; padding: 3rem; background-color: #fcfaff; border-radius: 0.5rem; border: 1px dashed #ddd6fe;">
                    <i class="bi bi-journal-x" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
                    目前沒有符合條件的操作紀錄。
                </div>
            <?php else: ?>
                <?php
                    $sort = $sort ?? 'id';
                    $direction = strtoupper($direction ?? 'DESC');

                    $getSortUrl = function($field) use ($keyword, $sort, $direction) {
                        $nextDir = ($sort === $field && $direction === 'DESC') ? 'ASC' : 'DESC';
                        return site_url('admin/logs') . '?' . http_build_query([
                            'keyword'   => $keyword ?? '',
                            'sort'      => $field,
                            'direction' => $nextDir
                        ]);
                    };
                ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 8%;">
                                <a href="<?= $getSortUrl('id') ?>" style="color: inherit; text-decoration: none;">
                                    編號
                                    <?php if ($sort === 'id'): ?>
                                        <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                    <?php else: ?>
                                        <i class="bi bi-arrow-down-up" style="opacity: 0.4;"></i>
                                    <?php endif; ?>
                                </a>
                            </th>

                            <th style="width: 12%;">
                                <a href="<?= $getSortUrl('username') ?>" style="color: inherit; text-decoration: none;">
                                    管理員帳號
                                    <?php if ($sort === 'username'): ?>
                                        <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                    <?php else: ?>
                                        <i class="bi bi-arrow-down-up" style="opacity: 0.4;"></i>
                                    <?php endif; ?>
                                </a>
                            </th>

                            <th style="width: 14%;">
                                <a href="<?= $getSortUrl('admin_name') ?>" style="color: inherit; text-decoration: none;">
                                    管理員姓名
                                    <?php if ($sort === 'admin_name'): ?>
                                        <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                    <?php else: ?>
                                        <i class="bi bi-arrow-down-up" style="opacity: 0.4;"></i>
                                    <?php endif; ?>
                                </a>
                            </th>

                            <th style="width: 17%;">
                                <a href="<?= $getSortUrl('action') ?>" style="color: inherit; text-decoration: none;">
                                    操作
                                    <?php if ($sort === 'action'): ?>
                                        <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                    <?php else: ?>
                                        <i class="bi bi-arrow-down-up" style="opacity: 0.4;"></i>
                                    <?php endif; ?>
                                </a>
                            </th>

                            <th style="width: 32%;">
                                <a href="<?= $getSortUrl('description') ?>" style="color: inherit; text-decoration: none;">
                                    操作內容
                                    <?php if ($sort === 'description'): ?>
                                        <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                    <?php else: ?>
                                        <i class="bi bi-arrow-down-up" style="opacity: 0.4;"></i>
                                    <?php endif; ?>
                                </a>
                            </th>

                            <th style="width: 17%;">
                                <a href="<?= $getSortUrl('created_at') ?>" style="color: inherit; text-decoration: none;">
                                    操作時間
                                    <?php if ($sort === 'created_at'): ?>
                                        <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                    <?php else: ?>
                                        <i class="bi bi-arrow-down-up" style="opacity: 0.4;"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($logs as $log): ?>
                            <?php
                                $actionText = $log['action'] ?? '';
                                if (str_contains($actionText, '登入')) {
                                    $badgeStyle = 'background-color: #dbeafe; color: #1e40af;';
                                } elseif (str_contains($actionText, '新增')) {
                                    $badgeStyle = 'background-color: #f0fdf4; color: #166534;';
                                } elseif (str_contains($actionText, '登出')) {
                                    $badgeStyle = 'background-color: #fef2f2; color: #991b1b;';
                                } else {
                                    $badgeStyle = 'background-color: #f3e8ff; color: #6d28d9;';
                                }
                            ?>
                            <tr>
                                <td title="<?= esc($log['id']) ?>">
                                    <strong><?= esc($log['id']) ?></strong>
                                </td>
                                <td title="<?= esc($log['username'] ?? '未知管理員') ?>">
                                    <strong><?= esc($log['username'] ?? '未知管理員') ?></strong>
                                </td>
                                <td title="<?= esc($log['admin_name'] ?? '') ?>">
                                    <?= esc($log['admin_name'] ?? '') ?>
                                </td>
                                <td title="<?= esc($log['action']) ?>">
                                    <span style="display: inline-block; padding: 0.15rem 0.5rem; border-radius: 0.25rem; font-size: 0.85rem; font-weight: 500; <?= $badgeStyle ?>">
                                        <?= esc($log['action']) ?>
                                    </span>
                                </td>
                                <td title="<?= esc($log['description']) ?>">
                                    <?= esc($log['description']) ?>
                                </td>
                                <td title="<?= esc($log['created_at'] ?? '') ?>">
                                    <?= esc($log['created_at'] ?? '') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- 分頁列 -->
                <?php
                    $currentPage = $pager->getCurrentPage();
                    $totalPages = $pager->getPageCount();

                    $queryParams = [
                        'keyword'   => $keyword,
                        'sort'      => $sort,
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

                        <!-- 頁碼 -->
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