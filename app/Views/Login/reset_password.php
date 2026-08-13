<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>設定新密碼</title>
</head>

<body>

    <h1>網路報名系統</h1>

    <h2>設定新密碼</h2>


    <!-- 顯示錯誤訊息 -->
    <?php if (session()->getFlashdata('error')): ?>

        <div style="color: red;">

            <?= esc(session()->getFlashdata('error')) ?>

        </div>

    <?php endif; ?>


    <!-- 設定新密碼 -->
    <form
        action="<?= site_url('reset-password/update') ?>"
        method="post"
    >

        <?= csrf_field() ?>


        <!-- 新密碼 -->
        <div>

            <label for="password">
                新密碼：
            </label>

            <input
                type="password"
                id="password"
                name="password"
                required
            >

        </div>

        <br>


        <!-- 密碼規則 -->
        <div>

            <p>密碼規則：</p>

            <ul>

                <li>
                    至少 8 個字元
                </li>

                <li>
                    至少 1 個大寫英文字母
                </li>

                <li>
                    至少 1 個小寫英文字母
                </li>

                <li>
                    至少 1 個數字
                </li>

            </ul>

        </div>

        <br>


        <!-- 確認新密碼 -->
        <div>

            <label for="password_confirm">
                確認新密碼：
            </label>

            <input
                type="password"
                id="password_confirm"
                name="password_confirm"
                required
            >

        </div>

        <br>


        <button type="submit">
            確認修改密碼
        </button>

    </form>


    <br>


    <a href="<?= base_url('login') ?>">
        返回登入
    </a>

</body>

</html>