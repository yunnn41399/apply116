<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        網路報名系統 - 選擇正式報名校系
    </title>
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/apply.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/department.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/application.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
    <header class="apply-header">
        <h1 class="apply-header-title">
            網路報名系統
        </h1>
        <nav class="apply-nav">
            <a href="<?= site_url('apply') ?>" class="apply-nav-link">
                首頁
            </a>
            <a href="<?= site_url('application') ?>" class="apply-nav-link active">
                立即報名
            </a>
            <a href="<?= site_url('application/cart') ?>" class="apply-nav-link">
                我的校系清單
            </a>
            <a href="<?= site_url('application-status') ?>" class="apply-nav-link">
                報名狀態查詢
            </a>
        </nav>
        <div class="apply-header-right">
            <div class="apply-header-user">
                <span class="apply-header-text">
                    學測應試號碼：
                    <?= esc(
                        session()->get('exam_number')
                    ) ?>
                </span>
                <span class="apply-header-text">
                    姓名：
                    <?= esc(
                        session()->get(
                            'candidate_name'
                        ) ?? ''
                    ) ?>
                </span>
            </div>
            <a href="<?= site_url('logout') ?>" class="apply-logout-button">
                <i class="bi bi-box-arrow-right"></i>
                登出
            </a>
        </div>
    </header>
    <main class="apply-container">
        <section class="apply-welcome">
            <h2>
                <i class="bi bi-check2-square"></i>
                選擇正式報名校系
            </h2>
            <p>
                請從您已加入的校系中選擇
                <strong class="application-selection-highlight">
                    1~6 個
                </strong>
                進行正式報名。
            </p>
        </section>
        <?php if (
            session()->getFlashdata('error')
        ): ?>
            <div class="apply-error-message">
                <i class="bi bi-exclamation-circle"></i>
                <?= esc(
                    session()->getFlashdata('error')
                ) ?>
            </div>
        <?php endif; ?>
        <section class="application-selection-counter">
            <div>
                <span>
                    目前已選：
                </span>
                <strong id="selectedDepartmentCount" class="application-selection-highlight">
                    <?= $selectedCount ?> / 6
                </strong>
            </div>
            <span class="application-selection-counter-hint">
                至少選擇 1 個，最多選擇 6 個
            </span>
        </section>
        <section class="apply-content-card">
            <div class="application-cart-header">
                <h3 class="apply-section-title">
                    <i class="bi bi-list-check"></i>
                    候選的校系
                </h3>
                <span class="application-cart-count">
                    共 <?= $pager->getTotal('application_selection') ?> 筆
                </span>
            </div>
            <form action="<?= site_url(
                'application/selection/save'
            ) ?>" method="post" id="applicationSelectionForm" data-selection-toggle-url="<?= site_url(
                 'application/selection/toggle'
             ) ?>">
                <?= csrf_field() ?>
                <div class="department-table-wrapper">
                    <table class="apply-table application-selection-table">
                        <thead>
                            <tr>
                                <th>
                                    選擇
                                </th>
                                <th>
                                    學校名稱
                                </th>
                                <th>
                                    學系名稱
                                </th>
                                <th>
                                    招生名額
                                </th>
                                <th>
                                    檢定科目
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (
                                $cartItems
                                as $cartItem
                            ): ?>
                                <tr class="department-main-row">
                                    <td class="application-selection-checkbox-cell">
                                        <input type="checkbox" name="department_ids[]"
                                            value="<?= esc($cartItem['department_id']) ?>"
                                            class="department-selection-checkbox" <?= in_array(
                                                (int) $cartItem['department_id'],
                                                $selectedDepartmentIds,
                                                true
                                            )
                                                ? 'checked'
                                                : '' ?>>
                                    </td>
                                    <td>
                                        <?= esc($cartItem['university_name']) ?>
                                    </td>
                                    <td>
                                        <?= esc($cartItem['department_name']) ?>
                                    </td>
                                    <td class="application-cart-quota">
                                        <?= esc($cartItem['admission_quota']) ?>
                                    </td>
                                    <td class="application-department-detail">
                                        <button type="button" class="department-detail-button"
                                            onclick="toggleDepartmentDetail(this)">
                                            <i class="bi bi-chevron-down"></i>
                                            查看詳細
                                        </button>
                                    </td>
                                </tr>
                                <tr class="department-detail-row" style="display: none;">
                                    <td colspan="5">
                                        <div class="department-detail-content">
                                            <div class="department-detail-title">
                                                <i class="bi bi-book"></i>
                                                學測檢定科目門檻
                                            </div>
                                            <div class="department-requirement-grid">
                                                <div class="department-requirement-item">
                                                    <span class="requirement-label">
                                                        國文
                                                    </span>
                                                    <span class="requirement-value">
                                                        <?= esc($cartItem['chinese_requirement']) ?>
                                                    </span>
                                                </div>
                                                <div class="department-requirement-item">
                                                    <span class="requirement-label">
                                                        英文
                                                    </span>
                                                    <span class="requirement-value">
                                                        <?= esc($cartItem['english_requirement']) ?>
                                                    </span>
                                                </div>
                                                <div class="department-requirement-item">
                                                    <span class="requirement-label">
                                                        數學A
                                                    </span>
                                                    <span class="requirement-value">
                                                        <?= esc($cartItem['math_a_requirement']) ?>
                                                    </span>
                                                </div>
                                                <div class="department-requirement-item">
                                                    <span class="requirement-label">
                                                        數學B
                                                    </span>
                                                    <span class="requirement-value">
                                                        <?= esc($cartItem['math_b_requirement']) ?>
                                                    </span>
                                                </div>
                                                <div class="department-requirement-item">
                                                    <span class="requirement-label">
                                                        社會
                                                    </span>
                                                    <span class="requirement-value">
                                                        <?= esc($cartItem['social_requirement']) ?>
                                                    </span>
                                                </div>
                                                <div class="department-requirement-item">
                                                    <span class="requirement-label">
                                                        自然
                                                    </span>
                                                    <span class="requirement-value">
                                                        <?= esc(
                                                            $cartItem['natural_requirement']
                                                        ) ?>
                                                    </span>
                                                </div>
                                                <div class="department-requirement-item">
                                                    <span class="requirement-label">
                                                        英聽
                                                    </span>
                                                    <span class="requirement-value">
                                                        <?= esc($cartItem['english_listening_requirement']) ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="department-pagination">
                    <?= $pager->links(
                        'application_selection',
                        'department'
                    ) ?>
                </div>
                <div class="application-cart-actions">
                    <a href="<?= site_url(
                        'application/cart'
                    ) ?>" class="apply-secondary-button">
                        <i class="bi bi-arrow-left"></i>
                        返回我的校系清單
                    </a>
                    <button type="submit" class="apply-primary-button" id="applicationSelectionSubmit" <?= $selectedCount < 1
                        ? 'disabled'
                        : '' ?>>
                        <i class="bi bi-arrow-right"></i>
                        確認選擇
                    </button>
                </div>
                <div class="application-cart-hint">
                    <i class="bi bi-info-circle"></i>
                    確認選擇後將進入正式報名確認頁，
                    尚未正式送出前仍可修改。
                </div>
            </form>
        </section>
    </main>
    <footer class="apply-footer">
        Apply116 網路報名系統
    </footer>
    <script src="<?= base_url('JS/department.js') ?>" defer></script>
    <script src="<?= base_url('JS/application.js') ?>" defer></script>
</body>

</html>