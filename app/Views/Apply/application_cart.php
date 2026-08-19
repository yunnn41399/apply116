<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>網路報名系統 - 我的校系清單</title>
    <!-- 共用樣式 -->
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <!-- 網路報名系統樣式 -->
    <link rel="stylesheet" href="<?= base_url('CSS/apply.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/application.css') ?>">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
    <!-- ========================================
         Header
         ======================================== -->
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
            <a href="<?= site_url('application') ?>" class="apply-nav-link active">
                立即報名
            </a>
            <a href="<?= site_url('application-status') ?>" class="apply-nav-link">
                報名狀態查詢
            </a>
        </nav>
        <!-- 考生資訊與登出 -->
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
    <!-- ========================================
         Main
         ======================================== -->
    <main class="apply-container">
        <!-- ========================================
             頁面標題
             ======================================== -->
        <section class="apply-welcome">
            <h2>
                <i class="bi bi-bookmark-star"></i>
                我的校系清單
            </h2>
            <p>
                您可以先將有興趣的校系加入清單，
                最後再選擇最多 6 個校系進行正式報名。
            </p>
        </section>
        <!-- ========================================
             系統訊息
             ======================================== -->
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
        <!-- ========================================
             校系清單
             ======================================== -->
        <section class="apply-content-card">
            <div class="application-cart-header">
                <h3 class="apply-section-title">
                    <i class="bi bi-bookmark-star"></i>
                    已加入的校系
                </h3>
                <span class="application-cart-count">
                    共
                    <?= count($cartItems) ?> 個
                </span>
            </div>
            <?php if (empty($cartItems)): ?>
                <!-- ========================================
                     尚未加入任何校系
                     ======================================== -->
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
                        前往查詢校系
                    </a>
                </div>
            <?php else: ?>
                <!-- ========================================
                     校系列表
                     ======================================== -->
                <div class="department-table-wrapper">
                    <table class="apply-table">
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
                                    操作
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (
                                $cartItems
                                as $cartItem
                            ): ?>
                                <tr>
                                    <td>
                                        <?= esc(
                                            $cartItem[
                                                'university_code'
                                            ]
                                        ) ?>
                                    </td>
                                    <td>
                                        <?= esc(
                                            $cartItem[
                                                'university_name'
                                            ]
                                        ) ?>
                                    </td>
                                    <td>
                                        <?= esc(
                                            $cartItem[
                                                'department_code'
                                            ]
                                        ) ?>
                                    </td>
                                    <td>
                                        <?= esc(
                                            $cartItem[
                                                'department_name'
                                            ]
                                        ) ?>
                                    </td>
                                    <td class="application-cart-quota">
                                        <?= esc(
                                            $cartItem[
                                                'admission_quota'
                                            ]
                                        ) ?>
                                    </td>
                                    <td>
                                        <?php if (
                                            !$isConfirmed
                                        ): ?>
                                            <form action="<?= site_url(
                                                'application/cart/remove/'
                                                . $cartItem[
                                                    'department_id'
                                                ]
                                            ) ?>" method="post">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="application-remove-button" onclick="return confirm(
                                                        '確定要從校系清單移除這個校系嗎？'
                                                    );">
                                                    <i class="bi bi-trash"></i>
                                                    移除
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <span class="apply-status">
                                                已確認
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
            <!-- ========================================
                 操作區
                 ======================================== -->
            <?php if (
                !empty($cartItems)
                && !$isConfirmed
            ): ?>
                <div class="application-cart-actions">
                    <a href="<?= site_url('application/departments') ?>" class="apply-secondary-button">
                        <i class="bi bi-search"></i>
                        繼續查詢校系
                    </a>
                    <button type="button" class="apply-primary-button" disabled>
                        <i class="bi bi-check2-circle"></i>
                        選擇正式報名校系
                    </button>
                </div>
                <div class="application-cart-hint">
                    <i class="bi bi-info-circle"></i>
                    下一步將從候選校系中選擇最多 6 個進行正式報名。
                </div>
            <?php endif; ?>
        </section>
    </main>
    <!-- ========================================
         Footer
         ======================================== -->
    <footer class="apply-footer">
        Apply116 網路報名系統
    </footer>
</body>

</html>