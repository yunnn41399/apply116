<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        網路報名系統 - 報名資料核對
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
            <a href="<?= site_url('department') ?>" class="apply-nav-link">
                查詢校系資料
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
                <i class="bi bi-clipboard-check"></i>
                報名資料核對
            </h2>
            <p>
                請仔細核對以下資料，確認無誤後再正式送出報名，送出後不可再更改。
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
                            $application['birth_date']
                        ) ?>
                    </div>
                </div>
                <div class="application-summary-row">
                    <div class="application-summary-label">
                        手機號碼
                    </div>
                    <div class="application-summary-value">
                        <?= esc(
                            $application['phone']
                        ) ?>
                    </div>
                </div>
                <div class="application-summary-row">
                    <div class="application-summary-label">
                        通訊地址
                    </div>
                    <div class="application-summary-value">
                        <?= esc(
                            $application['address']
                        ) ?>
                    </div>
                </div>
                <div class="application-summary-row">
                    <div class="application-summary-label">
                        電子郵件
                    </div>
                    <div class="application-summary-value">
                        <?= esc(
                            $application['email']
                        ) ?>
                    </div>
                </div>
            </div>
            <div class="application-confirm-edit-hint">
                <i class="bi bi-info-circle"></i>
                如需修改報名資料，請返回「立即報名」頁面修改。
            </div>
        </section>
        <section class="apply-content-card">
            <h3 class="apply-section-title">
                <i class="bi bi-list-check"></i>
                正式報名校系
            </h3>
            <table class="application-confirm-department-table">
                <tbody>
                    <?php for ($i = 0; $i < 6; $i++): ?>
                        <tr>
                            <td class="application-confirm-department-label">
                                校系 <?= $i + 1 ?>
                            </td>
                            <td class="application-confirm-department-value">
                                <?php if (isset($selectedDepartments[$i])): ?>
                                    <?= esc(
                                        $selectedDepartments[$i]['department_code']
                                    ) ?>
                                    -
                                    <?= esc(
                                        $selectedDepartments[$i]['university_name']
                                    ) ?>
                                    -
                                    <?= esc(
                                        $selectedDepartments[$i]['department_name']
                                    ) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </section>
        <section class="application-confirm-warning">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>
                <strong>
                    重要提醒
                </strong>
                <p>
                    以上各欄位皆已核對正確無誤，若有錯誤以致影響權益，概由本人自行負責。
                </p>
            </div>
        </section>
        <section class="apply-content-card">
            <form action="<?= site_url(
                'application/confirm/submit'
            ) ?>" method="post" id="applicationConfirmForm">
                <?= csrf_field() ?>
                <div class="application-confirm-agreement">
                    <label>
                        <input type="checkbox" id="applicationConfirmAgreement" required>
                        <span>
                            我已確認以上資料正確無誤，並同意正式送出報名。
                        </span>
                    </label>
                </div>
                <div class="apply-actions application-actions">
                    <a href="<?= site_url(
                        'application/selection'
                    ) ?>" class="apply-secondary-button">
                        <i class="bi bi-arrow-left"></i>
                        返回修改選擇
                    </a>
                    <button type="submit" class="apply-primary-button">
                        <i class="bi bi-send-check"></i>
                        正式送出報名
                    </button>
                </div>
            </form>
        </section>
    </main>
    <footer class="apply-footer">
        Apply116 網路報名系統
    </footer>
    <script>
        document
            .getElementById(
                'applicationConfirmForm'
            )
            .addEventListener(
                'submit',
                function (event) {
                    const confirmed =
                        window.confirm(
                            '正式送出報名後將無法再修改。\n\n確定要正式送出報名嗎？'
                        );
                    if (!confirmed) {
                        event.preventDefault();
                    }
                }
            );
    </script>
</body>
</html>