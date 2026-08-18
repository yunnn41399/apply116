<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>管理員登入</title>
</head>
<body>

<h1>管理員登入</h1>

<?php if (session()->has('error')): ?>
    <div style="color: red;">
        <?= esc(session('error')) ?>
    </div>
<?php endif; ?>

<?php if (session()->has('errors')): ?>
    <div style="color: red;">
        <?php foreach (session('errors') as $error): ?>
            <p><?= esc($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (session()->has('success')): ?>
    <div style="color: green;">
        <?= esc(session('success')) ?>
    </div>
<?php endif; ?>

<form action="<?= site_url('admin/login') ?>" method="post">

    <?= csrf_field() ?>

    <div>
        <label for="username">管理員帳號：</label>
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
        <label for="password">密碼：</label>
        <input
            type="password"
            id="password"
            name="password"
            required
        >
    </div>

    <br>

    <button type="submit">登入</button>

</form>

</body>
</html>