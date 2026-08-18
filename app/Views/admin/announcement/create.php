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

        <form id="createForm" action="<?= site_url('admin/announcement/create') ?>" method="post" enctype="multipart/form-data">

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

            <!-- 返回按鈕 -->
            <a href="<?= site_url('admin/announcement') ?>" id="btnBack" style="margin-left: 15px;">返回公告列表</a>
        
        </form>

        <script>
            let isFormDirty = false;
            const form = document.getElementById('createForm');
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