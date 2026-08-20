<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <title>新增管理員</title>
</head>

<body>

    <h1>新增管理員</h1>

    <p>
        <a href="<?= site_url('admin/admins') ?>">
            返回管理員列表
        </a>
    </p>

    <?php if (session()->has('error')): ?>

        <p>
            <?= esc(session('error')) ?>
        </p>

    <?php endif; ?>


    <?php if (session()->has('errors')): ?>

        <div>

            <?php foreach (session('errors') as $error): ?>

                <p>
                    <?= esc($error) ?>
                </p>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>


    <form
        method="post"
        action="<?= site_url('admin/admins/create') ?>"
    >

        <?= csrf_field() ?>


        <div>

            <label for="username">
                管理員帳號
            </label>

            <input
                type="text"
                id="username"
                name="username"
                value="<?= old('username') ?>"
                required
            >

        </div>

        <br>


        <div>

            <label for="password">
                密碼
            </label>

            <input
                type="password"
                id="password"
                name="password"
                required
            >

        </div>

        <br>


        <div>

            <label for="password_confirm">
                確認密碼
            </label>

            <input
                type="password"
                id="password_confirm"
                name="password_confirm"
                required
            >

        </div>

        <br>


        <div>

            <label for="name">
                管理員姓名
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="<?= old('name') ?>"
                required
            >

        </div>

        <br>


        <div>

            <label for="role">
                管理員角色
            </label>

            <select
                id="role"
                name="role"
                required
            >

                <option
                    value="admin"
                    <?= old('role') === 'admin' ? 'selected' : '' ?>
                >
                    一般管理員
                </option>

                <option
                    value="super_admin"
                    <?= old('role') === 'super_admin' ? 'selected' : '' ?>
                >
                    最高管理員
                </option>

            </select>

        </div>

        <br>


        <div>

            <label for="status">
                帳號狀態
            </label>

            <select
                id="status"
                name="status"
                required
            >

                <option
                    value="active"
                    <?= old('status', 'active') === 'active' ? 'selected' : '' ?>
                >
                    啟用
                </option>

                <option
                    value="inactive"
                    <?= old('status') === 'inactive' ? 'selected' : '' ?>
                >
                    停用
                </option>

            </select>

        </div>

        <br>


        <button type="submit">
            新增管理員
        </button>

    </form>

</body>

</html>