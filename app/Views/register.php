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

    <title>考生註冊</title>
</head>

<body>

    <!-- 網站標題列 -->
    <header class="page-header">
        <a href="<?= base_url('/') ?>" class="page-header-link">
            <h1>Apply 116</h1>
        </a>
    </header>

    <main class="form-container register-container">

        <h2>考生註冊</h2>

        <!-- 顯示欄位驗證錯誤 -->
        <?php $registerErrors = session()->getFlashdata('registerErrors'); ?>

        <?php if (! empty($registerErrors)): ?>
            <div class="error-message">
                <?php foreach ($registerErrors as $error): ?>
                    <p><?= esc($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>


        <form method="post" action="<?= site_url('register') ?>">

            <?= csrf_field() ?>


            <!-- 考生姓名 -->
            <div class="form-group">
                <label for="name">
                    考生姓名（Name）：
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="<?= old('name') ?>"
                    maxlength="50"
                    required
                >
            </div>


            <!-- 學測應試號碼 -->
            <div class="form-group">
                <label for="exam_number">
                    學測應試號碼（Registration Number）：
                </label>

                <input
                    type="text"
                    id="exam_number"
                    name="exam_number"
                    value="<?= old('exam_number') ?>"
                    maxlength="8"
                    minlength="8"
                    pattern="[0-9]{8}"
                    inputmode="numeric"
                    placeholder="共 8 碼、純數字"
                    required
                >
            </div>


            <!-- 身分證號碼 -->
            <div class="form-group">
                <label for="id_number">
                    身分證號碼（National ID Number）：
                </label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        id="id_number"
                        name="id_number"
                        value="<?= old('id_number') ?>"
                        maxlength="10"
                        required
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        onclick="togglePassword('id_number', this)"
                        aria-label="顯示身份證號碼"
                    >
                        <i class="bi bi-eye"></i>
                    </button>

                </div>

            </div>


            <!-- 個人密碼 -->
            <div class="form-group">
                <label for="password">
                    個人密碼（Password）：
                </label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="至少 8 碼、大小寫英數混合"
                        required
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        onclick="togglePassword('password', this)"
                        aria-label="顯示密碼"
                    >
                        <i class="bi bi-eye"></i>
                    </button>

                </div>


                <!-- 密碼規則 -->
                <div id="password-rules" class="password-rules">

                    <p>密碼規則：</p>

                    <div id="rule-length" class="password-rule rule-invalid">
                        <span class="rule-icon">✗</span>
                        至少 8 個字元
                    </div>

                    <div id="rule-uppercase" class="password-rule rule-invalid">
                        <span class="rule-icon">✗</span>
                        至少 1 個大寫英文字母
                    </div>

                    <div id="rule-lowercase" class="password-rule rule-invalid">
                        <span class="rule-icon">✗</span>
                        至少 1 個小寫英文字母
                    </div>

                    <div id="rule-number" class="password-rule rule-invalid">
                        <span class="rule-icon">✗</span>
                        至少 1 個數字
                    </div>

                </div>
            </div>


            <!-- 確認密碼 -->
            <div class="form-group">
                <label for="password_confirm">
                    確認密碼（Confirm Password）：
                </label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        id="password_confirm"
                        name="password_confirm"
                        required
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        onclick="togglePassword('password_confirm', this)"
                        aria-label="顯示確認密碼"
                    >
                        <i class="bi bi-eye"></i>
                    </button>

                </div>

                <div id="password-match" class="password-match"></div>

            </div>

            <!-- 驗證碼 -->
            <div class="form-group captcha-group">

                <label for="captcha">
                    驗證碼（Verification Code）：
                </label>

                <div class="captcha-wrapper">

                    <input
                        type="text"
                        id="captcha"
                        name="captcha"
                        maxlength="4"
                        minlength="4"
                        autocomplete="off"
                        placeholder="不分大小寫"
                        required
                    >

                    <canvas
                        id="registerCaptcha"
                        class="captcha-canvas"
                        width="160"
                        height="50"
                        data-captcha="<?= esc($captcha) ?>"
                        data-refresh-url="<?= site_url('register/refresh-captcha') ?>"
                        data-csrf-header="<?= csrf_header() ?>"
                        data-csrf-hash="<?= csrf_hash() ?>"
                        data-input-id="captcha"
                    ></canvas>

                    <button 
                        type="button" 
                        id="btnRefreshCaptcha" 
                        class="refresh-captcha">
                        重新產生
                    </button>

                </div>

            </div>


            <!-- 註冊按鈕 -->
            <div class="form-actions">

                <button
                    type="submit"
                    class="primary-button"
                >
                    註冊
                </button>

            </div>

        </form>

    </main>


    <script src="<?= base_url('JS/register.js') ?>"></script>

</body>
</html>