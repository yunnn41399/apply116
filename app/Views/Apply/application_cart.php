<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>網路報名系統 - 我的校系清單</title>
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/apply.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/department.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/application.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
    <div id="applicationToast" class="application-toast" role="status" aria-live="polite">
        <i class="bi bi-check-circle-fill"></i>
        <span id="applicationToastMessage"></span>
    </div>
    <header class="apply-header">
        <h1 class="apply-header-title">
            網路報名系統
        </h1>
        <nav class="apply-nav">
            <a href="<?= site_url('apply') ?>" class="apply-nav-link">
                首頁
            </a>
            <a href="<?= site_url('department') ?>" class="apply-nav-link">
                查詢校系資料
            </a>
            <a href="<?= site_url('application') ?>" class="apply-nav-link">
                立即報名
            </a>
            <a href="<?= site_url('application/cart') ?>" class="apply-nav-link active">
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
                <i class="bi bi-bookmark-star"></i>
                我的校系清單
            </h2>
            <p>
                您可以先將有興趣的校系加入清單，
                再選擇最多 6 個校系進行正式報名。
            </p>
        </section>
        <?php if (
            session()->getFlashdata('error')
        ): ?>
            <div class="apply-error-message">
                <i class="bi bi-exclamation-circle"></i>
                <?= esc(
                    session()->getFlashdata(
                        'error'
                    )
                ) ?>
            </div>
        <?php endif; ?>
        <?php if (
            session()->getFlashdata('success')
        ): ?>
            <div class="apply-success-message">
                <i class="bi bi-check-circle"></i>
                <?= esc(
                    session()->getFlashdata(
                        'success'
                    )
                ) ?>
            </div>
        <?php endif; ?>
        <?php if ($isConfirmed): ?>
            <div class="application-cart-locked-message">
                <i class="bi bi-lock-fill"></i>
                <span>
                    報名已正式送出，目前校系清單僅供查看，無法再新增、移除或修改。
                </span>
            </div>
        <?php endif; ?>
        <section class="apply-content-card">
            <div class="application-cart-header">
                <h3 class="apply-section-title">
                    <i class="bi bi-bookmark-star"></i>
                    已加入的校系
                </h3>
                <span class="application-cart-count">
                    共 <?= $pager->getTotal('application_cart') ?> 筆
                </span>
            </div>
            <?php if (empty($cartItems)): ?>
                <div class="application-cart-empty">
                    <div class="application-cart-empty-icon">
                        <i class="bi bi-bookmark-x"></i>
                    </div>
                    <div class="application-cart-empty-title">
                        目前尚未加入任何校系
                    </div>
                    <div class="application-cart-empty-text">
                        您可以先瀏覽校系資料，
                        將有興趣的校系加入清單。
                    </div>
                    <a href="<?= site_url('application/departments') ?>" class="apply-primary-button">
                        <i class="bi bi-search"></i>
                        前往選擇校系
                    </a>
                </div>
            <?php else: ?>
                <div class="department-table-wrapper">
                    <table class="apply-table application-cart-table">
                        <thead>
                            <tr>
                                <th>
                                    學校代碼
                                </th>
                                <th>
                                    學校名稱
                                </th>
                                <th>
                                    學系代碼
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
                                <th>
                                    操作
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (
                                $cartItems
                                as $cartItem
                            ): ?>
                                <tr class="department-main-row">
                                    <td>
                                        <?= esc(
                                            $cartItem['university_code']
                                        ) ?>
                                    </td>
                                    <td>
                                        <?= esc(
                                            $cartItem['university_name']
                                        ) ?>
                                    </td>
                                    <td>
                                        <?= esc(
                                            $cartItem['department_code']
                                        ) ?>
                                    </td>
                                    <td>
                                        <?= esc(
                                            $cartItem['department_name']
                                        ) ?>
                                    </td>
                                    <td class="application-cart-quota">
                                        <?= esc(
                                            $cartItem['admission_quota']
                                        ) ?>
                                    </td>
                                    <td class="application-department-detail">
                                        <button type="button" class="department-detail-button"
                                            onclick="toggleDepartmentDetail(this)">
                                            <i class="bi bi-chevron-down"></i>
                                            查看詳細
                                        </button>
                                    </td>
                                    <td class="application-cart-operation">
                                        <?php if (!$isConfirmed): ?>
                                            <form action="<?= site_url(
                                                'application/cart/remove/'
                                                . $cartItem['department_id']
                                            ) ?>" method="post" class="application-remove-form">
                                                <?= csrf_field() ?>

                                                <button type="submit" class="application-remove-button">
                                                    <i class="bi bi-trash"></i>
                                                    移除
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <span class="apply-status apply-status-warning">
                                                <i class="bi bi-lock-fill"></i>
                                                已鎖定
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr class="department-detail-row" style="display: none;">
                                    <td colspan="7">
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
                                                        <?= esc($cartItem['natural_requirement']) ?>
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
                <?php if (!empty($cartItems)): ?>
                    <div class="department-pagination">
                        <?= $pager->links(
                            'application_cart',
                            'department'
                        ) ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <?php if (
                !empty($cartItems)
                && !$isConfirmed
            ): ?>
                <div class="application-cart-actions">
                    <a href="<?= site_url('application/departments') ?>" class="apply-secondary-button">
                        <i class="bi bi-search"></i>
                        繼續選擇校系
                    </a>
                    <a href="<?= site_url('application/selection') ?>" class="apply-primary-button">
                        <i class="bi bi-check2-circle"></i>
                        選擇正式報名校系
                    </a>
                </div>
                <div class="application-cart-hint">
                    <i class="bi bi-info-circle"></i>
                    下一步將從候選校系中選擇最多 6 個進行正式報名。
                </div>
            <?php endif; ?>
        </section>
    </main>
    <footer class="apply-footer">
        Apply116 網路報名系統
    </footer>
    <script src="<?= base_url('JS/department.js') ?>" defer></script>
    <script src="<?= base_url('JS/application.js') ?>" defer></script>
</body>

</html>