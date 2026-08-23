<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>考生資料</title>
</head>

<body>

<h1>考生詳細資料</h1>

<p>
    <a href="<?= site_url('admin/candidates') ?>">
        返回考生資料列表
    </a>
</p>

<hr>

<table border="1" cellpadding="8" cellspacing="0">

    <tr>
        <th>編號</th>
        <td><?= esc($candidate['id']) ?></td>
    </tr>

    <tr>
        <th>考生姓名</th>
        <td><?= esc($candidate['name']) ?></td>
    </tr>

    <tr>
        <th>學測應試號碼</th>
        <td><?= esc($candidate['exam_number']) ?></td>
    </tr>

    <tr>
        <th>身分證字號</th>
        <td><?= esc($candidate['id_number']) ?></td>
    </tr>

    <tr>
        <th>註冊時間</th>
        <td><?= esc($candidate['created_at'] ?? '') ?></td>
    </tr>

    <tr>
        <th>最後更新時間</th>
        <td><?= esc($candidate['updated_at'] ?? '') ?></td>
    </tr>

</table>

</body>
</html>