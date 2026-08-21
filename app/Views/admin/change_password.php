<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <title>修改管理員密碼</title>
</head>

<body>

    <h1>修改管理員密碼</h1>

    <p>
        為了帳號安全，第一次登入必須先修改預設密碼。
    </p>

    <?php if (session()->has('errors')): ?>

        <div style="color: red;">

            <?php foreach (session('errors') as $error): ?>

                <p><?= esc($error) ?></p>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>


    <form
        action="<?= site_url('admin/change-password') ?>"
        method="post"
    >

        <?= csrf_field() ?>

        <p>

            <label for="password">
                新密碼：
            </label>

            <input
                type="password"
                id="password"
                name="password"
                required
            >

        </p>


        <p>

            <label for="password_confirm">
                確認新密碼：
            </label>

            <input
                type="password"
                id="password_confirm"
                name="password_confirm"
                required
            >

        </p>


        <button type="submit">
            修改密碼
        </button>

    </form>

</body>

</html>