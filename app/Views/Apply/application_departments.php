<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>網路報名系統 - 選擇報名校系</title>
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
                    <?= esc(session()->get('exam_number')) ?>
                </span>
                <span class="apply-header-text">
                    姓名：
                    <?= esc(session()->get('candidate_name') ?? '') ?>
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
                <i class="bi bi-list-check"></i>
                選擇報名校系
            </h2>
            <p>
                請先從校系資料中選擇您有興趣的校系，
                加入「我的校系清單」，再從清單中選擇最多 6 個校系進行正式報名。
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
        <!-- 搜尋區 -->
        <section class="apply-content-card department-search-card application-department-search-card">
            <h3 class="apply-section-title">
                查詢條件
            </h3>
            <form action="<?= site_url('application/departments') ?>" method="get" id="applicationDepartmentSearchForm">
                <div class="department-search-row">
                    <label for="keyword">
                        關鍵字：
                    </label>
                    <input type="text" id="keyword" name="keyword" value="<?= esc($keyword ?? '') ?>"
                        placeholder="請輸入搜尋關鍵字">
                </div>
                <div class="department-search-row">
                    <label for="university">
                        學校名稱：
                    </label>
                    <select id="university" name="university">
                        <option value="">
                            不限
                        </option>
                        <?php foreach ($universities as $universityItem): ?>
                            <option value="<?= esc($universityItem['university_code']) ?>" <?= (($university ?? '') === $universityItem['university_code']) ? 'selected' : '' ?>>
                                <?= esc($universityItem['university_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="department-search-row">
                    <label for="english_listening">
                        英聽檢定：
                    </label>
                    <select id="english_listening" name="english_listening">
                        <option value="" <?= ($englishListening ?? '') === ''
                            ? 'selected'
                            : '' ?>>
                            不限
                        </option>
                        <option value="required" <?= ($englishListening ?? '') === 'required'
                            ? 'selected'
                            : '' ?>>
                            有英聽檢定要求
                        </option>
                        <option value="not_required" <?= ($englishListening ?? '') === 'not_required'
                            ? 'selected'
                            : '' ?>>
                            無英聽檢定要求
                        </option>
                    </select>
                </div>
                <div class="department-requirement-section">
                    <div class="department-requirement-title">
                        <i class="bi bi-book"></i>
                        學測檢定科目
                    </div>
                    <p class="department-requirement-hint">
                        請選擇各科目的檢定條件；選擇「不限」表示不限制該科目。
                    </p>
                    <div class="requirement-row">
                        <div class="requirement-subject">
                            國文
                        </div>
                        <label>
                            <input type="radio" name="requirements_status[chinese]" value="any"
                                <?= ($requirementsStatus['chinese'] ?? 'any') === 'any'
                                    ? 'checked'
                                    : '' ?>>
                            不限
                        </label>
                        <label>
                            <input type="radio" name="requirements_status[chinese]" value="required"
                                <?= ($requirementsStatus['chinese'] ?? '') === 'required'
                                    ? 'checked'
                                    : '' ?>>
                            參採
                        </label>
                        <label>
                            <input type="radio" name="requirements_status[chinese]" value="not_required"
                                <?= ($requirementsStatus['chinese'] ?? '') === 'not_required'
                                    ? 'checked'
                                    : '' ?>>
                            不參採
                        </label>
                    </div>
                    <div class="requirement-row">
                        <div class="requirement-subject">
                            英文
                        </div>
                        <label>
                            <input type="radio" name="requirements_status[english]" value="any"
                                <?= ($requirementsStatus['english'] ?? 'any') === 'any'
                                    ? 'checked'
                                    : '' ?>>
                            不限
                        </label>
                        <label>
                            <input type="radio" name="requirements_status[english]" value="required"
                                <?= ($requirementsStatus['english'] ?? '') === 'required'
                                    ? 'checked'
                                    : '' ?>>
                            參採
                        </label>
                        <label>
                            <input type="radio" name="requirements_status[english]" value="not_required"
                                <?= ($requirementsStatus['english'] ?? '') === 'not_required'
                                    ? 'checked'
                                    : '' ?>>
                            不參採
                        </label>
                    </div>
                    <div class="requirement-row">
                        <div class="requirement-subject">
                            數學A
                        </div>
                        <label>
                            <input type="radio" name="requirements_status[math_a]" value="any"
                                <?= ($requirementsStatus['math_a'] ?? 'any') === 'any'
                                    ? 'checked'
                                    : '' ?>>
                            不限
                        </label>
                        <label>
                            <input type="radio" name="requirements_status[math_a]" value="required"
                                <?= ($requirementsStatus['math_a'] ?? '') === 'required'
                                    ? 'checked'
                                    : '' ?>>
                            參採
                        </label>
                        <label>
                            <input type="radio" name="requirements_status[math_a]" value="not_required"
                                <?= ($requirementsStatus['math_a'] ?? '') === 'not_required'
                                    ? 'checked'
                                    : '' ?>>
                            不參採
                        </label>
                    </div>
                    <div class="requirement-row">
                        <div class="requirement-subject">
                            數學B
                        </div>
                        <label>
                            <input type="radio" name="requirements_status[math_b]" value="any"
                                <?= ($requirementsStatus['math_b'] ?? 'any') === 'any'
                                    ? 'checked'
                                    : '' ?>>
                            不限
                        </label>
                        <label>
                            <input type="radio" name="requirements_status[math_b]" value="required"
                                <?= ($requirementsStatus['math_b'] ?? '') === 'required'
                                    ? 'checked'
                                    : '' ?>>
                            參採
                        </label>
                        <label>
                            <input type="radio" name="requirements_status[math_b]" value="not_required"
                                <?= ($requirementsStatus['math_b'] ?? '') === 'not_required'
                                    ? 'checked'
                                    : '' ?>>
                            不參採
                        </label>
                    </div>
                    <div class="requirement-row">
                        <div class="requirement-subject">
                            社會
                        </div>
                        <label>
                            <input type="radio" name="requirements_status[social]" value="any"
                                <?= ($requirementsStatus['social'] ?? 'any') === 'any'
                                    ? 'checked'
                                    : '' ?>>
                            不限
                        </label>
                        <label>
                            <input type="radio" name="requirements_status[social]" value="required"
                                <?= ($requirementsStatus['social'] ?? '') === 'required'
                                    ? 'checked'
                                    : '' ?>>
                            參採
                        </label>
                        <label>
                            <input type="radio" name="requirements_status[social]" value="not_required"
                                <?= ($requirementsStatus['social'] ?? '') === 'not_required'
                                    ? 'checked'
                                    : '' ?>>
                            不參採
                        </label>
                    </div>
                    <div class="requirement-row">
                        <div class="requirement-subject">
                            自然
                        </div>
                        <label>
                            <input type="radio" name="requirements_status[natural]" value="any"
                                <?= ($requirementsStatus['natural'] ?? 'any') === 'any'
                                    ? 'checked'
                                    : '' ?>>
                            不限
                        </label>
                        <label>
                            <input type="radio" name="requirements_status[natural]" value="required"
                                <?= ($requirementsStatus['natural'] ?? '') === 'required'
                                    ? 'checked'
                                    : '' ?>>
                            參採
                        </label>
                        <label>
                            <input type="radio" name="requirements_status[natural]" value="not_required"
                                <?= ($requirementsStatus['natural'] ?? '') === 'not_required'
                                    ? 'checked'
                                    : '' ?>>
                            不參採
                        </label>
                    </div>
                </div>
                <!-- 搜尋按鈕 -->
                <div class="apply-actions">
                    <button type="submit" class="apply-primary-button">
                        <i class="bi bi-search"></i>
                        開始查詢
                    </button>
                    <a href="<?= site_url('application/departments') ?>" class="apply-secondary-button">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        清除條件
                    </a>
                </div>
            </form>
        </section>
        <!-- 查詢條件提示 -->
        <?php if (
            $keyword !== ''
            || $university !== ''
            || $englishListening !== ''
            || !empty($conditionTexts)
        ): ?>
            <section class="apply-info-message">
                <strong>
                    <i class="bi bi-info-circle"></i>
                    您的查詢條件為：
                </strong>
                <?php $displayConditions = []; ?>
                <?php if ($keyword !== ''): ?>
                    <?php
                    $displayConditions[] =
                        '關鍵字「' . esc($keyword) . '」';
                    ?>
                <?php endif; ?>
                <?php if ($university !== ''): ?>
                    <?php foreach (
                        $universities
                        as $universityItem
                    ): ?>
                        <?php if (
                            $universityItem[
                                'university_code'
                            ]
                            === $university
                        ): ?>
                            <?php
                            $displayConditions[] =
                                '學校「' . esc($universityItem['university_name']) . '」';
                            ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if (
                    $englishListening
                    === 'required'
                ): ?>
                    <?php
                    $displayConditions[] =
                        '英聽參採';
                    ?>
                <?php elseif (
                    $englishListening
                    === 'not_required'
                ): ?>
                    <?php
                    $displayConditions[] =
                        '英聽不參採';
                    ?>
                <?php endif; ?>
                <?php foreach (
                    $requirementsStatus
                    as $key => $status
                ): ?>
                    <?php
                    $subjectNames = [
                        'chinese' => '國文',
                        'english' => '英文',
                        'math_a' => '數學A',
                        'math_b' => '數學B',
                        'social' => '社會',
                        'natural' => '自然',
                    ];
                    ?>
                    <?php if (
                        isset(
                        $subjectNames[$key]
                    )
                    ): ?>
                        <?php if (
                            $status
                            === 'required'
                        ): ?>
                            <?php
                            $displayConditions[] =
                                $subjectNames[$key]
                                . '參採';
                            ?>
                        <?php elseif (
                            $status
                            === 'not_required'
                        ): ?>
                            <?php
                            $displayConditions[] =
                                $subjectNames[$key]
                                . '不參採';
                            ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?= implode('，', $displayConditions) ?>
                ，符合以上條件之校系。
            </section>
        <?php endif; ?>
        <!-- 搜尋結果 -->
        <section class="apply-content-card department-result-card">
            <div class="department-result-header">
                <h3 class="apply-section-title">
                    <i class="bi bi-list-ul"></i>
                    校系資料
                </h3>
                <span class="department-result-count">
                    共 <?= $pager->getTotal('application_department') ?> 筆
                </span>
            </div>
            <?php if (empty($departments)): ?>
                <div class="apply-info-message">
                    <i class="bi bi-search"></i>
                    找不到符合條件的校系資料， 請嘗試調整查詢條件。
                </div>
            <?php else: ?>
                <div class="department-table-wrapper">
                    <table class="apply-table application-department-table">
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
                            <?php foreach ($departments as $department): ?>
                                <tr class="department-main-row">
                                    <td>
                                        <?= esc($department['university_code']) ?>
                                    </td>
                                    <td>
                                        <?= esc($department['university_name']) ?>
                                    </td>
                                    <td>
                                        <?= esc($department['department_code']) ?>
                                    </td>
                                    <td>
                                        <?= esc($department['department_name']) ?>
                                    </td>
                                    <td>
                                        <?= esc($department['admission_quota']) ?>
                                    </td>
                                    <td class="application-department-detail">
                                        <button type="button" class="department-detail-button"
                                            onclick="toggleDepartmentDetail(this)">
                                            <i class="bi bi-chevron-down"></i>
                                            查看詳細
                                        </button>
                                    </td>
                                    <td class="application-department-operation">
                                        <?php if (
                                            in_array(
                                                (int) $department['id'],
                                                $cartDepartmentIds,
                                                true
                                            )
                                        ): ?>
                                            <span class="application-added-button">
                                                <i class="bi bi-check-circle-fill"></i>
                                                已加入
                                            </span>
                                        <?php else: ?>
                                            <form action="<?= site_url(
                                                'application/cart/add/'
                                                . $department['id']
                                            ) ?>" method="post" class="application-add-form">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="application-add-button">
                                                    <i class="bi bi-bookmark-plus"></i>
                                                    加入
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr class="department-detail-row" style="display: none;">
                                    <td colspan="7">
                                        <div class="department-detail-content">
                                            <div class="department-detail-title">
                                                <i class="bi bi-book"></i>
                                                檢定科目要求
                                            </div>
                                            <div class="department-requirement-grid">
                                                <div class="department-requirement-item">
                                                    <span class="requirement-label">
                                                        國文
                                                    </span>
                                                    <span class="requirement-value">
                                                        <?= esc(
                                                            $department[
                                                                'chinese_requirement'
                                                            ]
                                                        ) ?>
                                                    </span>
                                                </div>
                                                <div class="department-requirement-item">
                                                    <span class="requirement-label">
                                                        英文
                                                    </span>
                                                    <span class="requirement-value">
                                                        <?= esc(
                                                            $department[
                                                                'english_requirement'
                                                            ]
                                                        ) ?>
                                                    </span>
                                                </div>
                                                <div class="department-requirement-item">
                                                    <span class="requirement-label">
                                                        數學A
                                                    </span>
                                                    <span class="requirement-value">
                                                        <?= esc(
                                                            $department[
                                                                'math_a_requirement'
                                                            ]
                                                        ) ?>
                                                    </span>
                                                </div>
                                                <div class="department-requirement-item">
                                                    <span class="requirement-label">
                                                        數學B
                                                    </span>
                                                    <span class="requirement-value">
                                                        <?= esc(
                                                            $department[
                                                                'math_b_requirement'
                                                            ]
                                                        ) ?>
                                                    </span>
                                                </div>
                                                <div class="department-requirement-item">
                                                    <span class="requirement-label">
                                                        社會
                                                    </span>
                                                    <span class="requirement-value">
                                                        <?= esc(
                                                            $department[
                                                                'social_requirement'
                                                            ]
                                                        ) ?>
                                                    </span>
                                                </div>
                                                <div class="department-requirement-item">
                                                    <span class="requirement-label">
                                                        自然
                                                    </span>
                                                    <span class="requirement-value">
                                                        <?= esc(
                                                            $department[
                                                                'natural_requirement'
                                                            ]
                                                        ) ?>
                                                    </span>
                                                </div>
                                                <div class="department-requirement-item">
                                                    <span class="requirement-label">
                                                        英聽
                                                    </span>
                                                    <span class="requirement-value">
                                                        <?= esc(
                                                            $department[
                                                                'english_listening_requirement'
                                                            ]
                                                        ) ?>
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
                <!-- 分頁 -->
                <div class="department-pagination">
                    <?= $pager->links(
                        'application_department',
                        'department'
                    ) ?>
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