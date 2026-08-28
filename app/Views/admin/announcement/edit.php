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

<main class="admin-announcement-container">

    <section class="apply-content-card" style="padding: 2rem; max-width: 900px; margin: 0 auto;">

        <!-- 標題 -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 2px solid #ddd6fe; padding-bottom: 0.75rem;">
            <h2 class="section-title">
                <i class="bi bi-pencil-square"></i> 編輯公告
            </h2>
            <a href="<?= site_url('admin/announcement') ?>" id="btnBack" class="secondary-button" style="text-decoration: none; padding: 0.5rem 1rem; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 0.3rem;">
                <i class="bi bi-arrow-left"></i> 返回公告列表
            </a>
        </div>

        <!-- 錯誤訊息 -->
        <?php if (session()->has('errors')): ?>
            <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 0.85rem 1.25rem; border-radius: 0.375rem; margin-bottom: 1.5rem; font-size: 0.95rem;">
                <div style="font-weight: 600; margin-bottom: 0.3rem;">
                    <i class="bi bi-exclamation-triangle-fill"></i> 請修正以下表單錯誤：
                </div>
                <ul style="margin: 0; padding-left: 1.5rem;">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php
        $oldAttachments = [];
        if (!empty($announcement['attachment'])) {
            // 修正 Windows 反斜線問題
            $cleanAttachment = str_replace('\\', '/', $announcement['attachment']);
            $decoded = json_decode($cleanAttachment, true);

            if (is_array($decoded)) {
                foreach ($decoded as $item) {
                    if (is_array($item) && !empty($item['path'])) {
                        $path = str_replace('\\', '/', $item['path']);
                        $oldAttachments[] = [
                            'path' => $path,
                            'custom_name' => $item['custom_name'] ?? basename($path)
                        ];
                    } elseif (is_string($item)) {
                        $path = str_replace('\\', '/', $item);
                        $oldAttachments[] = [
                            'path' => $path,
                            'custom_name' => basename($path)
                        ];
                    }
                }
            } else {
                $oldAttachments[] = [
                    'path' => $cleanAttachment,
                    'custom_name' => basename($cleanAttachment)
                ];
            }
        }
        ?>

        <form id="editForm" action="<?= site_url('admin/announcement/edit/' . $announcement['id']) ?>" method="post" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.25rem;">

            <?= csrf_field() ?>

            <!-- 標題 -->
            <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="title" style="font-weight: 600; color: #4c1d95;">
                    公告標題 <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" id="title" name="title" value="<?= esc(old('title', $announcement['title'])) ?>" required style="padding: 0.6rem 0.8rem; border: 1px solid #ddd6fe; border-radius: 0.375rem; font-size: 0.95rem;">
            </div>

            <!-- 類別 / 類型 -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                <!-- 類別 -->
                <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                    <label for="category" style="font-weight: 600; color: #4c1d95;">公告類別</label>
                    <?php
                    $categories = [
                        '簡章訊息事項', '招生試務', '甄選資訊', '會議簡報', '其他事項', '系統公告', '師資保送甄試', '醫事人員養成計畫'
                    ];
                    $currentCategory = old('category', $announcement['category']);
                    ?>
                    <select id="category" name="category" required style="padding: 0.6rem 0.8rem; border: 1px solid #ddd6fe; border-radius: 0.375rem; background: #fff;">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= esc($category) ?>" <?= $currentCategory === $category ? 'selected' : '' ?>>
                                <?= esc($category) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- 類型 -->
                <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                    <label for="type" style="font-weight: 600; color: #4c1d95;">公告類型</label>
                    <?php
                    $types = ['一般公告', '純檔案', '超連結'];
                    $currentType = old('type', $announcement['type']);
                    ?>
                    <select id="type" name="type" required style="padding: 0.6rem 0.8rem; border: 1px solid #ddd6fe; border-radius: 0.375rem; background: #fff;">
                        <?php foreach ($types as $type): ?>
                            <option value="<?= esc($type) ?>" <?= $currentType === $type ? 'selected' : '' ?>>
                                <?= esc($type) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- 公告內容 -->
            <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="content" style="font-weight: 600; color: #4c1d95;">公告內容</label>
                <textarea id="content" name="content" rows="8" style="padding: 0.6rem 0.8rem; border: 1px solid #ddd6fe; border-radius: 0.375rem; font-size: 0.95rem; font-family: inherit; resize: vertical;"><?= esc(old('content', $announcement['content'])) ?></textarea>
            </div>

            <!-- 附件管理區塊 -->
            <div style="display: flex; flex-direction: column; gap: 0.8rem; padding: 1rem; background-color: #fcfaff; border: 1px dashed #ddd6fe; border-radius: 0.375rem;">
                <label style="font-weight: 600; color: #4c1d95;">
                    <i class="bi bi-paperclip"></i> 附件管理
                </label>

                <!-- 目前已有附件 -->
                <?php if (!empty($oldAttachments)): ?>
                    <div>
                        <div style="font-size: 0.875rem; color: #6d28d9; font-weight: 600; margin-bottom: 0.4rem;">
                            <i class="bi bi-file-earmark-check"></i> 目前附件：
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <?php foreach ($oldAttachments as $index => $item): ?>
                                <?php
                                $path = $item['path'] ?? '';
                                $customName = $item['custom_name'] ?? basename($path);
                                ?>
                                <div class="old-attachment-row" style="display: flex; align-items: center; gap: 0.5rem; background: #fff; padding: 0.5rem; border: 1px solid #ddd6fe; border-radius: 0.25rem;">
                                    <input type="hidden" name="existing_attachments_path[]" value="<?= esc($path) ?>">
                                    <input type="text" name="existing_attachments_name[]" value="<?= esc($customName) ?>" placeholder="前台顯示名稱" style="flex: 1; padding: 0.3rem 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.25rem; font-size: 0.9rem;">
                                    
                                    <a href="<?= base_url($path) ?>" target="_blank" class="admin-announcement-file" style="white-space: nowrap; font-size: 0.85rem; padding: 0.3rem 0.6rem; border-radius: 0.25rem;">預覽</a>

                                    <!-- 隱藏式勾選框，供後端判定刪除 -->
                                    <input type="checkbox" name="delete_attachments[]" value="<?= esc($path) ?>" class="delete-attachment-checkbox" style="display: none;">
                                    
                                    <!-- 移除按鈕 -->
                                    <button type="button" class="btn-remove-old" style="color: #ef4444; font-size: 0.85rem; cursor: pointer; background-color: #fef2f2; padding: 0.3rem 0.6rem; border-radius: 0.25rem; border: 1px solid #fecaca; white-space: nowrap; font-weight: 500;">
                                        <i class="bi bi-trash"></i> 移除
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- 上傳新附件區域 -->
                <div style="margin-top: 0.4rem;">
                    <div style="font-size: 0.875rem; color: #6d28d9; font-weight: 600; margin-bottom: 0.4rem;">
                        <i class="bi bi-plus-circle"></i> 上傳新附件：
                    </div>
                    <input type="file" id="attachments" name="attachments[]" multiple class="custom-file-input" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar,.png,.jpg,.jpeg" style="font-size: 0.9rem; color: #4c1d95;">
                    <span style="color: #6b5b95; font-size: 0.85rem; display: block; margin-top: 0.2rem;">（可選擇一個或多個新檔案，單一檔案上限 10MB）</span>
                </div>

                <!-- 動態生成新選檔案的清單與移除按鈕 -->
                <div id="newFileListContainer" style="display: none; margin-top: 0.5rem;">
                    <div style="font-size: 0.875rem; color: #6d28d9; font-weight: 600; margin-bottom: 0.4rem;">
                        <i class="bi bi-file-earmark-plus"></i> 新選擇的附件：
                    </div>
                    <div id="newFileList" style="display: flex; flex-direction: column; gap: 0.5rem;"></div>
                </div>
            </div>

            <!-- 外部網址 -->
            <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="external_url" style="font-weight: 600; color: #4c1d95;">
                    <i class="bi bi-link-45deg"></i> 外部網址
                </label>
                <input type="url" id="external_url" name="external_url" value="<?= esc(old('external_url', $announcement['external_url'])) ?>" placeholder="https://example.com" style="padding: 0.6rem 0.8rem; border: 1px solid #ddd6fe; border-radius: 0.375rem;">
            </div>

            <!-- 發布時間 -->
            <?php if (!empty($announcement['publish_date'])): ?>
                <div style="font-size: 0.875rem; color: #6b5b95; background-color: #f3e8ff; padding: 0.5rem 0.8rem; border-radius: 0.375rem;">
                    <i class="bi bi-clock-history"></i> 上次發布時間：<strong><?= esc($announcement['publish_date']) ?></strong>
                </div>
            <?php endif; ?>

            <hr style="border: 0; border-top: 1px solid #ddd6fe;">

            <!-- 按鈕 -->
            <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                <?php if ($announcement['status'] === 'published'): ?>
                    <button type="submit" name="status" value="published" class="primary-button" style="padding: 0.6rem 1.25rem;">
                        <i class="bi bi-send-check"></i> 更新並發布
                    </button>
                    <span style="color: #6b5b95; font-size: 0.875rem;">
                        <i class="bi bi-info-circle"></i> 已發布之公告無法變更回草稿狀態
                    </span>
                <?php else: ?>
                    <button type="submit" name="status" value="draft" class="secondary-button" style="padding: 0.6rem 1.25rem;">
                        <i class="bi bi-file-earmark-memory"></i> 儲存草稿
                    </button>
                    <button type="submit" name="status" value="published" class="primary-button" style="padding: 0.6rem 1.25rem;">
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

<script>
let isFormDirty = false;
const form = document.getElementById('editForm');
const btnBack = document.getElementById('btnBack');
const attachmentsInput = document.getElementById('attachments');
const newFileListContainer = document.getElementById('newFileListContainer');
const newFileList = document.getElementById('newFileList');

// 1. 處理「舊附件」的移除 (自動勾選隱藏的 Checkbox 並隱藏該列)
document.querySelectorAll('.btn-remove-old').forEach(button => {
    button.addEventListener('click', function () {
        const row = this.closest('.old-attachment-row');
        const checkbox = row.querySelector('.delete-attachment-checkbox');

        const confirmDelete = confirm('確定要移除此附件嗎？\n\n儲存公告後，該附件將會被永久刪除。');
        if (confirmDelete) {
            checkbox.checked = true;
            row.style.display = 'none'; // 隱藏 UI 列
            isFormDirty = true;
        }
    });
});

// 2. 處理「新選取附件」的 DataTransfer 管理
let dt = new DataTransfer();

attachmentsInput.addEventListener('change', function () {
    for (let i = 0; i < this.files.length; i++) {
        dt.items.add(this.files[i]);
    }
    this.files = dt.files;
    renderNewFileList();
});

function renderNewFileList() {
    newFileList.innerHTML = '';

    if (dt.files.length > 0) {
        newFileListContainer.style.display = 'block';

        Array.from(dt.files).forEach((file, index) => {
            const row = document.createElement('div');
            row.style.cssText = 'display: flex; align-items: center; gap: 0.5rem; background: #fff; padding: 0.5rem; border: 1px solid #ddd6fe; border-radius: 0.25rem;';

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'custom_attachment_names[]';
            input.value = file.name;
            input.placeholder = '前台顯示名稱';
            input.style.cssText = 'flex: 1; padding: 0.3rem 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.25rem; font-size: 0.9rem;';

            const deleteBtn = document.createElement('button');
            deleteBtn.type = 'button';
            deleteBtn.innerHTML = '<i class="bi bi-trash"></i> 移除';
            deleteBtn.style.cssText = 'color: #ef4444; font-size: 0.85rem; cursor: pointer; background-color: #fef2f2; padding: 0.3rem 0.6rem; border-radius: 0.25rem; border: 1px solid #fecaca; white-space: nowrap; font-weight: 500;';

            deleteBtn.addEventListener('click', () => {
                removeNewFile(index);
            });

            row.appendChild(input);
            row.appendChild(deleteBtn);
            newFileList.appendChild(row);
        });
    } else {
        newFileListContainer.style.display = 'none';
    }
}

function removeNewFile(index) {
    const newDt = new DataTransfer();
    for (let i = 0; i < dt.files.length; i++) {
        if (i !== index) {
            newDt.items.add(dt.files[i]);
        }
    }
    dt = newDt;
    attachmentsInput.files = dt.files;
    renderNewFileList();
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