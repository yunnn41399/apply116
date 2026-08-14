<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/login.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>網路報名系統登入</title>
</head>

<body>
    <header class="page-header">
        <h1>Apply116</h1>
    </header>
    <main class="form-container">
        <h2>考生登入</h2>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="error-message">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="success-message">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>
        <form action="<?= site_url('login') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="exam_number">
                    學測應試號碼：
                </label>
                <input type="text" id="exam_number" name="exam_number" value="<?= esc(
                    session()->getFlashdata('old_exam_number') ?? ''
                ) ?>" required>
            </div>
            <div class="form-group">
                <label for="id_last_four">
                    身分證號碼：
                </label>
                <div class="password-wrapper">
                    <input type="password" id="id_last_four" name="id_last_four" value="<?= old('id_last_four') ?>"
                        maxlength="4" pattern="[0-9]{4}" inputmode="numeric" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('id_last_four', this)"
                        aria-label="顯示身分證末四碼">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <span class="input-hint">
                    （請輸入末四碼）
                </span>
            </div>
            <div class="form-group">
                <label for="password">
                    個人密碼：
                </label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password', this)"
                        aria-label="顯示密碼">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            <div class="form-group captcha-group">
                <label for="captcha">
                    驗證碼：
                </label>
                <div class="captcha-wrapper">
                    <input type="text" id="captcha" name="captcha" maxlength="4" required>
                    <canvas id="loginCaptcha" class="captcha-canvas" width="160" height="50"
                        data-captcha="<?= esc($captcha) ?>" data-refresh-url="<?= site_url('login/refresh-captcha') ?>"
                        data-input-id="captcha"></canvas>
                    <button type="button" id="refreshCaptcha" class="refresh-captcha">
                        重新產生
                    </button>
                </div>
            </div>
            <div style="text-align: center;">
                <button type="submit" class="primary-button">
                    登入
                </button>
            </div>
        </form>
        <div class="form-links">
            <a href="<?= base_url('forgot-password') ?>">
                忘記密碼 / 重設密碼
            </a>
        </div>
    </main>
    <script src="<?= base_url('JS/login.js') ?>"></script>
</body>

</html>