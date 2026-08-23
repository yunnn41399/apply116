<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/login.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>忘記密碼</title>
</head>

<body>
    <header class="page-header">
        <a href="<?= base_url('/') ?>" class="page-header-link">
            <h1>Apply 116</h1>
        </a>
    </header>
    <main class="form-container">
        <h2>忘記密碼</h2>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="error-message">
                <?= esc(
                    session()->getFlashdata('error')
                ) ?>
            </div>
        <?php endif; ?>
        <form action="<?= site_url('forgot-password/verify') ?>" method="post">
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
                <label for="id_number">
                    身分證號碼：
                </label>
                <div class="password-wrapper">
                    <input type="password" id="id_number" name="id_number" maxlength="10" minlength="10"
                        pattern="[A-Z][12][0-9]{8}" inputmode="text" autocomplete="off" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('id_number', this)"
                        aria-label="顯示身分證號碼">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            <div class="form-group captcha-group">
                <label for="captcha">
                    驗證碼：
                </label>
                <div class="captcha-wrapper">
                    <input type="text" id="captcha" name="captcha" maxlength="4" placeholder="不分大小寫" required>
                    <canvas id="forgotCaptcha" class="captcha-canvas" width="160" height="50"
                        data-captcha="<?= esc($captcha) ?>" data-refresh-url="<?= site_url('login/refresh-captcha') ?>"
                        data-input-id="captcha"></canvas>
                    <button type="button" id="refreshCaptcha" class="refresh-captcha">
                        重新產生
                    </button>
                </div>
            </div>
            <button type="submit" class="primary-button">
                身分驗證
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