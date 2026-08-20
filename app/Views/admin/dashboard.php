<!DOCTYPE html>
<html lang="zh-Hant">
    <head>
        <meta charset="UTF-8">
        <title>後臺管理首頁</title>
    </head>
    <body>

        <h1>後臺管理系統</h1>

        <?php
        $adminName = session()->get('admin_name') ?? '管理員';
        ?>

        <p>
            歡迎，<?= esc($adminName) ?>
        </p>

        <hr>

        <h2>功能選單</h2>

        <ul>
            <?php if (session()->get('admin_role') === 'super_admin'): ?>

                <li>
                    <a href="<?= site_url('admin/admins') ?>">
                        管理員帳號管理
                    </a>
                </li>

            <?php endif; ?>

            <li>
                <a href="<?= site_url('admin/announcement') ?>">
                    公告管理
                </a>
            </li>

            <li>
                <a href="<?= site_url('admin/candidates') ?>">
                    考生資料
                </a>
            </li>

            <li>
                <a href="<?= site_url('admin/applications') ?>">
                    報名資料
                </a>
            </li>

            <li>
                <a href="#">
                    首頁內容
                </a>
            </li>
        </ul>

        <hr>

        <form action="<?= site_url('admin/logout') ?>" method="post">
            <?= csrf_field() ?>
            <button type="submit">登出</button>
        </form>

    </body>
</html>