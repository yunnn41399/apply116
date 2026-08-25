<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        網路報名系統 - 報名狀態查詢
    </title>
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/apply.css') ?>">
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
            <a href="<?= site_url('application') ?>" class="apply-nav-link">
                立即報名
            </a>
            <a href="<?= site_url('application/cart') ?>" class="apply-nav-link">
                我的校系清單
            </a>
            <a href="<?= site_url('application-status') ?>" class="apply-nav-link active">
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
                <i class="bi bi-clipboard-check"></i>
                報名狀態查詢
            </h2>
            <?php if (!$application): ?>
                <p>
                    您目前尚未建立報名資料。
                </p>
            <?php elseif (
                ($application['status'] ?? 'draft')
                === 'confirmed'
            ): ?>
                <p>
                    您的報名已正式送出，以下為目前的報名資料。
                </p>
            <?php else: ?>
                <p>
                    您的報名資料目前尚未正式送出。
                </p>
            <?php endif; ?>
        </section>
        <?php if (!$application): ?>
            <section class="apply-content-card">
                <div class="application-status-empty">
                    <div class="application-status-empty-icon">
                        <i class="bi bi-clipboard-x"></i>
                    </div>

                    <div class="application-status-empty-content">

                        <div class="application-status-empty-title">
                            尚未建立報名資料
                        </div>

                        <div class="application-status-empty-text">
                            請先完成報名基本資料後，再進行後續報名流程。
                        </div>

                    </div>
                    <a href="<?= site_url('application') ?>" class="apply-primary-button">
                        <i class="bi bi-pencil-square"></i>
                        前往立即報名
                    </a>
                </div>
            </section>
        <?php else: ?>
            <?php if (
                ($application['status'] ?? 'draft')
                === 'confirmed'
            ): ?>
                <section class="application-status-confirmed">
                    <div class="application-status-confirmed-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="application-status-confirmed-content">
                        <strong>
                            報名已正式送出
                        </strong>
                        <p>
                            您的報名資料已完成正式送出，
                            目前無法再修改報名資料及報名校系。
                        </p>
                        <?php if (!empty($confirmedAt)): ?>
                            <div class="application-status-time">
                                <i class="bi bi-clock"></i>
                                報名時間：
                                <?= esc($confirmedAt) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            <?php else: ?>
                <section class="application-status-draft">
                    <div class="application-status-draft-icon">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div class="application-status-draft-content">
                        <strong>
                            報名資料尚未正式送出
                        </strong>
                        <p>
                            您目前仍可修改報名資料及正式報名校系。
                        </p>
                        <a href="<?= site_url('application') ?>" class="apply-primary-button">
                            <i class="bi bi-pencil-square"></i>
                            繼續完成報名
                        </a>
                    </div>
                </section>
            <?php endif; ?>
            <section class="apply-content-card">
                <h3 class="apply-section-title">
                    <i class="bi bi-person-vcard"></i>
                    考生基本資料
                </h3>
                <div class="application-summary">
                    <div class="application-summary-row">
                        <div class="application-summary-label">
                            學測應試號碼
                        </div>
                        <div class="application-summary-value">
                            <?= esc(
                                $candidate['exam_number']
                            ) ?>
                        </div>
                    </div>
                    <div class="application-summary-row">
                        <div class="application-summary-label">
                            身分證號碼
                        </div>
                        <div class="application-summary-value">
                            <?= esc(
                                $candidate['id_number']
                            ) ?>
                        </div>
                    </div>
                    <div class="application-summary-row">
                        <div class="application-summary-label">
                            姓名
                        </div>
                        <div class="application-summary-value">
                            <?= esc(
                                $candidate['name']
                            ) ?>
                        </div>
                    </div>
                </div>
            </section>
            <section class="apply-content-card">
                <h3 class="apply-section-title">
                    <i class="bi bi-clipboard-data"></i>
                    報名資料
                </h3>
                <div class="application-summary">
                    <div class="application-summary-row">
                        <div class="application-summary-label">
                            出生年月日
                        </div>
                        <div class="application-summary-value">
                            <?= esc(
                                $application['birth_date'] ?? ''
                            ) ?>
                        </div>
                    </div>
                    <div class="application-summary-row">
                        <div class="application-summary-label">
                            手機號碼
                        </div>
                        <div class="application-summary-value">
                            <?= esc(
                                $application['phone'] ?? ''
                            ) ?>
                        </div>
                    </div>
                    <div class="application-summary-row">
                        <div class="application-summary-label">
                            通訊地址
                        </div>
                        <div class="application-summary-value">
                            <?= esc(
                                $application['address'] ?? ''
                            ) ?>
                        </div>
                    </div>
                    <div class="application-summary-row">
                        <div class="application-summary-label">
                            電子郵件
                        </div>
                        <div class="application-summary-value">
                            <?= esc(
                                $application['email'] ?? ''
                            ) ?>
                        </div>
                    </div>
                </div>
            </section>
            <section class="apply-content-card">
                <h3 class="apply-section-title">
                    <i class="bi bi-list-check"></i>
                    正式報名校系
                </h3>
                <?php if (
                    !empty($formalDepartments)
                ): ?>
                    <table class="application-confirm-department-table">
                        <tbody>
                            <?php for (
                                $i = 0;
                                $i < 6;
                                $i++
                            ): ?>
                                <tr>
                                    <td class="application-confirm-department-label">
                                        校系 <?= $i + 1 ?>
                                    </td>
                                    <td class="application-confirm-department-value">
                                        <?php if (isset($formalDepartments[$i])): ?>
                                            <?= esc($formalDepartments[$i]['department_code']) ?>
                                            -
                                            <?= esc($formalDepartments[$i]['university_name']) ?>
                                            -
                                            <?= esc($formalDepartments[$i]['department_name']) ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="application-status-no-department">
                        <i class="bi bi-info-circle"></i>
                        <span>
                            目前尚未選擇正式報名校系。
                        </span>
                    </div>
                <?php endif; ?>
            </section>
            <?php if (
                ($application['status'] ?? 'draft')
                === 'confirmed'
            ): ?>
                <div class="apply-actions">
                    <a href="<?= site_url('apply') ?>" class="apply-primary-button">
                        <i class="bi bi-house"></i>
                        返回首頁
                    </a>
                </div>
            <?php else: ?>
                <div class="apply-actions">
                    <a href="<?= site_url('application') ?>" class="apply-primary-button">
                        <i class="bi bi-pencil-square"></i>
                        前往立即報名
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </main>
    <footer class="apply-footer">
        Apply116 網路報名系統
    </footer>
</body>

</html>