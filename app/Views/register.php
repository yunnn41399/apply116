<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="<?= base_url('CSS/register.css') ?>">

    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    >

    <title>考生註冊</title>
</head>
<body>

    <h1>考生註冊</h1>

    <!-- 1. 顯示欄位驗證錯誤（包含密碼格式不合、密碼不一致、未填寫等） -->
    <?php if (validation_list_errors()): ?>
        <div style="color: red;">
            <?= validation_list_errors() ?>
        </div>
    <?php endif; ?>

    <!-- 2. 顯示驗證碼錯誤 -->
    <?php if (session('captchaError')): ?>
        <div style="color: red;">
            <?= esc(session('captchaError')) ?>
        </div>
    <?php endif; ?>

    <!-- 3. 顯示帳號/身分證重複註冊等自訂錯誤 -->
    <?php if (session('error')): ?>
        <div style="color: red;">
            <?= esc(session('error')) ?>
        </div>
    <?php endif; ?>

    <form method="post" action="/register">
        <!-- CI4 表單安全防護 (建議加上 CSRF 欄位) -->
        <?= csrf_field() ?>

        <div>
            <label for="exam_number">學測應試號碼：</label>
            <input
                type="text"
                id="exam_number"
                name="exam_number"
                value="<?= old('exam_number') ?>"
                required
            >
        </div>

        <br>

        <div>
            <label for="id_number">身分證號碼：</label>
            <input
                type="text"
                id="id_number"
                name="id_number"
                value="<?= old('id_number') ?>"
                required
            >
        </div>

        <br>

        <div>
            <label for="password">個人密碼：</label>

            <div class="password-wrapper">
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >

                <span
                    class="password-toggle"
                    onclick="togglePassword('password', this)"
                    role="button"
                    tabindex="0"
                    aria-label="顯示密碼"
                >
                    <i class="bi bi-eye"></i>
                </span>
            </div>
        </div>

        <br>

        <div>
            <label for="password_confirm">確認密碼：</label>

            <div class="password-wrapper">
                <input
                    type="password"
                    id="password_confirm"
                    name="password_confirm"
                    required
                >

                <span
                    class="password-toggle"
                    onclick="togglePassword('password_confirm', this)"
                    role="button"
                    tabindex="0"
                    aria-label="顯示確認密碼"
                >
                    <i class="bi bi-eye"></i>
                </span>
            </div>
        </div>

        <br>

        <div>
            <label for="captcha">驗證碼：</label>
            <input type="text" id="captcha" name="captcha" required>
            <img
                src="<?= base_url('captcha') ?>"
                id="captcha-img"
                alt="驗證碼"
                data-captcha-url="<?= base_url('captcha') ?>"
            >
            
            <button type="button" onclick="refreshCaptcha()">重新產生</button>
        </div>

        <br>

        <button type="submit">註冊</button>

    </form>

    <script src="<?= base_url('JS/register.js') ?>"></script>
</body>
</html>