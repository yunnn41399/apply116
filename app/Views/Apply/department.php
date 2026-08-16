<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <title>查詢校系資料</title>
    <!-- 共用樣式 -->
    <link
        rel="stylesheet"
        href="<?= base_url('CSS/common.css') ?>"
    >
    <!-- 網路報名系統樣式 -->
    <link
        rel="stylesheet"
        href="<?= base_url('CSS/apply.css') ?>"
    >
    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    >
</head>
<body>
    <!-- ========================================
         Header
         ======================================== -->

        <header class="apply-header">
        <h1 class="apply-header-title">
            網路報名系統
        </h1>
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
    <!-- ========================================
         Main
         ======================================== -->
    <main class="apply-container">
        <!-- ========================================
             頁面標題
             ======================================== -->
        <section class="apply-welcome">
            <h2>
                <i class="bi bi-search"></i>
                查詢校系資料
            </h2>
            <p>
                可透過關鍵字、學校、英聽及學科檢定條件查詢校系資料。
            </p>
        </section>
        <!-- ========================================
             搜尋區
             ======================================== -->
        <section class="apply-content-card department-search-card">
            <h3 class="apply-section-title">
                查詢條件
            </h3>
            <form
                action="<?= site_url('department') ?>"
                method="get"
                id="departmentSearchForm"
            >
                <!-- ========================================
                     關鍵字
                     ======================================== -->
                <div class="department-search-row">
                    <label for="keyword">
                        關鍵字：
                    </label>
                    <input
                        type="text"
                        id="keyword"
                        name="keyword"
                        value="<?= esc($keyword ?? '') ?>"
                        placeholder="請輸入學校名稱或學系名稱"
                    >
                </div>
                <!-- ========================================
                     學校
                     ======================================== -->
                <div class="department-search-row">
                    <label for="university">
                        學校：
                    </label>
                    <select
                        id="university"
                        name="university"
                    >
                        <option value="">
                            不限
                        </option>
                        <?php foreach ($universities as $universityItem): ?>
                            <option
                                value="<?= esc($universityItem['university_code']) ?>"
                                <?= ($university ?? '') === $universityItem['university_code']
                                    ? 'selected'
                                    : '' ?>
                            >
                                <?= esc($universityItem['university_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- ========================================
                     英聽
                     ======================================== -->
                <div class="department-search-row">
                    <label for="english_listening">
                        英聽：
                    </label>
                    <select
                        id="english_listening"
                        name="english_listening"
                    >
                        <option
                            value=""
                            <?= ($englishListening ?? '') === ''
                                ? 'selected'
                                : '' ?>
                        >
                            不限
                        </option>
                        <option
                            value="required"
                            <?= ($englishListening ?? '') === 'required'
                                ? 'selected'
                                : '' ?>
                        >
                            有英聽檢定要求
                        </option>
                        <option
                            value="not_required"
                            <?= ($englishListening ?? '') === 'not_required'
                                ? 'selected'
                                : '' ?>
                        >
                            無英聽檢定要求
                        </option>
                    </select>
                </div>
                <!-- ========================================
                     檢定科目
                     ======================================== -->
                <div class="department-requirement-section">
                    <div class="department-requirement-title">
                        <i class="bi bi-book"></i>
                        檢定科目
                    </div>
                    <p class="department-requirement-hint">
                        請選擇各科目的檢定條件；選擇「不限」表示不限制該科目。
                    </p>
                    <!-- 國文 -->
                    <div class="requirement-row">
                        <div class="requirement-subject">
                            國文
                        </div>
                        <label>
                            <input
                                type="radio"
                                name="requirements_status[chinese]"
                                value="any"
                                <?= ($requirementsStatus['chinese'] ?? 'any') === 'any'
                                    ? 'checked'
                                    : '' ?>
                            >
                            不限
                        </label>
                        <label>
                            <input
                                type="radio"
                                name="requirements_status[chinese]"
                                value="required"
                                <?= ($requirementsStatus['chinese'] ?? '') === 'required'
                                    ? 'checked'
                                    : '' ?>
                            >
                            參採
                        </label>
                        <label>
                            <input
                                type="radio"
                                name="requirements_status[chinese]"
                                value="not_required"
                                <?= ($requirementsStatus['chinese'] ?? '') === 'not_required'
                                    ? 'checked'
                                    : '' ?>
                            >
                            不參採
                        </label>
                    </div>
                    <!-- 英文 -->
                    <div class="requirement-row">
                        <div class="requirement-subject">
                            英文
                        </div>
                        <label>
                            <input
                                type="radio"
                                name="requirements_status[english]"
                                value="any"
                                <?= ($requirementsStatus['english'] ?? 'any') === 'any'
                                    ? 'checked'
                                    : '' ?>
                            >
                            不限
                        </label>
                        <label>
                            <input
                                type="radio"
                                name="requirements_status[english]"
                                value="required"
                                <?= ($requirementsStatus['english'] ?? '') === 'required'
                                    ? 'checked'
                                    : '' ?>
                            >
                            參採
                        </label>
                        <label>
                            <input
                                type="radio"
                                name="requirements_status[english]"
                                value="not_required"
                                <?= ($requirementsStatus['english'] ?? '') === 'not_required'
                                    ? 'checked'
                                    : '' ?>
                            >
                            不參採
                        </label>
                    </div>
                    <!-- 數學A -->
                    <div class="requirement-row">
                        <div class="requirement-subject">
                            數學A
                        </div>
                        <label>
                            <input
                                type="radio"
                                name="requirements_status[math_a]"
                                value="any"
                                <?= ($requirementsStatus['math_a'] ?? 'any') === 'any'
                                    ? 'checked'
                                    : '' ?>
                            >
                            不限
                        </label>
                        <label>
                            <input
                                type="radio"
                                name="requirements_status[math_a]"
                                value="required"
                                <?= ($requirementsStatus['math_a'] ?? '') === 'required'
                                    ? 'checked'
                                    : '' ?>
                            >
                            參採
                        </label>
                        <label>
                            <input
                                type="radio"
                                name="requirements_status[math_a]"
                                value="not_required"
                                <?= ($requirementsStatus['math_a'] ?? '') === 'not_required'
                                    ? 'checked'
                                    : '' ?>
                            >
                            不參採
                        </label>
                    </div>
                    <!-- 數學B -->
                    <div class="requirement-row">
                        <div class="requirement-subject">
                            數學B
                        </div>
                        <label>
                            <input
                                type="radio"
                                name="requirements_status[math_b]"
                                value="any"
                                <?= ($requirementsStatus['math_b'] ?? 'any') === 'any'
                                    ? 'checked'
                                    : '' ?>
                            >
                            不限
                        </label>
                        <label>
                            <input
                                type="radio"
                                name="requirements_status[math_b]"
                                value="required"
                                <?= ($requirementsStatus['math_b'] ?? '') === 'required'
                                    ? 'checked'
                                    : '' ?>
                            >
                            參採
                        </label>
                        <label>
                            <input
                                type="radio"
                                name="requirements_status[math_b]"
                                value="not_required"
                                <?= ($requirementsStatus['math_b'] ?? '') === 'not_required'
                                    ? 'checked'
                                    : '' ?>
                            >
                            不參採
                        </label>
                    </div>
                    <!-- 社會 -->
                    <div class="requirement-row">
                        <div class="requirement-subject">
                            社會
                        </div>
                        <label>
                            <input
                                type="radio"
                                name="requirements_status[social]"
                                value="any"
                                <?= ($requirementsStatus['social'] ?? 'any') === 'any'
                                    ? 'checked'
                                    : '' ?>
                            >
                            不限
                        </label>
                        <label>
                            <input
                                type="radio"
                                name="requirements_status[social]"
                                value="required"
                                <?= ($requirementsStatus['social'] ?? '') === 'required'
                                    ? 'checked'
                                    : '' ?>
                            >
                            參採
                        </label>
                        <label>
                            <input
                                type="radio"
                                name="requirements_status[social]"
                                value="not_required"
                                <?= ($requirementsStatus['social'] ?? '') === 'not_required'
                                    ? 'checked'
                                    : '' ?>
                            >
                            不參採
                        </label>
                    </div>
                    <!-- 自然 -->
                    <div class="requirement-row">
                        <div class="requirement-subject">
                            自然
                        </div>
                        <label>
                            <input
                                type="radio"
                                name="requirements_status[natural]"
                                value="any"
                                <?= ($requirementsStatus['natural'] ?? 'any') === 'any'
                                    ? 'checked'
                                    : '' ?>
                            >
                            不限
                        </label>
                        <label>
                            <input
                                type="radio"
                                name="requirements_status[natural]"
                                value="required"
                                <?= ($requirementsStatus['natural'] ?? '') === 'required'
                                    ? 'checked'
                                    : '' ?>
                            >
                            參採
                        </label>
                        <label>
                            <input
                                type="radio"
                                name="requirements_status[natural]"
                                value="not_required"
                                <?= ($requirementsStatus['natural'] ?? '') === 'not_required'
                                    ? 'checked'
                                    : '' ?>
                            >
                            不參採
                        </label>
                    </div>
                </div>
                <!-- ========================================
                     按鈕
                     ======================================== -->
                <div class="apply-actions">
                    <button
                        type="submit"
                        class="apply-primary-button"
                    >
                        <i class="bi bi-search"></i>
                        開始查詢
                    </button>
                    <a
                        href="<?= site_url('department') ?>"
                        class="apply-secondary-button"
                    >
                        <i class="bi bi-arrow-counterclockwise"></i>
                        清除條件
                    </a>
                </div>
            </form>
        </section>
        <!-- ========================================
             查詢條件提示
             ======================================== -->
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
            <?php foreach ($universities as $universityItem): ?>
                <?php if (
                    $universityItem['university_code']
                    === $university
                ): ?>
                    <?php
                    $displayConditions[] =
                        '學校「'
                        . esc(
                            $universityItem['university_name']
                        )
                        . '」';
                    ?>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (
            $englishListening === 'required'
        ): ?>
            <?php
            $displayConditions[] =
                '英聽參採';
            ?>
        <?php elseif (
            $englishListening === 'not_required'
        ): ?>
            <?php
            $displayConditions[] =
                '英聽不參採';
            ?>
        <?php endif; ?>
        <?php foreach (
            $requirementsStatus as $key => $status
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
                isset($subjectNames[$key])
            ): ?>
                <?php if (
                    $status === 'required'
                ): ?>
                    <?php
                    $displayConditions[] =
                        $subjectNames[$key]
                        . '參採';
                    ?>
                <?php elseif (
                    $status === 'not_required'
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
        <!-- ========================================
             搜尋結果
             ======================================== -->
        <section class="apply-content-card department-result-card">
            <div class="department-result-header">
                <h3 class="apply-section-title">
                    <i class="bi bi-list-ul"></i>
                    校系資料
                </h3>
                <span class="department-result-count">
                    共 <?= count($departments) ?> 筆
                </span>
            </div>
            <?php if (empty($departments)): ?>
                <div class="apply-info-message">
                    <i class="bi bi-search"></i>
                    找不到符合條件的校系資料，請嘗試調整查詢條件。
                </div>
            <?php else: ?>
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
                                    國文
                                </th>
                                <th>
                                    英文
                                </th>
                                <th>
                                    數學A
                                </th>
                                <th>
                                    數學B
                                </th>
                                <th>
                                    社會
                                </th>
                                <th>
                                    自然
                                </th>
                                <th>
                                    英聽
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($departments as $department): ?>
                                <tr>
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
                                    <td>
                                        <?= esc($department['chinese_requirement']) ?>
                                    </td>
                                    <td>
                                        <?= esc($department['english_requirement']) ?>
                                    </td>
                                    <td>
                                        <?= esc($department['math_a_requirement']) ?>
                                    </td>
                                    <td>
                                        <?= esc($department['math_b_requirement']) ?>
                                    </td>
                                    <td>
                                        <?= esc($department['social_requirement']) ?>
                                    </td>
                                    <td>
                                        <?= esc($department['natural_requirement']) ?>
                                    </td>
                                    <td>
                                        <?= esc($department['english_listening_requirement']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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