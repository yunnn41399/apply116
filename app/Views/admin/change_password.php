<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/register.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/admin.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>修改管理員密碼</title>
</head>

<body>
    <header class="page-header">
        <h1>Apply116 後臺管理</h1>
    </header>

    <main class="form-container">
        <h2>修改管理員密碼</h2>

        <!-- 使用 rem 與 em 調整內聯樣式 -->
        <p style="text-align: center; color: #6b5b95; font-size: 0.9rem; margin-bottom: 1.5rem;">
            為了帳號安全，首次登入請務必修改預設密碼。
        </p>

        <!-- 錯誤訊息提示 -->
        <?php if (session()->has('errors')): ?>
            <div class="error-message">
                <?php foreach (session('errors') as $error): ?>
                    <p style="margin: 0;"><?= esc($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('error')): ?>
            <div class="error-message">
                <?= esc(session('error')) ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('admin/change-password') ?>" method="post">
            <?= csrf_field() ?>

            <!-- 新密碼欄位 -->
            <div class="form-group">
                <label for="password">新密碼：</label>
                <div class="password-wrapper">
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        placeholder="請注意區分大小寫" 
                        required
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword('password', this)" aria-label="顯示密碼">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <!-- 確認新密碼欄位 -->
            <div class="form-group">
                <label for="password_confirm">確認新密碼：</label>
                <div class="password-wrapper">
                    <input 
                        type="password" 
                        id="password_confirm" 
                        name="password_confirm"
                        placeholder="請注意區分大小寫" 
                        required
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirm', this)" aria-label="顯示密碼">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="primary-button">
                    修改密碼
                </button>
            </div>
            
        </form>
    </main>

    <script src="<?= base_url('JS/register.js') ?>"></script>
</body>

</html>