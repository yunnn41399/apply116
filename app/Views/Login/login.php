<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>考生登入</title>
</head>

<body>

    <h1>網路報名系統</h1>

    <h2>考生登入</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color: red;">
            <?= esc(session()->getFlashdata('error')) ?>
        </p>
    <?php endif; ?>

    <form action="<?= site_url('login') ?>" method="post">

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
            <label for="captcha">驗證碼：</label>
            <input
                type="text"
                id="captcha"
                name="captcha"
                required
            >

            <span style="font-weight: bold; font-size: 20px;">
                <?= esc($captcha) ?>
            </span>
        </div>

        <br>

        <button type="submit">登入</button>

    </form>

    <br>

    <a href="#">忘記密碼？</a>

</body>
</html>
