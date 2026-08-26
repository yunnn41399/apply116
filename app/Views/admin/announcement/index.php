<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/apply.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/admin.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>公告管理 - 後臺管理系統</title>
</head>

<body>

    <!-- 頂部導覽列 -->
    <?php include APPPATH . 'Views/admin/header.php'; ?>

    <!-- 主要內容區 -->
    <main class="apply-container">
        <section class="apply-content-card" style="padding: 2rem;">

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 2px solid #ddd6fe; padding-bottom: 0.75rem;">
                <h2 class="section-title">
                    <i class="bi bi-megaphone"></i> 公告管理
                </h2>

                <!-- 新增公告按鈕 -->
                <a href="<?= site_url('admin/announcement/create') ?>" class="primary-button" style="text-decoration: none; padding: 0.5rem 1rem; font-size: 0.95rem;">
                    <i class="bi bi-plus-lg"></i> 新增公告
                </a>
            </div>

            <!-- 成功訊息提示 -->
            <?php if (session()->has('success')): ?>
                <div class="success-message" style="margin-bottom: 1.25rem;">
                    <?= esc(session('success')) ?>
                </div>
            <?php endif; ?>

            <?php
                $currentPage = $pager->getCurrentPage();
                $totalPages = $pager->getPageCount();
                $totalItems = $pager->getTotal();
            ?>

            <!-- 搜尋區域 -->
            <form method="get" action="<?= site_url('admin/announcement') ?>"
                style="display: flex; gap: 0.5rem; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap;">

                <div style="position: relative; flex: 1; max-width: 350px;">
                    <i class="bi bi-search"
                        style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: #8b5cf6;">
                    </i>

                    <input
                        type="text"
                        id="keyword"
                        name="keyword"
                        value="<?= esc($keyword ?? '') ?>"
                        placeholder="搜尋公告標題"
                        style="width: 100%; padding: 0.5rem 0.75rem 0.5rem 2.25rem; border: 1px solid #ddd6fe; border-radius: 0.375rem; outline: none; font-size: 0.95rem;"
                    >
                </div>

                <button
                    type="submit"
                    class="primary-button"
                    style="padding: 0.5rem 1rem; font-size: 0.95rem;">
                    搜尋
                </button>

                <?php if (!empty($keyword)): ?>
                    <a
                        href="<?= site_url('admin/announcement') ?>"
                        class="secondary-button"
                        style="text-decoration: none; padding: 0.5rem 0.8rem; font-size: 0.95rem;">
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
                    <i class="bi bi-info-circle"></i>
                    搜尋關鍵字：<strong><?= esc($keyword) ?></strong>
                </div>
            <?php endif; ?>


            <!-- 公告資料表格 -->
            <table class="admin-table">
                <thead>
                    <tr>

                        <!-- 編號 -->
                        <th style="width: 8%;">
                            <a href="<?= site_url('admin/announcement?sort=id&direction=' . (($sort === 'id' && $direction === 'DESC') ? 'ASC' : 'DESC')) ?>" style="color: inherit; text-decoration: none;">
                                編號
                                <?php if ($sort === 'id'): ?>
                                    <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                <?php else: ?>
                                    <i class="bi bi-arrow-down-up" style="opacity: 0.4;"></i>
                                <?php endif; ?>
                            </a>
                        </th>

                        <!-- 公告標題 -->
                        <th style="width: 26%;">
                            <a href="<?= site_url('admin/announcement?sort=title&direction=' . (($sort === 'title' && $direction === 'DESC') ? 'ASC' : 'DESC')) ?>" style="color: inherit; text-decoration: none;">
                                公告標題
                                <?php if ($sort === 'title'): ?>
                                    <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                <?php else: ?>
                                    <i class="bi bi-arrow-down-up" style="opacity: 0.4;"></i>
                                <?php endif; ?>
                            </a>
                        </th>

                        <!-- 最後編輯時間 -->
                        <th style="width: 18%;">
                            <a href="<?= site_url('admin/announcement?sort=updated_at&direction=' . (($sort === 'updated_at' && $direction === 'DESC') ? 'ASC' : 'DESC')) ?>" style="color: inherit; text-decoration: none;">
                                最後編輯時間
                                <?php if ($sort === 'updated_at'): ?>
                                    <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                <?php else: ?>
                                    <i class="bi bi-arrow-down-up" style="opacity: 0.4;"></i>
                                <?php endif; ?>
                            </a>
                        </th>

                        <!-- 發佈時間 -->
                        <th style="width: 18%;">
                            <a href="<?= site_url('admin/announcement?sort=publish_date&direction=' . (($sort === 'publish_date' && $direction === 'DESC') ? 'ASC' : 'DESC')) ?>" style="color: inherit; text-decoration: none;">
                                發佈時間
                                <?php if ($sort === 'publish_date'): ?>
                                    <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                <?php else: ?>
                                    <i class="bi bi-arrow-down-up" style="opacity: 0.4;"></i>
                                <?php endif; ?>
                            </a>
                        </th>

                        <!-- 發佈狀態 -->
                        <th style="width: 12%;">
                            <a href="<?= site_url('admin/announcement?sort=status&direction=' . (($sort === 'status' && $direction === 'DESC') ? 'ASC' : 'DESC')) ?>" style="color: inherit; text-decoration: none;">
                                發佈狀態
                                <?php if ($sort === 'status'): ?>
                                    <?= $direction === 'ASC' ? '▲' : '▼' ?>
                                <?php else: ?>
                                    <i class="bi bi-arrow-down-up" style="opacity: 0.4;"></i>
                                <?php endif; ?>
                            </a>
                        </th>

                        <!-- 操作 -->
                        <th style="width: 18%;">操作</th>

                    </tr>
                </thead>

                <tbody>
                    <?php if (empty($announcements)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: #6b5b95; padding: 2rem;">目前沒有公告。</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($announcements as $announcement): ?>
                            <tr>
                                <td><strong><?= esc($announcement['id']) ?></strong></td>
                                <td><strong><?= esc($announcement['title']) ?></strong></td>
                                <td><?= esc($announcement['updated_at'] ?? '') ?></td>
                                <td><?= esc($announcement['publish_date'] ?? '') ?></td>
                                <td>
                                    <?php if ($announcement['status'] === 'published'): ?>
                                        <span style="color: #16835a; font-weight: 600;">🟢 已發布</span>
                                    <?php else: ?>
                                        <span style="color: #d64545; font-weight: 600;">🔴 草稿</span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: center;">
                                    <!-- 編輯按鈕 -->
                                    <a href="<?= site_url('admin/announcement/edit/' . $announcement['id']) ?>" class="secondary-button" style="text-decoration: none; padding: 0.25rem 0.6rem; font-size: 0.875rem; margin-right: 0.25rem;">
                                        <i class="bi bi-pencil"></i> 編輯
                                    </a>

                                    <!-- 刪除表單 -->
                                    <form action="<?= site_url('admin/announcement/delete/' . $announcement['id']) ?>" 
                                        method="post" 
                                        style="display: inline;" 
                                        onsubmit="return confirm('確定要刪除這筆公告嗎？刪除後將無法復原！');">
                                        
                                        <?= csrf_field() ?>
                                        <button type="submit" style="color: #dc2626; background: none; border: 1px solid #fca5a5; padding: 0.25rem 0.6rem; font-size: 0.875rem; border-radius: 0.375rem; cursor: pointer; transition: all 0.2s ease;">
                                            <i class="bi bi-trash"></i> 刪除
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- 分頁列 -->
            <?php if ($totalPages > 1): ?>

                <div class="admin-pagination">

                    <!-- 上一頁 -->
                    <?php if ($currentPage > 1): ?>
                        <a href="<?= site_url('admin/announcement?sort=' . urlencode($sort) . '&direction=' . urlencode($direction) . '&page=' . ($currentPage - 1)) ?>">
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
                            <a href="<?= site_url('admin/announcement?sort=' . urlencode($sort) . '&direction=' . urlencode($direction) . '&page=' . $page) ?>">
                                <?= $page ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <!-- 下一頁 -->
                    <?php if ($currentPage < $totalPages): ?>
                        <a href="<?= site_url('admin/announcement?sort=' . urlencode($sort) . '&direction=' . urlencode($direction) . '&page=' . ($currentPage + 1)) ?>">
                            &gt;
                        </a>
                    <?php endif; ?>

                </div>
            <?php endif; ?>

        </section>
    </main>

    <footer class="apply-footer" style="margin-top: 2rem;">
        Apply116 後臺管理系統
    </footer>

</body>
</html>