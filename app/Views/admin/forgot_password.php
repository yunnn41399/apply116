<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/register.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/admin.css') ?>">

    <title>忘記密碼</title>
</head>

<body>

<header class="page-header">
    <h1>Apply116 後臺管理</h1>
</header>

<main class="form-container">

    <h2>忘記密碼</h2>

    <!-- 錯誤訊息 -->
    <?php if (session()->has('error')): ?>

        <div class="error-message">
            <?= esc(session('error')) ?>
        </div>

    <?php endif; ?>


    <!-- 驗證錯誤 -->
    <?php if (session()->has('errors')): ?>

        <div class="error-message">

            <?php foreach (session('errors') as $error): ?>

                <p style="margin: 0;">
                    <?= esc($error) ?>
                </p>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>


    <!-- 成功訊息 -->
    <?php if (session()->has('success')): ?>

        <div class="success-message">
            <?= esc(session('success')) ?>
        </div>

    <?php endif; ?>


    <form
        action="<?= site_url('admin/forgot-password') ?>"
        method="post"
    >

        <?= csrf_field() ?>


        <!-- 管理員帳號 -->

        <div class="form-group">

            <label for="username">
                管理員帳號：
            </label>

            <input
                type="text"
                id="username"
                name="username"
                value="<?= old('username') ?>"
                required
            >

        </div>


        <!-- Email -->

        <div class="form-group">

            <label for="email">
                Email：
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="<?= old('email') ?>"
                required
            >

        </div>


        <!-- CAPTCHA -->

        <div class="form-group">

            <label for="captcha">
                驗證碼：
            </label>

            <div class="captcha-wrapper">

                <input
                    type="text"
                    id="captcha"
                    name="captcha"
                    required
                    autocomplete="off"
                    placeholder="不分大小寫"
                >
                
                <canvas
                    id="adminForgotCaptcha"
                    width="120"
                    height="40"
                    data-captcha="<?= esc($captcha) ?>"
                    data-refresh-url="<?= site_url('admin/forgot-password/refresh-captcha') ?>"
                    title="點擊重新產生驗證碼"
                    class="captcha-canvas"
                ></canvas>

                <button
                    type="button"
                    id="btnRefreshAdminForgotCaptcha"
                    class="refresh-captcha"
                >
                    重新產生
                </button>

            </div>

        </div>

        <div class="form-actions">
            <button
                type="submit"
                class="primary-button"
            >
                寄送重設密碼連結
            </button>
        </div>
        
    </form>


    <!-- 返回登入 -->

    <div class="form-links">

        <a href="<?= site_url('admin/login') ?>">
            返回管理員登入
        </a>

    </div>

</main>

<script src="<?= base_url('JS/admin-forgot-password.js') ?>"></script>

</body>

</html>