<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/apply.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/admin.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>管理員帳號管理 - 後臺管理系統</title>
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
                    <i class="bi bi-person-gear"></i> 管理員帳號管理
                </h2>
                <div style="display: flex; gap: 0.5rem;">
                    <a href="<?= site_url('admin/admins/create') ?>" class="primary-button" style="text-decoration: none; padding: 0.5rem 1rem; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 0.3rem;">
                        <i class="bi bi-person-plus-fill"></i> 新增管理員
                    </a>
                    <a href="<?= site_url('admin/logs') ?>" class="secondary-button" style="text-decoration: none; padding: 0.5rem 1rem; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 0.3rem;">
                        <i class="bi bi-journal-text"></i> 查看操作紀錄
                    </a>
                </div>
            </div>

            <!-- Session 提示訊息 -->
            <?php if (session()->has('success')): ?>
                <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 0.75rem 1rem; border-radius: 0.375rem; margin-bottom: 1.25rem; font-size: 0.95rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="bi bi-check-circle-fill"></i> <?= esc(session('success')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->has('error')): ?>
                <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 0.75rem 1rem; border-radius: 0.375rem; margin-bottom: 1.25rem; font-size: 0.95rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="bi bi-exclamation-triangle-fill"></i> <?= esc(session('error')) ?>
                </div>
            <?php endif; ?>

            <!-- 搜尋區域 -->
            <form method="get" action="<?= site_url('admin/admins') ?>" style="display: flex; gap: 0.5rem; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap;">
                <div style="position: relative; flex: 1; max-width: 350px;">
                    <i class="bi bi-search" style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: #8b5cf6;"></i>
                    <input
                        type="text"
                        id="keyword"
                        name="keyword"
                        value="<?= esc($keyword ?? '') ?>"
                        placeholder="管理員帳號、姓名或 Email"
                        style="width: 100%; padding: 0.5rem 0.75rem 0.5rem 2.25rem; border: 1px solid #ddd6fe; border-radius: 0.375rem; outline: none; font-size: 0.95rem;"
                    >
                </div>

                <button type="submit" class="primary-button" style="padding: 0.5rem 1rem; font-size: 0.95rem;">
                    搜尋
                </button>

                <?php if (!empty($keyword)): ?>
                    <a href="<?= site_url('admin/admins') ?>" class="secondary-button" style="text-decoration: none; padding: 0.5rem 0.8rem; font-size: 0.95rem;">
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

            <!-- 管理員列表表格 -->
            <?php if (empty($admins)): ?>
                <div style="text-align: center; color: #6b5b95; padding: 3rem; background-color: #fcfaff; border-radius: 0.5rem; border: 1px dashed #ddd6fe;">
                    <i class="bi bi-search-heart" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
                    找不到符合條件的管理員資料。
                </div>
            <?php else: ?>
                <table class="admin-table">
                    <thead>
                        <tr>

                            <th style="width: 8%;">
                                <a href="<?= site_url('admin/admins?keyword=' . urlencode($keyword ?? '') . '&sort=id&direction=' . (($sort === 'id' && $direction === 'DESC') ? 'ASC' : 'DESC')) ?>" style="color: inherit; text-decoration: none;">
                                    編號
                                    <?php if ($sort === 'id'): ?>
                                        <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                    <?php else: ?>
                                        <i class="bi bi-arrow-down-up" style="opacity: 0.4;"></i>
                                    <?php endif; ?>
                                </a>
                            </th>

                            <th style="width: 18%;">
                                <a href="<?= site_url('admin/admins?keyword=' . urlencode($keyword ?? '') . '&sort=username&direction=' . (($sort === 'username' && $direction === 'DESC') ? 'ASC' : 'DESC')) ?>" style="color: inherit; text-decoration: none;">
                                    管理員帳號
                                    <?php if ($sort === 'username'): ?>
                                        <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                    <?php else: ?>
                                        <i class="bi bi-arrow-down-up" style="opacity: 0.4;"></i>
                                    <?php endif; ?>
                                </a>
                            </th>

                            <th style="width: 16%;">
                                <a href="<?= site_url('admin/admins?keyword=' . urlencode($keyword ?? '') . '&sort=name&direction=' . (($sort === 'name' && $direction === 'DESC') ? 'ASC' : 'DESC')) ?>" style="color: inherit; text-decoration: none;">
                                    姓名
                                    <?php if ($sort === 'name'): ?>
                                        <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                    <?php else: ?>
                                        <i class="bi bi-arrow-down-up" style="opacity: 0.4;"></i>
                                    <?php endif; ?>
                                </a>
                            </th>

                            <th style="width: 15%;">
                                <a href="<?= site_url('admin/admins?keyword=' . urlencode($keyword ?? '') . '&sort=role&direction=' . (($sort === 'role' && $direction === 'DESC') ? 'ASC' : 'DESC')) ?>" style="color: inherit; text-decoration: none;">
                                    角色
                                    <?php if ($sort === 'role'): ?>
                                        <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                    <?php else: ?>
                                        <i class="bi bi-arrow-down-up" style="opacity: 0.4;"></i>
                                    <?php endif; ?>
                                </a>
                            </th>

                            <th style="width: 12%;">
                                <a href="<?= site_url('admin/admins?keyword=' . urlencode($keyword ?? '') . '&sort=status&direction=' . (($sort === 'status' && $direction === 'DESC') ? 'ASC' : 'DESC')) ?>" style="color: inherit; text-decoration: none;">
                                    狀態
                                    <?php if ($sort === 'status'): ?>
                                        <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                    <?php else: ?>
                                        <i class="bi bi-arrow-down-up" style="opacity: 0.4;"></i>
                                    <?php endif; ?>
                                </a>
                            </th>

                            <th style="width: 20%;">
                                <a href="<?= site_url('admin/admins?keyword=' . urlencode($keyword ?? '') . '&sort=created_at&direction=' . (($sort === 'created_at' && $direction === 'DESC') ? 'ASC' : 'DESC')) ?>" style="color: inherit; text-decoration: none;">
                                    建立時間
                                    <?php if ($sort === 'created_at'): ?>
                                        <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                    <?php else: ?>
                                        <i class="bi bi-arrow-down-up" style="opacity: 0.4;"></i>
                                    <?php endif; ?>
                                </a>
                            </th>

                            <th style="width: 11%;">操作</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($admins as $admin): ?>
                            <?php
                                $roleName = match ($admin['role']) {
                                    'super_admin' => '最高管理員',
                                    'admin'       => '一般管理員',
                                    default       => '未知角色',
                                };

                                $statusName = match ($admin['status']) {
                                    'active'   => '🟢啟用',
                                    'inactive' => '🔴停用',
                                    default    => '未知狀態',
                                };
                            ?>
                            <tr>
                                <td title="<?= esc($admin['id']) ?>">
                                    <strong><?= esc($admin['id']) ?></strong>
                                </td>
                                <td title="<?= esc($admin['username']) ?>">
                                    <strong><?= esc($admin['username']) ?></strong>
                                </td>
                                <td title="<?= esc($admin['name']) ?>">
                                    <?= esc($admin['name']) ?>
                                </td>
                                <td title="<?= esc($roleName) ?>">
                                    <span style=" <?= $admin['role'] === 'super_admin' ? 'font-weight: 600;' : 'font-weight: 400;' ?>">
                                        <?= esc($roleName) ?>
                                    </span>
                                </td>
                                <td title="<?= esc($statusName) ?>">
                                    <span style="font-weight: 500; <?= $admin['status'] === 'active' ? 'color: #166534;' : 'color: #991b1b;' ?>">
                                        <?= esc($statusName) ?>
                                    </span>
                                </td>
                                <td title="<?= esc($admin['created_at'] ?? '') ?>">
                                    <?= esc($admin['created_at'] ?? '') ?>
                                </td>
                                <td>
                                    <a href="<?= site_url('admin/admins/edit/' . $admin['id']) ?>" class="secondary-button" style="text-decoration: none; padding: 0.25rem 0.6rem; font-size: 0.875rem; display: inline-block;">
                                        <i class="bi bi-pencil-square"></i> 編輯
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- 分頁列 -->
                <?php
                    $currentPage = $pager->getCurrentPage();
                    $totalPages = $pager->getPageCount();
                ?>

                <?php if ($totalPages > 1): ?>
                    
                    <div class="admin-pagination">

                        <!-- 上一頁 -->
                        <?php if ($currentPage > 1): ?>
                            <a href="<?= site_url('admin/admins?keyword=' . urlencode($keyword ?? '') . '&sort=' . urlencode($sort) . '&direction=' . urlencode($direction) . '&page=' . ($currentPage - 1)) ?>">
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
                                <a href="<?= site_url('admin/admins?keyword=' . urlencode($keyword ?? '') . '&sort=' . urlencode($sort) . '&direction=' . urlencode($direction) . '&page=' . $page) ?>">
                                    <?= $page ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <!-- 下一頁 -->
                        <?php if ($currentPage < $totalPages): ?>
                            <a href="<?= site_url('admin/admins?keyword=' . urlencode($keyword ?? '') . '&sort=' . urlencode($sort) . '&direction=' . urlencode($direction) . '&page=' . ($currentPage + 1)) ?>">
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