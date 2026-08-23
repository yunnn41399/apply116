<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/register.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/admin.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>管理員登入</title>
</head>

<body>
    <header class="page-header">
        <h1>Apply116 後臺管理</h1>
    </header>

    <main class="form-container">
        <h2>管理員登入</h2>

        <!-- 錯誤訊息提示 -->
        <?php if (session()->has('error')): ?>
            <div class="error-message">
                <?= esc(session('error')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('errors')): ?>
            <div class="error-message">
                <?php foreach (session('errors') as $error): ?>
                    <p style="margin: 0;"><?= esc($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- 成功訊息提示 -->
        <?php if (session()->has('success')): ?>
            <div class="success-message">
                <?= esc(session('success')) ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('admin/login') ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="username">管理員帳號：</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    value="<?= old('username') ?>" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">密碼：</label>
                <div class="password-wrapper">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword('password', this)" aria-label="顯示密碼">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="primary-button">
                登入
            </button>
        </form>
    </main>

    <script src="<?= base_url('JS/register.js') ?>"></script>
</body>

</html>