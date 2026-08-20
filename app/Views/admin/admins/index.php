<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <title>管理員管理</title>
</head>

<body>

    <h1>管理員管理</h1>

    <p>
        <a href="<?= site_url('admin') ?>">
            返回後臺首頁
        </a>
    </p>

    <?php if (empty($admins)): ?>

        <p>目前沒有管理員資料。</p>

    <?php else: ?>

        <table border="1" cellpadding="8" cellspacing="0">

            <thead>
                <tr>
                    <th>編號</th>
                    <th>管理員帳號</th>
                    <th>姓名</th>
                    <th>角色</th>
                    <th>狀態</th>
                    <th>建立時間</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($admins as $admin): ?>

                    <tr>

                        <td>
                            <?= esc($admin['id']) ?>
                        </td>

                        <td>
                            <?= esc($admin['username']) ?>
                        </td>

                        <td>
                            <?= esc($admin['name']) ?>
                        </td>

                        <td>
                            <?= esc($admin['role']) ?>
                        </td>

                        <td>
                            <?= esc($admin['status']) ?>
                        </td>

                        <td>
                            <?= esc($admin['created_at'] ?? '') ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php endif; ?>

</body>

</html>