<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/register.css') ?>">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    >

    <title>註冊完成 - Apply116</title>
</head>

<body>

    <header class="page-header">
        <a href="<?= base_url('/') ?>" class="page-header-link">
            <h1>Apply 116</h1>
        </a>
    </header>

    <main class="form-container register-container">

        <h2>註冊完成</h2>

        <!-- 成功訊息區塊 -->
        <div class="success-message" style="text-align: center; margin-bottom: 2rem;">
            <i class="bi bi-check-circle-fill" style="font-size: 3rem; color: #16835a;"></i>
            
            <p style="font-size: 1.25rem; margin-top: 1rem;">
                <strong style="font-size: 1.8rem;"><?= esc($name) ?></strong>，您好！
            </p>

            <p style="font-size: 1rem; color: #4b5563; margin-top: 0.5rem;">
                恭喜您，您的考生帳號已註冊成功！
            </p>

            <p style="color: #6b7280; font-size: 0.85rem; margin-top: 0.5rem;">
                請使用您的學測應試號碼、身分證號碼及個人密碼登入網路報名系統。
            </p>
        </div>

        <!-- 按鈕操作區 (套用系統主要按鈕風格) -->
        <div class="form-actions" style="display: flex; gap: 1rem; justify-content: center;">

            <a href="<?= base_url('login') ?>" class="primary-button" style="text-decoration: none; text-align: center; display: inline-block;">
                前往登入系統
            </a>

            <a href="<?= base_url('/') ?>" class="secondary-button" style="text-decoration: none; text-align: center; display: inline-block; background-color: #f3f4f6; color: #374151; padding: 0.75rem 1.5rem; border-radius: 6px;">
                回到首頁
            </a>

        </div>

    </main>

</body>
</html>