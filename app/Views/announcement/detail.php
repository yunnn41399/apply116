<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($announcement['title']) ?> - 訊息公告</title>
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/home.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/system-info.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <?= $this->include('Layout/navbar') ?>
    <?= $this->include('Layout/sidebar') ?>

    <main class="home-main">
        <div class="home-content">
            
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

                <!-- 文末附件區塊 -->
                <?php if (!empty($announcement['attachment'])): ?>
                    <div style="margin-top: 28px; padding-top: 16px; border-top: 1px dashed #cbd5e1;">
                        <h3 style="font-size: 1rem; color: #334155; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                            <i class="bi bi-paperclip"></i> 相關附件
                        </h3>
                        <a href="<?= base_url($announcement['attachment']) ?>" target="_blank" download style="display: inline-flex; align-items: center; gap: 6px; color: #2563eb; text-decoration: none; font-weight: 500;">
                            <i class="bi bi-file-earmark-arrow-down"></i>
                            點此下載 / 檢視附件
                        </a>
                    </div>
                <?php endif; ?>

            </section>

            <!-- 返回上一頁 / 返回列表按鈕 -->
            <div style="margin-top: 20px;">
                <a href="<?= base_url('/') ?>" style="display: inline-flex; align-items: center; gap: 6px; color: #475569; text-decoration: none; font-size: 0.95rem; font-weight: 500;">
                    <i class="bi bi-arrow-left"></i> 返回公告列表
                </a>
            </div>

        </div>
    </main>
    <script src="<?= base_url('JS/sidebar.js') ?>"></script>
</body>
</html>