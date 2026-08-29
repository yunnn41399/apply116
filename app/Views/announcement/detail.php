<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($announcement['title']) ?> - 訊息公告</title>
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

            <!-- 主要公告內容卡片 -->
            <section class="system-info-card" style="padding: 24px; line-height: 1.8;">
                
                <!-- 公告標題 -->
                <h1 style="font-size: 1.5rem; color: #1e293b; margin-top: 0; margin-bottom: 12px; font-weight: 700;">
                    <?= esc($announcement['title']) ?>
                </h1>

                <!-- 元資料：日期與分類 -->
                <div style="display: flex; gap: 12px; align-items: center; color: #64748b; font-size: 0.9rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 16px; margin-bottom: 20px;">
                    <span><i class="bi bi-calendar3"></i> 發布日期：<?= esc(date('Y/m/d', strtotime($announcement['publish_date'] ?? 'now'))) ?></span>
                    <span>•</span>
                    <span><i class="bi bi-tag"></i> 分類：<?= esc($announcement['category']) ?></span>
                </div>

                <!-- 內文區塊 -->
                <div class="announcement-detail-content" style="color: #334155; font-size: 1rem; min-height: 120px;">
                    <?= nl2br(esc($announcement['content'] ?? '')) ?>
                </div>

                <!-- 文末附件區塊（直接取用 Controller 傳過來的 $attachments 陣列） -->
                <?php if (!empty($attachments)): ?>
                    <div class="mt-4" style="margin-top: 24px; padding-top: 16px; border-top: 1px dashed #e2e8f0;">
                        <h5 style="font-size: 1.05rem; font-weight: 600; color: #334155; margin: 1rem 0">附件下載：</h5>
                        <ul style="padding-left: 0px; margin-top: 8px; list-style: none;">
                            <?php foreach ($attachments as $file): ?>
                                <?php if (!empty($file['path'])): ?>
                                    <li style="margin-bottom: 6px;">
                                        <a href="<?= base_url(esc($file['path'])) ?>" target="_blank" style="color: #2563eb; text-decoration: none;">
                                            <i class="bi bi-file-earmark-arrow-down"></i> <?= esc($file['custom_name']) ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

            </section>

            <!-- 返回上一頁 / 返回列表按鈕 -->
            <div style="margin-top: 20px;">
                <a href="<?= base_url('/') ?>" style="display: inline-flex; align-items: center; gap: 6px; color: #475569; text-decoration: none; font-size: 0.95rem; font-weight: 500;">
                    <i class="bi bi-arrow-left"></i> 返回公告列表
                </a>
            </div>

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