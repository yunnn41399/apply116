<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>編輯公告</title>
</head>
<body>

<h1>編輯公告</h1>

<?php if (session()->has('errors')): ?>
    <div style="color: red;">
        <?php foreach (session('errors') as $error): ?>
            <p><?= esc($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form id="editForm" action="<?= site_url('admin/announcement/edit/' . $announcement['id']) ?>" method="post" enctype="multipart/form-data">

    <?= csrf_field() ?>
    
    <div>
        <label for="title">公告標題：</label>
        <input type="text" id="title" name="title" value="<?= old('title', $announcement['title']) ?>">
    </div>
    <br>

    <div>
        <label for="category">公告類別：</label>
        <select id="category" name="category">
            <?php 
                $categories = ['簡章訊息事項', '招生試務', '甄選資訊', '會議簡報', '其他事項', '系統公告', '師資保送甄試', '醫事人員養成計畫'];
                $currentCategory = old('category', $announcement['category']);
            ?>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat ?>" <?= $currentCategory === $cat ? 'selected' : '' ?>><?= $cat ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <br>

    <div>
        <label for="type">公告類型：</label>
        <select id="type" name="type">
            <?php 
                $types = ['一般公告', '純檔案', '超連結'];
                $currentType = old('type', $announcement['type']);
            ?>
            <?php foreach ($types as $t): ?>
                <option value="<?= $t ?>" <?= $currentType === $t ? 'selected' : '' ?>><?= $t ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <br>

    <div>
        <label for="content">公告內容：</label><br>
        <textarea id="content" name="content" rows="8" cols="50"><?= old('content', $announcement['content']) ?></textarea>
    </div>
    <br>

    <!-- 附件欄位 -->
    <div>
        <?php if (!empty($announcement['attachment'])): ?>
            <p>目前附件：<a href="<?= base_url($announcement['attachment']) ?>" target="_blank">預覽舊檔</a></p>
        <?php endif; ?>
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

    <div>
        <label for="external_url">外部網址：</label>
        <input type="url" id="external_url" name="external_url" value="<?= old('external_url', $announcement['external_url']) ?>">
    </div>
    <br>

    <?php if (!empty($announcement['publish_date'])): ?>
        <div>
            <label>上次發布時間：</label>
            <span><?= esc($announcement['publish_date']) ?></span>
            <small style="color: #666;">（更新發布後將自動更新為最新時間）</small>
        </div>
        <br>
    <?php endif; ?>

    <!-- 操作按鈕區塊 -->
    <?php if ($announcement['status'] === 'published'): ?>
        <button type="submit" name="status" value="published">更新並發布</button>
        <span style="color: #666; font-size: 0.9rem;">(已發布之公告無法變更回草稿)</span>
    <?php else: ?>
        <button type="submit" name="status" value="draft">儲存草稿</button>
        <button type="submit" name="status" value="published">發布公告</button>
    <?php endif; ?>

    <!-- 返回按鈕 -->
    <a href="<?= site_url('admin/announcement') ?>" id="btnBack" style="margin-left: 15px;">返回公告列表</a>

</form>

<!-- 變更偵測與提示語句指令碼 -->
<script>
    let isFormDirty = false;
    const form = document.getElementById('editForm');
    const btnBack = document.getElementById('btnBack');

    // 監聽表單內部輸入項，只要有修改就標記為已變更
    form.addEventListener('change', () => {
        isFormDirty = true;
    });
    form.addEventListener('input', () => {
        isFormDirty = true;
    });

    // 正常提交表單時不需要跳出警告
    form.addEventListener('submit', () => {
        isFormDirty = false;
    });

    // 點擊「返回」按鈕時判斷
    btnBack.addEventListener('click', (e) => {
        if (isFormDirty) {
            const confirmLeave = confirm('若返回公告列表，將放棄當前的編輯，確定要離開嗎？');
            if (!confirmLeave) {
                e.preventDefault(); // 使用者選擇取消，停留在原頁面
            }
        }
    });
</script>

</body>
</html>