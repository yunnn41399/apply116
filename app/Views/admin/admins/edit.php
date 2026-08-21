<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <title>編輯管理員</title>
</head>

<body>

    <h1>編輯管理員</h1>

    <p>
        <a href="<?= site_url('admin/admins') ?>">
            返回管理員列表
        </a>
    </p>


    <?php if (session()->has('error')): ?>

        <div>
            <p>
                <?= esc(session('error')) ?>
            </p>
        </div>

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
        action="<?= site_url('admin/admins/edit/' . $admin['id']) ?>"
    >

        <?= csrf_field() ?>


        <!-- 管理員帳號 -->

        <div>

            <label>
                管理員帳號
            </label>

            <span><?= esc($admin['username']) ?></span>

        </div>

        <br>


        <!-- 姓名 -->

        <div>

            <label for="name">
                管理員姓名
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="<?= old('name', $admin['name']) ?>"
                required
            >

        </div>

        <br>


        <!-- 角色 -->

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
                    <?= old('role', $admin['role']) === 'admin' ? 'selected' : '' ?>
                >
                    一般管理員
                </option>

                <option
                    value="super_admin"
                    <?= old('role', $admin['role']) === 'super_admin' ? 'selected' : '' ?>
                >
                    最高管理員
                </option>

            </select>

        </div>

        <br>


        <!-- 狀態 -->

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
                    <?= old('status', $admin['status']) === 'active' ? 'selected' : '' ?>
                >
                    啟用
                </option>

                <option
                    value="inactive"
                    <?= old('status', $admin['status']) === 'inactive' ? 'selected' : '' ?>
                >
                    停用
                </option>

            </select>

        </div>

        <br>


        <hr>


        <!-- 修改密碼 -->

        <h2>修改密碼</h2>

        <p>
            如果不需要修改密碼，以下欄位可以留空。
        </p>


        <div>

            <label for="password">
                新密碼
            </label>

            <input
                type="password"
                id="password"
                name="password"
            >

        </div>

        <br>


        <div>

            <label for="password_confirm">
                確認新密碼
            </label>

            <input
                type="password"
                id="password_confirm"
                name="password_confirm"
            >

        </div>

        <br>


        <button type="submit">
            儲存修改
        </button>

    </form>

</body>

</html>