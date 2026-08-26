<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>網路報名系統 - 立即報名</title>
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
                        session()->get('candidate_name') ?? ''
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
                <i class="bi bi-pencil-square"></i>
                立即報名
            </h2>
            <p>
                <?= $hasBasicData
                    ? '請確認您的報名基本資料，確認無誤後即可開始選擇報名校系。'
                    : '請先填寫您的報名基本資料，完成後即可開始選擇報名校系。'
                    ?>
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
        <?php if (
            session()->getFlashdata('success')
        ): ?>
            <div class="apply-success-message">
                <i class="bi bi-check-circle"></i>
                <?= esc(
                    session()->getFlashdata('success')
                ) ?>
            </div>
        <?php endif; ?>
        <section class="apply-content-card">
            <h3 class="apply-section-title">
                <i class="bi bi-person-vcard"></i>
                考生基本資料
            </h3>
            <div class="application-readonly-info">
                <div class="application-info-item">
                    <span class="application-info-label">
                        學測應試號碼
                    </span>
                    <span class="application-info-value">
                        <?= esc(
                            $candidate['exam_number']
                        ) ?>
                    </span>
                </div>
                <div class="application-info-item">
                    <span class="application-info-label">
                        身分證號碼
                    </span>
                    <span class="application-info-value">
                        <?php
                        $idNumber =
                            $candidate['id_number']
                            ?? '';
                        if (
                            strlen($idNumber) > 4
                        ) {
                            $maskedId =
                                str_repeat(
                                    '*',
                                    strlen($idNumber) - 4
                                )
                                . substr(
                                    $idNumber,
                                    -4
                                );
                        } else {
                            $maskedId =
                                $idNumber;
                        }
                        ?>
                        <?= esc($maskedId) ?>
                    </span>
                </div>
                <div class="application-info-item">
                    <span class="application-info-label">
                        姓名
                    </span>
                    <span class="application-info-value">
                        <?= esc(
                            $candidate['name']
                        ) ?>
                    </span>
                </div>
            </div>
        </section>
        <section class="apply-content-card">
            <div class="application-section-title">
                <h3 class="apply-section-title">
                    <i class="bi bi-clipboard-check"></i>
                    報名資料
                </h3>
                <span class="application-section-hint">
                    正式送出報名前可以隨時更新
                </span>
            </div>
            <?php $isConfirmed = $application && ($application['status'] ?? '') === 'confirmed'; ?>
            <?php if ($hasBasicData): ?>
                <div class="application-summary">
                    <div class="application-summary-row">
                        <span class="application-summary-label">
                            出生年月日
                        </span>
                        <span class="application-summary-value">
                            <?= esc($application['birth_date']) ?>
                        </span>
                    </div>
                    <div class="application-summary-row">
                        <span class="application-summary-label">
                            手機號碼
                        </span>
                        <span class="application-summary-value">
                            <?= esc($application['phone']) ?>
                        </span>
                    </div>
                    <div class="application-summary-row">
                        <span class="application-summary-label">
                            通訊地址
                        </span>
                        <span class="application-summary-value">
                            <?= esc($application['address']) ?>
                        </span>
                    </div>
                    <div class="application-summary-row">
                        <span class="application-summary-label">
                            電子郵件
                        </span>
                        <span class="application-summary-value">
                            <?= esc($application['email']) ?>
                        </span>
                    </div>
                </div>
                <?php if ($isConfirmed): ?>
                    <div class="application-locked-message">
                        <i class="bi bi-lock-fill"></i>
                        報名已確認送出，資料無法修改。
                    </div>
                    <div class="apply-actions application-actions">
                        <a href="<?= site_url('application-status') ?>" class="apply-primary-button">
                            <i class="bi bi-file-earmark-text"></i>
                            查看報名狀態
                        </a>
                    </div>
                <?php else: ?>
                    <div class="apply-actions application-actions">
                        <a href="<?= site_url('application/edit') ?>" class="apply-secondary-button">
                            <i class="bi bi-pencil"></i>
                            修改報名資料
                        </a>
                        <a href="<?= site_url('application/departments') ?>" class="apply-primary-button">
                            <i class="bi bi-list-check"></i>
                            開始選擇校系
                        </a>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <form action="<?= site_url('application/save') ?>" method="post" id="applicationForm">
                    <?= csrf_field() ?>
                    <div class="application-form-row">
                        <label for="birth_date">
                            出生年月日
                            <span class="application-required">
                                *
                            </span>
                        </label>
                        <input type="date" id="birth_date" name="birth_date" value="<?= esc(
                            $application['birth_date']
                            ?? ''
                        ) ?>" required>
                    </div>
                    <div class="application-form-row">
                        <label for="phone">
                            手機號碼
                            <span class="application-required">
                                *
                            </span>
                        </label>
                        <input type="tel" id="phone" name="phone" value="<?= esc(
                            $application['phone']
                            ?? ''
                        ) ?>" maxlength="10" minlength="10" pattern="09[0-9]{8}" inputmode="numeric" autocomplete="tel"
                            placeholder="請輸入 09xxxxxxxx" title="請輸入 10 位數手機號碼，例如 0912345678" required>
                    </div>
                    <div class="application-form-row">
                        <label for="address">
                            通訊地址
                            <span class="application-required">
                                *
                            </span>
                        </label>
                        <input type="text" id="address" name="address" value="<?= esc(
                            $application['address']
                            ?? ''
                        ) ?>" maxlength="255" autocomplete="street-address" required>
                    </div>
                    <div class="application-form-row">
                        <label for="email">
                            電子郵件
                            <span class="application-required">
                                *
                            </span>
                        </label>
                        <input type="email" id="email" name="email" value="<?= esc(
                            $application['email']
                            ?? ''
                        ) ?>" maxlength="255" autocomplete="email" required>
                    </div>
                    <div class="apply-actions application-actions">
                        <button type="submit" class="apply-primary-button">
                            <i class="bi bi-check2"></i>
                            儲存並繼續
                        </button>
                        <a href="<?= site_url('apply') ?>" class="apply-secondary-button">
                            <i class="bi bi-arrow-left"></i>
                            返回首頁
                        </a>
                    </div>
                </form>
            <?php endif; ?>
        </section>
    </main>
    <footer class="apply-footer">
        Apply116 網路報名系統
    </footer>
</body>

</html>