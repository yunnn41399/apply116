<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/apply.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/register.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/admin.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>我的帳號 - 後臺管理系統</title>
</head>

<body>

    <?php include APPPATH . 'Views/admin/header.php'; ?>

    <main class="apply-container">
        <section class="apply-content-card" style="max-width: 40rem; margin: 0 auto; padding: 2rem;">
            
            <h2 class="apply-section-title" style="margin-bottom: 1.5rem; text-align: center;">
                <i class="bi bi-person-gear"></i> 我的帳號設定
            </h2>

            <!-- 成功訊息提示 -->
            <?php if (session()->has('success')): ?>
                <div class="success-message" style="margin-bottom: 1.25rem;">
                    <?= esc(session('success')) ?>
                </div>
            <?php endif; ?>

            <!-- 錯誤訊息提示 -->
            <?php if (session()->has('error')): ?>
                <div class="error-message" style="margin-bottom: 1.25rem;">
                    <?= esc(session('error')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->has('errors')): ?>
                <div class="error-message" style="margin-bottom: 1.25rem;">
                    <?php foreach (session('errors') as $error): ?>
                        <p style="margin: 0;"><?= esc($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form id="profileForm" action="<?= site_url('admin/profile') ?>" method="post">
                <?= csrf_field() ?>

                <!-- 管理員帳號 (唯讀) -->
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label>管理員帳號：</label>
                    <div style="padding: 0.5rem 0.75rem; background-color: #f3f0f7; border-radius: 0.375rem; font-weight: 600; color: #2e1065;">
                        <?= esc($admin['username']) ?>
                    </div>
                </div>

                <!-- 管理員姓名 -->
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label for="name">管理員姓名：</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="<?= esc(old('name', $admin['name'])) ?>" 
                        maxlength="50" 
                        required
                        style="font-size: 1rem; padding: 0.5rem 0.75rem;"
                    >
                </div>

                <!-- 管理員角色與狀態 (展示用) -->
                <div style="display: flex; gap: 1rem; margin-bottom: 1.25rem;">
                    <div class="form-group" style="flex: 1; margin-bottom: 0;">
                        <label>管理員角色：</label>
                        <div style="padding: 0.5rem 0.75rem; background-color: #f3f0f7; border-radius: 0.375rem; color: #3b1e70;">
                            <?= ($admin['role'] === 'super_admin') ? '最高管理員' : '一般管理員' ?>
                        </div>
                    </div>

                    <div class="form-group" style="flex: 1; margin-bottom: 0;">
                        <label>帳號狀態：</label>
                        <div style="padding: 0.5rem 0.75rem; background-color: #f3f0f7; border-radius: 0.375rem; color: #3b1e70;">
                            <?= ($admin['status'] === 'active') ? '🟢 啟用' : '🔴 停用' ?>
                        </div>
                    </div>
                </div>

                <hr style="border: none; border-top: 1px solid #8b5cf6; margin: 1.5rem 0;">

                <!-- 新密碼欄位 -->
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label for="password">新密碼：</label>
                    <div class="password-wrapper">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            minlength="8" 
                            maxlength="255" 
                            autocomplete="new-password"
                            placeholder="如不修改請留空"
                            style="font-size: 1rem; padding: 0.5rem 0.75rem;"
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('password', this)" aria-label="顯示密碼">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- 確認新密碼欄位 -->
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="password_confirm">確認新密碼：</label>
                    <div class="password-wrapper">
                        <input 
                            type="password" 
                            id="password_confirm" 
                            name="password_confirm" 
                            minlength="8" 
                            maxlength="255" 
                            autocomplete="new-password"
                            placeholder="請再次輸入新密碼"
                            style="font-size: 1rem; padding: 0.5rem 0.75rem;"
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirm', this)" aria-label="顯示密碼">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- 按鈕區域：儲存修改與取消按鈕 -->
                <div class="form-actions" style="display: flex; justify-content: center; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="primary-button" style="padding: 0.625rem 2rem; font-size: 1rem;">
                        儲存修改
                    </button>
                    
                    <button type="button" id="cancelBtn" class="secondary-button" style="padding: 0.625rem 2rem; font-size: 1rem;">
                        取消
                    </button>
                </div>
                
            </form>

        </section>
    </main>

    <footer class="apply-footer" style="margin-top: 2rem;">
        Apply116 後臺管理系統
    </footer>

    <script src="<?= base_url('JS/register.js') ?>"></script>
    
    <!-- 取消按鈕邏輯：監聽表單是否有變動 -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('profileForm');
            const cancelBtn = document.getElementById('cancelBtn');
            let isFormChanged = false;

            // 當表單內容有被修改時，標記為已變動
            form.addEventListener('input', function () {
                isFormChanged = true;
            });

            // 取消按鈕點擊事件
            cancelBtn.addEventListener('click', function () {
                if (isFormChanged) {
                    if (confirm('您有修改資料尚未儲存，確定要放棄修改嗎？')) {
                        window.location.href = "<?= site_url('admin') ?>";
                    }
                } else {
                    window.location.href = "<?= site_url('admin') ?>";
                }
            });
        });
    </script>
</body>

</html>