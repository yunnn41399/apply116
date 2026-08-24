<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/apply.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/admin.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>考生註冊資料 - 後臺管理系統</title>
</head>

<body>
    <!-- 頂部導覽列 -->
    <?php include APPPATH . 'Views/admin/header.php'; ?>

    <!-- 主要內容區 -->
    <main class="apply-container">
        <section class="apply-content-card" style="padding: 2rem; max-width: 800px; margin: 0 auto;">

            <!-- 頁面標題列 -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 2px solid #ddd6fe; padding-bottom: 0.75rem;">
                <h2 class="section-title" style="border: none; margin: 0; padding: 0;">
                    <i class="bi bi-person-vcard-fill"></i> 考生註冊資料
                </h2>
                <a href="<?= site_url('admin/candidates') ?>" class="secondary-button" style="text-decoration: none; padding: 0.5rem 1rem; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 0.3rem;">
                    <i class="bi bi-arrow-left"></i> 返回考生資料列表
                </a>
            </div>

            <!-- 考生資料網格區塊 -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                
                <!-- 編號 -->
                <div style="padding: 1rem; background-color: #fcfaff; border: 1px solid #ddd6fe; border-radius: 0.5rem;">
                    <span style="font-size: 0.85rem; color: #6d28d9; font-weight: 600; display: block; margin-bottom: 0.25rem;">
                        <i class="bi bi-hash"></i> 系統編號
                    </span>
                    <span style="font-size: 1.1rem; color: #4c1d95; font-weight: 700;">
                        <?= esc($candidate['id']) ?>
                    </span>
                </div>

                <!-- 考生姓名 -->
                <div style="padding: 1rem; background-color: #fcfaff; border: 1px solid #ddd6fe; border-radius: 0.5rem;">
                    <span style="font-size: 0.85rem; color: #6d28d9; font-weight: 600; display: block; margin-bottom: 0.25rem;">
                        <i class="bi bi-person-fill"></i> 考生姓名
                    </span>
                    <span style="font-size: 1.1rem; color: #4c1d95; font-weight: 700;">
                        <?= esc($candidate['name']) ?>
                    </span>
                </div>

                <!-- 學測應試號碼 -->
                <div style="padding: 1rem; background-color: #fcfaff; border: 1px solid #ddd6fe; border-radius: 0.5rem;">
                    <span style="font-size: 0.85rem; color: #6d28d9; font-weight: 600; display: block; margin-bottom: 0.25rem;">
                        <i class="bi bi-card-heading"></i> 學測應試號碼
                    </span>
                    <span style="font-size: 1rem; color: #1e293b; font-weight: 600; letter-spacing: 0.5px;">
                        <?= esc($candidate['exam_number']) ?>
                    </span>
                </div>

                <!-- 身分證字號 -->
                <div style="padding: 1rem; background-color: #fcfaff; border: 1px solid #ddd6fe; border-radius: 0.5rem;">
                    <span style="font-size: 0.85rem; color: #6d28d9; font-weight: 600; display: block; margin-bottom: 0.25rem;">
                        <i class="bi bi-person-badge-fill"></i> 身分證字號
                    </span>
                    <span style="font-size: 1rem; color: #1e293b; font-weight: 600; letter-spacing: 0.5px;">
                        <?= esc($candidate['id_number']) ?>
                    </span>
                </div>

                <!-- 註冊時間 -->
                <div style="padding: 1rem; background-color: #fcfaff; border: 1px solid #ddd6fe; border-radius: 0.5rem;">
                    <span style="font-size: 0.85rem; color: #6d28d9; font-weight: 600; display: block; margin-bottom: 0.25rem;">
                        <i class="bi bi-clock-fill"></i> 註冊時間
                    </span>
                    <span style="font-size: 0.95rem; color: #4b5563;">
                        <?= esc($candidate['created_at'] ?? '無記錄') ?>
                    </span>
                </div>

                <!-- 最後更新時間 -->
                <div style="padding: 1rem; background-color: #fcfaff; border: 1px solid #ddd6fe; border-radius: 0.5rem;">
                    <span style="font-size: 0.85rem; color: #6d28d9; font-weight: 600; display: block; margin-bottom: 0.25rem;">
                        <i class="bi bi-arrow-repeat"></i> 最後更新時間
                    </span>
                    <span style="font-size: 0.95rem; color: #4b5563;">
                        <?= esc($candidate['updated_at'] ?? '無記錄') ?>
                    </span>
                </div>

            </div>

        </section>
    </main>

    <footer class="apply-footer" style="margin-top: 2rem;">
        Apply116 後臺管理系統
    </footer>

</body>
</html>