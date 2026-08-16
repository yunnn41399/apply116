<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>新增公告</title>
</head>
<body>

<h1>新增公告</h1>

<?php if (session()->has('errors')): ?>
    <div style="color: red;">
        <?php foreach (session('errors') as $error): ?>
            <p><?= esc($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="<?= site_url('admin/announcement/create') ?>" method="post" enctype="multipart/form-data">

    <?= csrf_field() ?>
    
    <!-- 公告標題 -->
    <div>
        <label for="title">公告標題：</label>
        <input
            type="text"
            id="title"
            name="title"
            value="<?= old('title') ?>"
        >
    </div>

    <br>

    <!-- 公告類別 -->
    <div>
        <label for="category">公告類別：</label>
        <select id="category" name="category">
            <option value="">請選擇公告類別</option>
            <option value="簡章訊息事項" <?= old('category') === '簡章訊息事項' ? 'selected' : '' ?>>簡章訊息事項</option>
            <option value="招生試務" <?= old('category') === '招生試務' ? 'selected' : '' ?>>招生試務</option>
            <option value="甄選資訊" <?= old('category') === '甄選資訊' ? 'selected' : '' ?>>甄選資訊</option>
            <option value="會議簡報" <?= old('category') === '會議簡報' ? 'selected' : '' ?>>會議簡報</option>
            <option value="其他事項" <?= old('category') === '其他事項' ? 'selected' : '' ?>>其他事項</option>
            <option value="系統公告" <?= old('category') === '系統公告' ? 'selected' : '' ?>>系統公告</option>
            <option value="師資保送甄試" <?= old('category') === '師資保送甄試' ? 'selected' : '' ?>>師資保送甄試</option>
            <option value="醫事人員養成計畫" <?= old('category') === '醫事人員養成計畫' ? 'selected' : '' ?>>醫事人員養成計畫</option>
        </select>
    </div>

    <br>

    <!-- 公告類型 -->
    <div>
        <label for="type">公告類型：</label>
        <select id="type" name="type">
            <option value="">請選擇公告類型</option>
            <option value="一般公告" <?= old('type') === '一般公告' ? 'selected' : '' ?>>一般公告</option>
            <option value="純檔案" <?= old('type') === '純檔案' ? 'selected' : '' ?>>純檔案</option>
            <option value="超連結" <?= old('type') === '超連結' ? 'selected' : '' ?>>超連結</option>
        </select>
    </div>

    <br>

    <!-- 公告內容 -->
    <div>
        <label for="content">公告內容：</label>
        <br>
        <textarea
            id="content"
            name="content"
            rows="8"
            cols="50"
        ><?= old('content') ?></textarea>
    </div>

    <br>

    <!-- 附件欄位 -->
    <div>
        <label for="attachment">附件上傳：</label>
        <input
            type="file"
            id="attachment"
            name="attachment"
            accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar,.png,.jpg,.jpeg"
        >
        <small style="color: #666;">（支援 PDF、Word、Excel、PPT、圖片及壓縮檔，上限 10MB）</small>
    </div>

    <br>

    <!-- 外部網址 -->
    <div>
        <label for="external_url">外部網址：</label>
        <input
            type="url"
            id="external_url"
            name="external_url"
            value="<?= old('external_url') ?>"
        >
    </div>

    <br>

    <button type="submit" name="status" value="draft">
        暫存
    </button>

    <button type="submit" name="status" value="published">
        發布
    </button>

</form>

</body>
</html>