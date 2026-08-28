<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/apply.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/admin.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>編輯公告 - 後臺管理系統</title>
</head>

<body>

    <!-- 主要內容區 -->
    <main class="admin-announcement-container">
        <section class="apply-content-card" style="padding: 2rem; max-width: 900px; margin: 0 auto;">

            <!-- 頁面標題列 -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 2px solid #ddd6fe; padding-bottom: 0.75rem;">
                <h2 class="section-title">
                    <i class="bi bi-pencil-square"></i> 編輯公告
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
            <form id="editForm" action="<?= site_url('admin/announcement/edit/' . $announcement['id']) ?>" method="post" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.25rem;">

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
                        value="<?= old('title', $announcement['title']) ?>"
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
                            <?php 
                                $categories = ['簡章訊息事項', '招生試務', '甄選資訊', '會議簡報', '其他事項', '系統公告', '師資保送甄試', '醫事人員養成計畫'];
                                $currentCategory = old('category', $announcement['category']);
                            ?>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat ?>" <?= $currentCategory === $cat ? 'selected' : '' ?>><?= $cat ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- 公告類型 -->
                    <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                        <label for="type" style="font-weight: 600; color: #4c1d95; font-size: 0.95rem;">
                            公告類型 <span style="color: #ef4444;">*</span>
                        </label>
                        <select id="type" name="type" style="padding: 0.6rem 0.8rem; border: 1px solid #ddd6fe; border-radius: 0.375rem; outline: none; font-size: 0.95rem; background-color: #fff;">
                            <?php 
                                $types = ['一般公告', '純檔案', '超連結'];
                                $currentType = old('type', $announcement['type']);
                            ?>
                            <?php foreach ($types as $t): ?>
                                <option value="<?= $t ?>" <?= $currentType === $t ? 'selected' : '' ?>><?= $t ?></option>
                            <?php endforeach; ?>
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
                    ><?= old('content', $announcement['content']) ?></textarea>
                </div>

                <!-- 附件上傳 -->
                <div style="display: flex; flex-direction: column; gap: 0.4rem; padding: 1rem; background-color: #fcfaff; border: 1px dashed #ddd6fe; border-radius: 0.375rem;">
                    <label for="attachment" style="font-weight: 600; color: #4c1d95; font-size: 0.95rem;">
                        <i class="bi bi-paperclip"></i> 附件上傳
                    </label>

                    <?php if (!empty($announcement['attachment'])): ?>
                        <div style="margin-bottom: 0.3rem; font-size: 0.9rem; color: #6d28d9; display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                            <span>
                                <i class="bi bi-file-earmark-check"></i> 目前附件：
                                <a href="<?= base_url($announcement['attachment']) ?>" target="_blank" class="admin-announcement-file">
                                    點此預覽舊檔
                                </a>
                            </span>

                            <!-- 新增：刪除舊附件勾選框 -->
                            <label style="color: #ef4444; font-size: 0.85rem; cursor: pointer; display: flex; align-items: center; gap: 0.2rem; background-color: #fef2f2; padding: 0.2rem 0.5rem; border-radius: 0.25rem; border: 1px solid #fecaca;">
                                <input type="checkbox" name="delete_attachment" value="1" style="accent-color: #ef4444;">
                                <i class="bi bi-trash"></i> 刪除此附件
                            </label>
                        </div>
                    <?php endif; ?>

                    <input
                        type="file"
                        id="attachment"
                        name="attachment"
                        class="custom-file-input"
                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar,.png,.jpg,.jpeg"
                        style="font-size: 0.9rem; color: #4c1d95;"
                    >
                    <span style="color: #6b5b95; font-size: 0.85rem; margin-top: 0.2rem;">
                        （支援 PDF、Word、Excel、PPT、圖片及壓縮檔，單一檔案上限 10MB）
                    </span>
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
                        value="<?= old('external_url', $announcement['external_url']) ?>"
                        placeholder="https://example.com"
                        style="padding: 0.6rem 0.8rem; border: 1px solid #ddd6fe; border-radius: 0.375rem; outline: none; font-size: 0.95rem;"
                    >
                </div>

                <!-- 上次發布時間提示 -->
                <?php if (!empty($announcement['publish_date'])): ?>
                    <div style="font-size: 0.875rem; color: #6b5b95; background-color: #f3e8ff; padding: 0.5rem 0.8rem; border-radius: 0.375rem; display: flex; align-items: center; gap: 0.4rem;">
                        <i class="bi bi-clock-history"></i> 上次發布時間：<strong><?= esc($announcement['publish_date']) ?></strong>
                        <span>（更新發布後將自動更新為最新時間）</span>
                    </div>
                <?php endif; ?>

                <hr style="border: 0; border-top: 1px solid #ddd6fe; margin: 0.5rem 0;">

                <!-- 操作按鈕區塊 -->
                <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                    <?php if ($announcement['status'] === 'published'): ?>
                        <button type="submit" name="status" value="published" class="primary-button" style="padding: 0.6rem 1.25rem; font-size: 0.95rem;">
                            <i class="bi bi-send-check"></i> 更新並發布
                        </button>
                        <span style="color: #6b5b95; font-size: 0.875rem; display: flex; align-items: center; gap: 0.2rem;">
                            <i class="bi bi-info-circle"></i> 已發布之公告無法變更回草稿狀態
                        </span>
                    <?php else: ?>
                        <button type="submit" name="status" value="draft" class="secondary-button" style="padding: 0.6rem 1.25rem; font-size: 0.95rem;">
                            <i class="bi bi-file-earmark-memory"></i> 儲存草稿
                        </button>
                        <button type="submit" name="status" value="published" class="primary-button" style="padding: 0.6rem 1.25rem; font-size: 0.95rem;">
                            <i class="bi bi-send-fill"></i> 發布公告
                        </button>
                    <?php endif; ?>
                </div>

            </form>

        </section>
    </main>

    <footer class="apply-footer" style="margin-top: 2rem;">
        Apply116 後臺管理系統
    </footer>

    <!-- 變更偵測與提示語句指令碼 -->
    <script>
        let isFormDirty = false;

        const form = document.getElementById('editForm');
        const btnBack = document.getElementById('btnBack');
        const deleteAttachment = document.getElementById('delete_attachment');

        // 監聽表單內部輸入項
        form.addEventListener('change', () => {
            isFormDirty = true;
        });

        form.addEventListener('input', () => {
            isFormDirty = true;
        });

        // 刪除附件確認
        if (deleteAttachment) {
            deleteAttachment.addEventListener('change', () => {

                if (deleteAttachment.checked) {

                    const confirmDelete = confirm(
                        '確定要刪除目前的附件嗎？\n\n儲存公告後，舊附件將會被永久刪除。'
                    );

                    if (!confirmDelete) {
                        deleteAttachment.checked = false;
                    }
                }
            });
        }

        // 正常提交表單時不需要跳出警告
        form.addEventListener('submit', () => {
            isFormDirty = false;
        });

        // 點擊返回按鈕時判斷
        btnBack.addEventListener('click', (e) => {

            if (isFormDirty) {

                const confirmLeave = confirm(
                    '若返回公告列表，將放棄當前的編輯，確定要離開嗎？'
                );

                if (!confirmLeave) {
                    e.preventDefault();
                }
            }
        });
    </script>

</body>
</html>