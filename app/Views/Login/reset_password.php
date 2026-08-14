<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/login.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>設定新密碼</title>
</head>

<body>
    <header class="page-header">
        <h1>Apply116</h1>
    </header>
    <main class="form-container">
        <h2>設定新密碼</h2>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="error-message">
                <?= esc(
                    session()->getFlashdata('error')
                ) ?>
            </div>
        <?php endif; ?>
        <form action="<?= site_url('reset-password/update') ?>" method="post" id="resetPasswordForm">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="password">
                    新密碼：
                </label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password', this)"
                        aria-label="顯示新密碼">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            <div id="password-rules" class="password-rules">
                <p>密碼規則：</p>
                <div id="rule-length" class="password-rule rule-invalid">
                    <span class="rule-icon">
                        ✗
                    </span>
                    至少 8 個字元
                </div>
                <div id="rule-uppercase" class="password-rule rule-invalid">
                    <span class="rule-icon">
                        ✗
                    </span>
                    至少 1 個大寫英文字母
                </div>
                <div id="rule-lowercase" class="password-rule rule-invalid">
                    <span class="rule-icon">
                        ✗
                    </span>
                    至少 1 個小寫英文字母
                </div>
                <div id="rule-number" class="password-rule rule-invalid">
                    <span class="rule-icon">
                        ✗
                    </span>
                    至少 1 個數字
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="password_confirm">
                    確認新密碼：
                </label>
                <div class="password-wrapper">
                    <input type="password" id="password_confirm" name="password_confirm" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirm', this)"
                        aria-label="顯示確認密碼">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            <div id="password-match" class="password-match"></div>
            <br>
            <button type="submit" class="primary-button">
                確認修改密碼
            </button>
        </form>
        <div class="form-links">
            <a href="<?= base_url('login') ?>">
                返回登入
            </a>
        </div>
    </main>
    <script src="<?= base_url('JS/login.js') ?>"></script>
</body>

</html>