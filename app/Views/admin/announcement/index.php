<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>後臺公告管理</title>
</head>
<body>

<h1>公告管理</h1>

<table border="1">
    <thead>
        <tr>
            <th>公告標題</th>
            <th>最後編輯時間</th>
            <th>發布時間</th>
            <th>發布狀態</th>
            <th>操作</th>
        </tr>
    </thead>

    <tbody>
        <?php if (empty($announcements)): ?>

            <tr>
                <td colspan="5">目前沒有公告。</td>
            </tr>

        <?php else: ?>

            <?php foreach ($announcements as $announcement): ?>

                <tr>
                    <td>
                        <?= esc($announcement['title']) ?>
                    </td>

                    <td>
                        <?= esc($announcement['updated_at'] ?? '') ?>
                    </td>

                    <td>
                        <?= esc($announcement['publish_date'] ?? '') ?>
                    </td>

                    <td>
                        <?php if ($announcement['status'] === 'published'): ?>
                            已發布
                        <?php else: ?>
                            草稿
                        <?php endif; ?>
                    </td>

                    <td>
                        <a href="#">
                            編輯公告
                        </a>
                    </td>
                </tr>

            <?php endforeach; ?>

        <?php endif; ?>
    </tbody>
</table>

</body>
</html>