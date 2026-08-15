<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>查詢校系資料</title>
</head>

<body>
    <h1>查詢校系資料</h1>
    <?php if (empty($departments)): ?>
        <p>目前沒有校系資料。</p>
    <?php else: ?>
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>學校名稱</th>
                    <th>校系名稱</th>
                    <th>公私立</th>
                    <th>地區</th>
                    <th>學群</th>
                    <th>招生名額</th>
                    <th>備註</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($departments as $department): ?>
                    <tr>
                        <td>
                            <?= esc($department['university_name']) ?>
                        </td>
                        <td>
                            <?= esc($department['department_name']) ?>
                        </td>
                        <td>
                            <?= esc($department['public_private']) ?>
                        </td>
                        <td>
                            <?= esc($department['location']) ?>
                        </td>
                        <td>
                            <?= esc($department['college_group']) ?>
                        </td>
                        <td>
                            <?= esc($department['admission_quota']) ?>
                        </td>
                        <td>
                            <?= esc($department['description']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <br>
    <a href="<?= site_url('apply') ?>">
        返回網路報名系統
    </a>
</body>

</html>