<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
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
            <input
                type="password"
                id="password"
                name="password"
                required
            >
        </div>

        <br>

        <div>
            <label for="password_confirm">確認密碼：</label>
            <input
                type="password"
                id="password_confirm"
                name="password_confirm"
                required
            >
        </div>

        <br>

        <div>
            <label for="captcha">驗證碼：</label>
            <input type="text" id="captcha" name="captcha" required>
            <img src="<?= base_url('captcha') ?>" id="captcha-img" alt="驗證碼">
            
            <button type="button" onclick="refreshCaptcha()">重新產生</button>
        </div>

        <br>

        <button type="submit">註冊</button>

    </form>

    <script>
        function refreshCaptcha() {
            // 透過加上時間戳記 (timestamp)，迫使瀏覽器向 Captcha 控制器發送請求並更新 Session 中的驗證碼
            document.getElementById('captcha-img').src = '<?= base_url('captcha') ?>?' + new Date().getTime();
        }
    </script>

</body>
</html>