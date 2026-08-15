<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>新增公告</title>
</head>
<body>

<h1>新增公告</h1>

<form action="" method="post" enctype="multipart/form-data">

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
            <option value="簡章訊息事項">簡章訊息事項</option>
            <option value="招生試務">招生試務</option>
            <option value="甄選資訊">甄選資訊</option>
            <option value="會議簡報">會議簡報</option>
            <option value="其他事項">其他事項</option>
            <option value="系统公告">系统公告</option>
            <option value="師資保送甄試">師資保送甄試</option>
            <option value="醫事人員養成計畫">醫事人員養成計畫</option>
        </select>
    </div>

    <br>

    <!-- 公告類型 -->
    <div>
        <label for="type">公告類型：</label>
        <select id="type" name="type">
            <option value="">請選擇公告類型</option>
            <option value="純文字">純文字</option>
            <option value="PDF文件">PDF文件</option>
            <option value="超連結">超連結</option>
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

    <!-- 附件 -->
    <div>
        <label for="attachment">附件：</label>
        <input
            type="file"
            id="attachment"
            name="attachment"
            accept=".pdf"
        >
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

    <!-- 發布日期 -->
    <div>
        <label for="publish_date">發布日期：</label>
        <input
            type="datetime-local"
            id="publish_date"
            name="publish_date"
            value="<?= old('publish_date') ?>"
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