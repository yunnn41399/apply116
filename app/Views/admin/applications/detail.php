<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <title>報名資料詳細內容</title>
</head>

<body>

<h1>報名資料詳細內容</h1>

<p>
    <a href="<?= site_url('admin/applications') ?>">
        返回報名資料列表
    </a>
</p>

<hr>

<h2>考生資料</h2>

<table border="1" cellpadding="8" cellspacing="0">

    <tr>
        <th>考生姓名</th>
        <td><?= esc($application['name']) ?></td>
    </tr>

    <tr>
        <th>准考證號</th>
        <td><?= esc($application['exam_number']) ?></td>
    </tr>

    <tr>
        <th>身分證字號</th>
        <td><?= esc($application['id_number']) ?></td>
    </tr>

</table>

<br>

<h2>報名基本資料</h2>

<table border="1" cellpadding="8" cellspacing="0">

    <tr>
        <th>出生年月日</th>
        <td><?= esc($application['birth_date']) ?></td>
    </tr>

    <tr>
        <th>手機號碼</th>
        <td><?= esc($application['phone']) ?></td>
    </tr>

    <tr>
        <th>通訊地址</th>
        <td><?= esc($application['address']) ?></td>
    </tr>

    <tr>
        <th>目前就讀學校</th>
        <td><?= esc($application['current_school']) ?></td>
    </tr>

</table>

<br>

<h2>資料紀錄</h2>

<table border="1" cellpadding="8" cellspacing="0">

    <tr>
        <th>資料建立時間</th>
        <td><?= esc($application['created_at'] ?? '') ?></td>
    </tr>

    <tr>
        <th>最後編輯時間</th>
        <td><?= esc($application['updated_at'] ?? '') ?></td>
    </tr>

</table>

<hr>

<!-- 未來可以在這裡加入志願資料 -->

<h2>志願選填</h2>

<p>
    目前尚未加入志願選填資料。
</p>

</body>

</html>