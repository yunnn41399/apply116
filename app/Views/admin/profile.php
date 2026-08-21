<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <title>我的帳號</title>
</head>

<body>

    <?php include APPPATH . 'Views/admin/header.php'; ?>

    <h1>我的帳號</h1>

    <?php if (session()->has('success')): ?>

        <p style="color: green;">
            <?= esc(session('success')) ?>
        </p>

    <?php endif; ?>


    <?php if (session()->has('error')): ?>

        <p style="color: red;">
            <?= esc(session('error')) ?>
        </p>

    <?php endif; ?>


    <?php if (session()->has('errors')): ?>

        <div style="color: red;">

            <?php foreach (session('errors') as $error): ?>

                <p>
                    <?= esc($error) ?>
                </p>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>


    <form
        action="<?= site_url('admin/profile') ?>"
        method="post"
    >

        <?= csrf_field() ?>


        <!-- 管理員帳號 -->
        <p>

            <label for="username">
                管理員帳號：
            </label>

            <span><?= esc($admin['username']) ?></span>

        </p>


        <!-- 管理員姓名 -->
        <p>

            <label for="name">
                管理員姓名：
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="<?= esc(old('name', $admin['name'])) ?>"
                maxlength="50"
                required
            >

        </p>


        <!-- 管理員角色 -->
        <p>

            <label>
                管理員角色：
            </label>

            <?php if ($admin['role'] === 'super_admin'): ?>

                最高管理員

            <?php else: ?>

                一般管理員

            <?php endif; ?>

        </p>


        <!-- 帳號狀態 -->
        <p>

            <label>
                帳號狀態：
            </label>

            <?php if ($admin['status'] === 'active'): ?>

                啟用

            <?php else: ?>

                停用

            <?php endif; ?>

        </p>


        <!-- 新密碼 -->
        <p>

            <label for="password">
                新密碼：
            </label>

            <input
                type="password"
                id="password"
                name="password"
                minlength="8"
                maxlength="255"
                autocomplete="new-password"
            >

            <br>

            <small>
                如果不需要修改密碼，請留空。
            </small>

        </p>


        <!-- 確認新密碼 -->
        <p>

            <label for="password_confirm">
                確認新密碼：
            </label>

            <input
                type="password"
                id="password_confirm"
                name="password_confirm"
                minlength="8"
                maxlength="255"
                autocomplete="new-password"
            >

        </p>

        <button type="submit">
            儲存修改
        </button>

    </form>

</body>

</html>