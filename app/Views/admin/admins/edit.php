<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/apply.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/admin.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>編輯管理員 - 後臺管理系統</title>
</head>

<body>

    <!-- 頂部導覽列 -->
    <?php include APPPATH . 'Views/admin/header.php'; ?>

    <!-- 主要內容區 -->
    <main class="admin-announcement-container">
        <section class="apply-content-card" style="padding: 2rem; max-width: 800px; margin: 0 auto;">

            <!-- 頁面標題列 -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 2px solid #ddd6fe; padding-bottom: 0.75rem;">
                <h2 class="section-title">
                    <i class="bi bi-person-gear"></i> 編輯管理員
                </h2>
                <a href="<?= site_url('admin/admins') ?>" id="btnBack" class="secondary-button" style="text-decoration: none; padding: 0.5rem 1rem; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 0.3rem;">
                    <i class="bi bi-arrow-left"></i> 返回管理員列表
                </a>
            </div>

            <!-- Session 單一錯誤訊息 -->
            <?php if (session()->has('error')): ?>
                <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 0.85rem 1.25rem; border-radius: 0.375rem; margin-bottom: 1.5rem; font-size: 0.95rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div><?= esc(session('error')) ?></div>
                </div>
            <?php endif; ?>

            <!-- Session 多筆驗證錯誤訊息 -->
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
            <form id="editAdminForm" method="post" action="<?= site_url('admin/admins/edit/' . $admin['id']) ?>" style="display: flex; flex-direction: column; gap: 1.25rem;">

                <?= csrf_field() ?>

                <!-- 管理員帳號 (唯讀顯示) -->
                <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                    <label style="font-weight: 600; color: #4c1d95; font-size: 0.95rem;">
                        管理員帳號
                    </label>
                    <div style="padding: 0.6rem 0.8rem; background-color: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 0.375rem; color: #4b5563; font-weight: 600; font-size: 0.95rem;">
                        <i class="bi bi-person-badge" style="margin-right: 0.3rem; color: #6d28d9;"></i>
                        <?= esc($admin['username']) ?>
                    </div>
                </div>

                <!-- 姓名 -->
                <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                    <label for="name" style="font-weight: 600; color: #4c1d95; font-size: 0.95rem;">
                        管理員姓名 <span style="color: #ef4444;">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="<?= old('name', $admin['name']) ?>"
                        placeholder="請輸入管理員姓名"
                        required
                        style="padding: 0.6rem 0.8rem; border: 1px solid #ddd6fe; border-radius: 0.375rem; outline: none; font-size: 0.95rem;"
                    >
                </div>

                <!-- 電子郵件 Email -->
                <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                    <label for="email" style="font-weight: 600; color: #4c1d95; font-size: 0.95rem;">
                        電子郵件 <span style="color: #ef4444;">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?= old('email', $admin['email'] ?? '') ?>"
                        placeholder="請輸入 Email (例: admin@example.com)"
                        required
                        style="padding: 0.6rem 0.8rem; border: 1px solid #ddd6fe; border-radius: 0.375rem; outline: none; font-size: 0.95rem;"
                    >
                </div>

                <!-- 角色與狀態 -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem;">

                    <!-- 管理員角色 -->
                    <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                        <label for="role" style="font-weight: 600; color: #4c1d95; font-size: 0.95rem;">
                            管理員角色 <span style="color: #ef4444;">*</span>
                        </label>

                        <?php if ($isSelf): ?>
                            <!-- 編輯自己的帳號：唯讀 -->
                            <div style="padding: 0.6rem 0.8rem; background-color: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 0.375rem; color: #4b5563; font-size: 0.95rem;">
                                <?= ($admin['role'] === 'super_admin') ? '最高管理員' : '一般管理員' ?>
                            </div>
                        <?php else: ?>
                            <!-- 編輯其他管理員：最高管理員可以修改 -->
                            <select
                                id="role"
                                name="role"
                                required
                                style="padding: 0.6rem 0.8rem; border: 1px solid #ddd6fe; border-radius: 0.375rem; outline: none; font-size: 0.95rem; background-color: #fff;"
                            >
                                <option value="admin" <?= old('role', $admin['role']) === 'admin' ? 'selected' : '' ?>>
                                    一般管理員
                                </option>
                                <option value="super_admin" <?= old('role', $admin['role']) === 'super_admin' ? 'selected' : '' ?>>
                                    最高管理員
                                </option>
                            </select>
                        <?php endif; ?>
                    </div>

                    <!-- 帳號狀態 -->
                    <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                        <label for="status" style="font-weight: 600; color: #4c1d95; font-size: 0.95rem;">
                            帳號狀態 <span style="color: #ef4444;">*</span>
                        </label>

                        <?php if ($isSelf): ?>
                            <!-- 編輯自己的帳號：狀態唯讀 -->
                            <div style="padding: 0.6rem 0.8rem; background-color: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 0.375rem; color: #4b5563; font-size: 0.95rem;">
                                <?= ($admin['status'] === 'active') ? '🟢 啟用' : '🔴 停用' ?>
                            </div>
                        <?php else: ?>
                            <!-- 編輯其他管理員：最高管理員可以修改 -->
                            <select
                                id="status"
                                name="status"
                                required
                                style="padding: 0.6rem 0.8rem; border: 1px solid #ddd6fe; border-radius: 0.375rem; outline: none; font-size: 0.95rem; background-color: #fff;"
                            >
                                <option value="active" <?= old('status', $admin['status']) === 'active' ? 'selected' : '' ?>>
                                    🟢啟用
                                </option>
                                <option value="inactive" <?= old('status', $admin['status']) === 'inactive' ? 'selected' : '' ?>>
                                    🔴停用
                                </option>
                            </select>
                        <?php endif; ?>
                    </div>

                </div>

                <div style="margin-top: 0.5rem; padding-top: 1.25rem; border-top: 1px dashed #ddd6fe;">
                    <h3 style="font-size: 1.05rem; color: #4c1d95; margin: 0 0 0.3rem 0; font-weight: 600; display: flex; align-items: center; gap: 0.4rem;">
                        <i class="bi bi-shield-lock"></i> 修改密碼
                    </h3>
                    <p style="margin: 0 0 1rem 0; font-size: 0.875rem; color: #6b5b95;">
                        若不需要修改密碼，請將以下密碼欄位維持空白即可。
                    </p>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem;">
                        <!-- 新密碼 -->
                        <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                            <label for="password" style="font-weight: 600; color: #4c1d95; font-size: 0.95rem;">新密碼</label>
                            <div style="position: relative;">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="如不修改請留空"
                                    style="width: 100%; padding: 0.6rem 2.5rem 0.6rem 0.8rem; border: 1px solid #ddd6fe; border-radius: 0.375rem; outline: none; font-size: 0.95rem; box-sizing: border-box;"
                                >
                                <i class="bi bi-eye toggle-password" data-target="password" style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); cursor: pointer; color: #8b5cf6;"></i>
                            </div>
                        </div>

                        <!-- 確認新密碼 -->
                        <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                            <label for="password_confirm" style="font-weight: 600; color: #4c1d95; font-size: 0.95rem;">確認新密碼</label>
                            <div style="position: relative;">
                                <input
                                    type="password"
                                    id="password_confirm"
                                    name="password_confirm"
                                    placeholder="再次輸入新密碼"
                                    style="width: 100%; padding: 0.6rem 2.5rem 0.6rem 0.8rem; border: 1px solid #ddd6fe; border-radius: 0.375rem; outline: none; font-size: 0.95rem; box-sizing: border-box;"
                                >
                                <i class="bi bi-eye toggle-password" data-target="password_confirm" style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%); cursor: pointer; color: #8b5cf6;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <hr style="border: 0; border-top: 1px solid #ddd6fe; margin: 0.5rem 0;">

                <!-- 操作按鈕 -->
                <div style="display: flex; justify-content: flex-start; gap: 0.75rem;">
                    <button type="submit" class="primary-button" style="padding: 0.6rem 1.5rem; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 0.4rem;">
                        <i class="bi bi-check-lg"></i> 儲存修改
                    </button>
                </div>

            </form>

        </section>
    </main>

    <footer class="apply-footer" style="margin-top: 2rem;">
        Apply116 後臺管理系統
    </footer>

    <script>
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('bi-eye');
                    this.classList.add('bi-eye-slash');
                } else {
                    input.type = 'password';
                    this.classList.remove('bi-eye-slash');
                    this.classList.add('bi-eye');
                }
            });
        });

        let isFormDirty = false;
        const form = document.getElementById('editAdminForm');
        const btnBack = document.getElementById('btnBack');

        form.addEventListener('change', () => { isFormDirty = true; });
        form.addEventListener('input', () => { isFormDirty = true; });
        form.addEventListener('submit', () => { isFormDirty = false; });

        btnBack.addEventListener('click', (e) => {
            if (isFormDirty) {
                if (!confirm('若返回列表，將放棄當前修改的內容，確定要離開嗎？')) {
                    e.preventDefault();
                }
            }
        });
    </script>

</body>
</html>