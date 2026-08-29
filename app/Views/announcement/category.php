<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($category) ?> - 訊息公告</title>
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/home.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/system-info.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/apply.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <?= $this->include('Layout/navbar') ?>
    <?= $this->include('Layout/sidebar') ?>

    <main class="home-main">
        <div class="home-content" style="padding-bottom: 20px">
            
            <!-- 頁面標題區塊 -->
            <section class="system-info-header">
                <h2>
                    <i class="bi bi-tag"></i>
                    <?= esc($category) ?>
                </h2>
                <p>
                    提供分類「<?= esc($category) ?>」相關最新消息與重要公告。
                </p>
            </section>

            <!-- 動態跑馬燈 -->
            <?php if (!empty($marquee)): ?>
                <div class="system-info-highlight" style="margin-bottom: 20px;">
                    <i class="bi bi-broadcast" style="flex-shrink: 0; margin-right: 8px;"></i>
                    <div class="home-marquee-wrapper">
                        <div class="home-marquee-content">
                            <?= esc($marquee['content']) ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- 計算分頁資訊 -->
            <?php
                $currentPage = $pager->getCurrentPage();
                $totalPages  = $pager->getPageCount();
                $totalItems  = $pager->getTotal();
            ?>

            <!-- 頁數與資料筆數提示區 -->
            <div style="color: #536b82; font-size: 0.9rem; margin-bottom: 12px; text-align: right;">
                第 <strong><?= $currentPage ?></strong> /
                <strong><?= $totalPages ?></strong> 頁
                ｜ 共 <strong><?= $totalItems ?></strong> 則公告
            </div>

            <!-- 公告內容區域 -->
            <?php if (empty($announcements)): ?>

                <!-- 無公告狀態 -->
                <div class="system-info-empty">
                    <i class="bi bi-info-circle"></i>
                    <div class="system-info-empty-content">
                        <strong>目前沒有「<?= esc($category) ?>」相關公告</strong>
                        <p>最新公告事項將會在此處發布，請隨時留意。</p>
                    </div>
                </div>

            <?php else: ?>

                <!-- 公告列表卡片 -->
                <section class="system-info-card" style="padding: 0; overflow: hidden;">
                    <?php foreach ($announcements as $announcement): ?>
                        <div class="announcement-row">
                            <!-- 左側：第一列日期，第二列公告類別 -->
                            <div class="announcement-left-meta">
                                <span class="announcement-meta-date">
                                    <?= esc(date('Y/m/d', strtotime($announcement['publish_date']))) ?>
                                </span>
                                <span class="announcement-meta-category">
                                    <?= esc($announcement['category']) ?>
                                </span>
                            </div>

                            <!-- 右側：標題（純檔案類型解析第一個附件路徑） -->
                            <div class="announcement-title-box">
                                <?php 
                                    $fileUrl = '#';
                                    if ($announcement['type'] === '純檔案' && !empty($announcement['attachment'])) {
                                        $clean = str_replace('\\', '/', $announcement['attachment']);
                                        $decoded = json_decode($clean, true);
                                        if (is_array($decoded) && isset($decoded[0]['path'])) {
                                            $fileUrl = base_url($decoded[0]['path']);
                                        } else {
                                            $fileUrl = base_url($clean);
                                        }
                                    }
                                ?>

                                <?php if ($announcement['type'] === '純檔案'): ?>
                                    <a href="<?= $fileUrl ?>" target="_blank" rel="noopener noreferrer">
                                        <i class="bi bi-file-earmark-arrow-down"></i>
                                        <?= esc($announcement['title']) ?>
                                    </a>
                                <?php elseif ($announcement['type'] === '超連結' && !empty($announcement['external_url'])): ?>
                                    <a href="<?= esc($announcement['external_url']) ?>" target="_blank" rel="noopener noreferrer">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                        <?= esc($announcement['title']) ?>
                                    </a>
                                <?php else: ?>
                                    <a href="<?= site_url('announcement/' . $announcement['id']) ?>">
                                        <?= esc($announcement['title']) ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </section>

                <!-- 後台風格之自訂分頁導覽列 -->
                <?php if ($totalPages > 1): ?>
                    <div class="pagination-container">

                        <!-- 上一頁 -->
                        <?php if ($currentPage > 1): ?>
                            <a href="<?= site_url('announcement/category/' . $categoryId . '?page=' . ($currentPage - 1)) ?>">
                                &lt;
                            </a>
                        <?php endif; ?>

                        <!-- 計算需要顯示的頁號 -->
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

                        <!-- 渲染頁數按鈕 -->
                        <?php foreach ($pages as $p): ?>
                            <?php if ($p === '...'): ?>
                                <span style="border: none; background: transparent; cursor: default;">...</span>
                            <?php elseif ($p == $currentPage): ?>
                                <span class="active"><?= $p ?></span>
                            <?php else: ?>
                                <a href="<?= site_url('announcement/category/' . $categoryId . '?page=' . $p) ?>">
                                    <?= $p ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <!-- 下一頁 -->
                        <?php if ($currentPage < $totalPages): ?>
                            <a href="<?= site_url('announcement/category/' . $categoryId . '?page=' . ($currentPage + 1)) ?>">
                                &gt;
                            </a>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>

            <?php endif; ?>

            <footer class="apply-footer">
                服務時間：平日(周一至周五)：上午8:00~12:00；下午13:00~17:00。例假日及國定假日暫停服務。
                <br>
                621301嘉義縣民雄鄉大學路一段168號 (05)2721799
                <br>
                Copyright by CAC. All rights reserved.
            </footer>

        </div>
    </main>
    <script src="<?= base_url('JS/sidebar.js') ?>"></script>
</body>
</html>