<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/apply.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/admin.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>新增公告 - 後臺管理系統</title>
</head>

<body>

    <!-- 主要內容區 -->
    <main class="admin-announcement-container">
        <section class="apply-content-card" style="padding: 2rem; max-width: 900px; margin: 0 auto;">

            <!-- 頁面標題列 -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 2px solid #ddd6fe; padding-bottom: 0.75rem;">
                <h2 class="section-title" style="border: none; margin: 0; padding: 0;">
                    <i class="bi bi-plus-circle"></i> 新增公告
                </h2>
                <a href="<?= site_url('admin/announcement') ?>" id="btnBack" class="secondary-button" style="text-decoration: none; padding: 0.5rem 1rem; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 0.3rem;">
                    <i class="bi bi-arrow-left"></i> 返回公告列表
                </a>
            </div>

            <!-- Session 錯誤訊息 -->
            <?php if (session()->has('errors')): ?>
                <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 0.85rem 1.25rem; border-radius: 0.375rem; margin-bottom: 1.5rem; font-size: 0.95rem;">
                    <div style="font-weight: 600; margin-bottom: 0.3rem; display: flex; align-items: center; gap: 0.4rem;">
                        <i class="bi bi-exclamation-triangle-fill"></i> 請修正以下表單錯誤：
                    </div>
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- 表單內容 -->
            <form id="createForm" action="<?= site_url('admin/announcement/create') ?>" method="post" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.25rem;">

                <?= csrf_field() ?>

                <!-- 公告標題 -->
                <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                    <label for="title" style="font-weight: 600; color: #4c1d95; font-size: 0.95rem;">
                        公告標題 <span style="color: #ef4444;">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        value="<?= old('title') ?>"
                        placeholder="請輸入公告標題"
                        required
                        style="padding: 0.6rem 0.8rem; border: 1px solid #ddd6fe; border-radius: 0.375rem; outline: none; font-size: 0.95rem; transition: border-color 0.2s;"
                    >
                </div>

                <!-- 分組下拉選單：類別與類型 -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                    <!-- 公告類別 -->
                    <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                        <label for="category" style="font-weight: 600; color: #4c1d95; font-size: 0.95rem;">
                            公告類別 <span style="color: #ef4444;">*</span>
                        </label>
                        <select id="category" name="category" style="padding: 0.6rem 0.8rem; border: 1px solid #ddd6fe; border-radius: 0.375rem; outline: none; font-size: 0.95rem; background-color: #fff;">
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

                    <!-- 公告類型 -->
                    <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                        <label for="type" style="font-weight: 600; color: #4c1d95; font-size: 0.95rem;">
                            公告類型 <span style="color: #ef4444;">*</span>
                        </label>
                        <select id="type" name="type" style="padding: 0.6rem 0.8rem; border: 1px solid #ddd6fe; border-radius: 0.375rem; outline: none; font-size: 0.95rem; background-color: #fff;">
                            <option value="">請選擇公告類型</option>
                            <option value="一般公告" <?= old('type') === '一般公告' ? 'selected' : '' ?>>一般公告</option>
                            <option value="純檔案" <?= old('type') === '純檔案' ? 'selected' : '' ?>>純檔案</option>
                            <option value="超連結" <?= old('type') === '超連結' ? 'selected' : '' ?>>超連結</option>
                        </select>
                    </div>
                </div>

                <!-- 公告內容 -->
                <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                    <label for="content" style="font-weight: 600; color: #4c1d95; font-size: 0.95rem;">公告內容</label>
                    <textarea 
                        id="content" 
                        name="content" 
                        rows="8" 
                        placeholder="請輸入公告詳細內容..."
                        style="padding: 0.6rem 0.8rem; border: 1px solid #ddd6fe; border-radius: 0.375rem; outline: none; font-size: 0.95rem; font-family: inherit; resize: vertical;"
                    ><?= old('content') ?></textarea>
                </div>

                <!-- 附件上傳區塊（支援多檔、自訂檔名編輯與刪除） -->
                <div style="display: flex; flex-direction: column; gap: 0.6rem; padding: 1rem; background-color: #fcfaff; border: 1px dashed #ddd6fe; border-radius: 0.375rem;">
                    <label for="attachments" style="font-weight: 600; color: #4c1d95; font-size: 0.95rem;">
                        <i class="bi bi-paperclip"></i> 附件上傳
                    </label>

                    <input
                        type="file"
                        id="attachments"
                        name="attachments[]"
                        multiple
                        class="custom-file-input"
                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar,.png,.jpg,.jpeg"
                        style="font-size: 0.9rem; color: #4c1d95;"
                    >
                    <span style="color: #6b5b95; font-size: 0.85rem;">
                        （可選擇一個或多個檔案，單一檔案上限 10MB）
                    </span>

                    <!-- 動態生成選擇檔案後的顯示名稱修改與刪除清單 -->
                    <div id="fileListContainer" style="display: none; margin-top: 0.5rem;">
                        <div style="font-size: 0.875rem; color: #6d28d9; font-weight: 600; margin-bottom: 0.4rem;">
                            <i class="bi bi-paperclip"></i> 已選擇的附件清單：
                        </div>
                        <div id="fileList" style="display: flex; flex-direction: column; gap: 0.5rem;"></div>
                    </div>
                </div>

                <!-- 外部網址 -->
                <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                    <label for="external_url" style="font-weight: 600; color: #4c1d95; font-size: 0.95rem;">
                        <i class="bi bi-link-45deg"></i> 外部網址
                    </label>
                    <input 
                        type="url" 
                        id="external_url" 
                        name="external_url" 
                        value="<?= old('external_url') ?>"
                        placeholder="https://example.com"
                        style="padding: 0.6rem 0.8rem; border: 1px solid #ddd6fe; border-radius: 0.375rem; outline: none; font-size: 0.95rem;"
                    >
                </div>

                <hr style="border: 0; border-top: 1px solid #ddd6fe; margin: 0.5rem 0;">

                <!-- 操作按鈕區塊 -->
                <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                    <button type="submit" name="status" value="draft" class="secondary-button" style="padding: 0.6rem 1.25rem; font-size: 0.95rem;">
                        <i class="bi bi-file-earmark-memory"></i> 暫存草稿
                    </button>
                    <button type="submit" name="status" value="published" class="primary-button" style="padding: 0.6rem 1.25rem; font-size: 0.95rem;">
                        <i class="bi bi-send-fill"></i> 發布公告
                    </button>
                </div>

            </form>

        </section>
    </main>

    <footer class="apply-footer" style="margin-top: 2rem;">
        Apply116 後臺管理系統
    </footer>

    <script>
        let isFormDirty = false;
        const form = document.getElementById('createForm');
        const btnBack = document.getElementById('btnBack');
        const attachmentsInput = document.getElementById('attachments');
        const fileListContainer = document.getElementById('fileListContainer');
        const fileList = document.getElementById('fileList');

        // 使用 DataTransfer 來即時維護與更新 <input type="file"> 的檔案陣列
        let dt = new DataTransfer();

        attachmentsInput.addEventListener('change', function () {
            // 將新選取的檔案加入 DataTransfer 清單中
            for (let i = 0; i < this.files.length; i++) {
                dt.items.add(this.files[i]);
            }

            // 更新 input 檔案清單
            this.files = dt.files;

            renderFileList();
        });

        // 渲染列表 (包含名稱輸入框與刪除按鈕)
        function renderFileList() {
            fileList.innerHTML = '';

            if (dt.files.length > 0) {
                fileListContainer.style.display = 'block';

                Array.from(dt.files).forEach((file, index) => {
                    const row = document.createElement('div');
                    row.style.cssText = 'display: flex; align-items: center; gap: 0.5rem; background: #fff; padding: 0.5rem; border: 1px solid #ddd6fe; border-radius: 0.25rem;';

                    // 檔名輸入框
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.name = 'custom_attachment_names[]';
                    input.value = file.name; // 預設帶入原檔名
                    input.placeholder = '前台顯示名稱';
                    input.style.cssText = 'flex: 1; padding: 0.3rem 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.25rem; font-size: 0.9rem;';

                    // 刪除按鈕
                    const deleteBtn = document.createElement('button');
                    deleteBtn.type = 'button';
                    deleteBtn.innerHTML = '<i class="bi bi-trash"></i> 移除';
                    deleteBtn.style.cssText = 'color: #ef4444; font-size: 0.85rem; cursor: pointer; background-color: #fef2f2; padding: 0.3rem 0.6rem; border-radius: 0.25rem; border: 1px solid #fecaca; white-space: nowrap; font-weight: 500;';

                    // 點擊移除指定的檔案
                    deleteBtn.addEventListener('click', () => {
                        removeFile(index);
                    });

                    row.appendChild(input);
                    row.appendChild(deleteBtn);
                    fileList.appendChild(row);
                });
            } else {
                fileListContainer.style.display = 'none';
            }
        }

        // 從 DataTransfer 清單中移除檔案
        function removeFile(index) {
            const newDt = new DataTransfer();

            for (let i = 0; i < dt.files.length; i++) {
                if (i !== index) {
                    newDt.items.add(dt.files[i]);
                }
            }

            dt = newDt; // 更新 DataTransfer 物件
            attachmentsInput.files = dt.files; // 將新的檔案清單同步回 input

            renderFileList(); // 重新渲染頁面
        }

        form.addEventListener('change', () => { isFormDirty = true; });
        form.addEventListener('input', () => { isFormDirty = true; });
        form.addEventListener('submit', () => { isFormDirty = false; });

        btnBack.addEventListener('click', (e) => {
            if (isFormDirty) {
                const confirmLeave = confirm('若返回公告列表，將放棄當前的編輯，確定要離開嗎？');
                if (!confirmLeave) {
                    e.preventDefault();
                }
            }
        });
    </script>

</body>
</html>