<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>考生註冊</title>
</head>
<body>

    <h1>考生註冊</h1>

    <?php if (isset($validation)): ?>
        <div>
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>

    <?php if (isset($captchaError)): ?>
        <div>
            <?= esc($captchaError) ?>
        </div>
    <?php endif; ?>

    <form method="post" action="/register">

        <div>
            <label for="exam_number">學測應試號碼：</label>
            <input
                type="text"
                id="exam_number"
                name="exam_number"
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
            <input
                type="text"
                id="captcha"
                name="captcha"
                required
            >
            <span>1234</span>
        </div>

        <br>

        <button type="submit">註冊</button>

    </form>

</body>
</html>