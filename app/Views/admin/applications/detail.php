<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/apply.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/admin.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>考生報名資料詳細內容 - 後臺管理系統</title>
</head>

<body>

    <!-- 頂部導覽列 -->
    <?php include APPPATH . 'Views/admin/header.php'; ?>

    <!-- 主要內容區 -->
    <main class="apply-container">
        <section class="apply-content-card" style="padding: 2rem; max-width: 900px; margin: 0 auto;">

            <!-- 頁面標題列 -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 2px solid #ddd6fe; padding-bottom: 0.75rem;">
                <h2 class="section-title">
                    <i class="bi bi-file-earmark-person-fill"></i> 考生報名資料詳細內容
                </h2>
                <a href="<?= site_url('admin/applications') ?>" class="secondary-button" style="text-decoration: none; padding: 0.5rem 1rem; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 0.3rem;">
                    <i class="bi bi-arrow-left"></i> 返回考生報名資料列表
                </a>
            </div>

            <!-- 考生資料 -->
            <div style="margin-bottom: 2rem;">
                <h3 style="font-size: 1.05rem; color: #4c1d95; margin: 0 0 0.75rem 0; font-weight: 600; display: flex; align-items: center; gap: 0.4rem;">
                    <i class="bi bi-person-badge"></i> 考生身分資料
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                    <div style="padding: 1rem; background-color: #fcfaff; border: 1px solid #ddd6fe; border-radius: 0.5rem;">
                        <span style="font-size: 0.85rem; color: #6d28d9; font-weight: 600; display: block; margin-bottom: 0.25rem;">考生姓名</span>
                        <span style="font-size: 1.1rem; color: #4c1d95; font-weight: 700;"><?= esc($application['name']) ?></span>
                    </div>
                    <div style="padding: 1rem; background-color: #fcfaff; border: 1px solid #ddd6fe; border-radius: 0.5rem;">
                        <span style="font-size: 0.85rem; color: #6d28d9; font-weight: 600; display: block; margin-bottom: 0.25rem;">學測應試號碼</span>
                        <span style="font-size: 1rem; color: #1e293b; font-weight: 600; letter-spacing: 0.5px;"><?= esc($application['exam_number']) ?></span>
                    </div>
                    <div style="padding: 1rem; background-color: #fcfaff; border: 1px solid #ddd6fe; border-radius: 0.5rem;">
                        <span style="font-size: 0.85rem; color: #6d28d9; font-weight: 600; display: block; margin-bottom: 0.25rem;">身分證字號</span>
                        <span style="font-size: 1rem; color: #1e293b; font-weight: 600; letter-spacing: 0.5px;"><?= esc($application['id_number']) ?></span>
                    </div>
                </div>
            </div>

            <!-- 報名基本資料 -->
            <div style="margin-bottom: 2rem;">
                <h3 style="font-size: 1.05rem; color: #4c1d95; margin: 0 0 0.75rem 0; font-weight: 600; display: flex; align-items: center; gap: 0.4rem;">
                    <i class="bi bi-card-checklist"></i> 報名基本聯絡資料
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                    <div style="padding: 1rem; background-color: #fcfaff; border: 1px solid #ddd6fe; border-radius: 0.5rem;">
                        <span style="font-size: 0.85rem; color: #6d28d9; font-weight: 600; display: block; margin-bottom: 0.25rem;">出生年月日</span>
                        <span style="font-size: 0.95rem; color: #1e293b; font-weight: 500;"><?= esc($application['birth_date']) ?></span>
                    </div>
                    <div style="padding: 1rem; background-color: #fcfaff; border: 1px solid #ddd6fe; border-radius: 0.5rem;">
                        <span style="font-size: 0.85rem; color: #6d28d9; font-weight: 600; display: block; margin-bottom: 0.25rem;">手機號碼</span>
                        <span style="font-size: 0.95rem; color: #1e293b; font-weight: 500;"><?= esc($application['phone']) ?></span>
                    </div>
                    <div style="padding: 1rem; background-color: #fcfaff; border: 1px solid #ddd6fe; border-radius: 0.5rem;">
                        <span style="font-size: 0.85rem; color: #6d28d9; font-weight: 600; display: block; margin-bottom: 0.25rem;">電子郵件</span>
                        <span style="font-size: 0.95rem; color: #1e293b; font-weight: 500; word-break: break-all;"><?= esc($application['email'] ?? '未提供') ?></span>
                    </div>
                    <div style="padding: 1rem; background-color: #fcfaff; border: 1px solid #ddd6fe; border-radius: 0.5rem; grid-column: 1 / -1;">
                        <span style="font-size: 0.85rem; color: #6d28d9; font-weight: 600; display: block; margin-bottom: 0.25rem;">通訊地址</span>
                        <span style="font-size: 0.95rem; color: #1e293b; font-weight: 500;"><?= esc($application['address']) ?></span>
                    </div>
                </div>
            </div>

            <!-- 資料紀錄時間 -->
            <div style="margin-bottom: 2rem;">
                <h3 style="font-size: 1.05rem; color: #4c1d95; margin: 0 0 0.75rem 0; font-weight: 600; display: flex; align-items: center; gap: 0.4rem;">
                    <i class="bi bi-clock-history"></i> 資料異動紀錄
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                    <div style="padding: 1rem; background-color: #fcfaff; border: 1px solid #ddd6fe; border-radius: 0.5rem;">
                        <span style="font-size: 0.85rem; color: #6d28d9; font-weight: 600; display: block; margin-bottom: 0.25rem;">資料建立時間</span>
                        <span style="font-size: 0.95rem; color: #4b5563;"><?= esc($application['created_at'] ?? '無記錄') ?></span>
                    </div>
                    <div style="padding: 1rem; background-color: #fcfaff; border: 1px solid #ddd6fe; border-radius: 0.5rem;">
                        <span style="font-size: 0.85rem; color: #6d28d9; font-weight: 600; display: block; margin-bottom: 0.25rem;">最後編輯時間</span>
                        <span style="font-size: 0.95rem; color: #4b5563;"><?= esc($application['updated_at'] ?? '無記錄') ?></span>
                    </div>
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #ddd6fe; margin: 1.5rem 0;">

            <!-- 志願選填 -->
            <div>
                <h3 style="font-size: 1.05rem; color: #4c1d95; margin: 0 0 0.75rem 0; font-weight: 600; display: flex; align-items: center; gap: 0.4rem;">
                    <i class="bi bi-list-stars"></i> 志願選填明細
                </h3>

                <?php if (!empty($departments)): ?>
                    <div style="overflow-x: auto; border: 1px solid #ddd6fe; border-radius: 0.5rem;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.95rem; text-align: left;">
                            <thead>
                                <tr style="background-color: #f3e8ff; color: #4c1d95; border-bottom: 1px solid #ddd6fe;">
                                    <th style="padding: 0.75rem 1rem; text-align: center; width: 60px;">序號</th>
                                    <th style="padding: 0.75rem 1rem;">校系代碼</th>
                                    <th style="padding: 0.75rem 1rem;">大學名稱</th>
                                    <th style="padding: 0.75rem 1rem;">科系名稱</th>
                                    <th style="padding: 0.75rem 1rem;">確認送出時間</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($departments as $index => $dept): ?>
                                    <tr style="border-bottom: 1px solid #f3e8ff; transition: background-color 0.15s ease;" onmouseover="this.style.backgroundColor='#fcfaff'" onmouseout="this.style.backgroundColor='transparent'">
                                        <td style="padding: 0.75rem 1rem; text-align: center; font-weight: 600; color: #6d28d9;"><?= $index + 1 ?></td>
                                        <td style="padding: 0.75rem 1rem; font-weight: 600; color: #1e293b;"><?= esc($dept['university_code'] . $dept['department_code']) ?></td>
                                        <td style="padding: 0.75rem 1rem; color: #334155;"><?= esc($dept['university_name']) ?></td>
                                        <td style="padding: 0.75rem 1rem; color: #334155; font-weight: 500;"><?= esc($dept['department_name']) ?></td>
                                        <td style="padding: 0.75rem 1rem; color: #64748b; font-size: 0.9rem;"><?= esc($dept['confirmed_at'] ?? '尚未確認') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div style="padding: 1.5rem; background-color: #fcfaff; border: 1px dashed #ddd6fe; border-radius: 0.5rem; text-align: center; color: #6b5b95;">
                        <i class="bi bi-info-circle" style="font-size: 1.2rem; vertical-align: middle; margin-right: 0.3rem;"></i>
                        目前尚未加入志願選填資料或未確認送出。
                    </div>
                <?php endif; ?>
            </div>

            <!-- 底部動作按鈕區 -->
            <div style="display: flex; justify-content: flex-start; margin-top: 2rem;">
                <a href="<?= site_url('admin/applications') ?>" class="secondary-button" style="text-decoration: none; padding: 0.6rem 1.25rem; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 0.4rem;">
                    <i class="bi bi-arrow-left-circle"></i> 返回考生報名資料列表
                </a>
            </div>

        </section>
    </main>

    <footer class="apply-footer" style="margin-top: 2rem;">
        Apply116 後臺管理系統
    </footer>

</body>
</html>