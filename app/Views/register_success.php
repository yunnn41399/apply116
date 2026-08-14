<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>註冊完成</title>
</head>
<body>

    <h1>註冊完成</h1>

    <p>
        <strong style="font-size: 24px;">
            <?= esc($name) ?>
        </strong>
        ，您好！
    </p>

    <p>恭喜您，考生帳號已註冊成功！</p>

    <p>請使用您的學測應試號碼、身分證號碼及個人密碼登入網路報名系統。</p>

    <p>
        <a href="<?= base_url('login') ?>">前往登入系統</a>
        &nbsp;&nbsp;|&nbsp;&nbsp;
        <a href="<?= base_url('/') ?>">回到首頁</a>
    </p>

</body>
</html>