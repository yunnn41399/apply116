<?php
$currentUri = trim(uri_string(), '/');
?>
<header class="home-header">
    <div class="home-header-title">
        <a href="<?= base_url('/') ?>">
            Apply 116
        </a>
    </div>
    <nav class="home-nav">
        <a href="<?= base_url('/') ?>" class="home-nav-link <?= $currentUri === '' ? 'active' : '' ?>">
            首頁
        </a>
        <a href="<?= base_url('department') ?>"
            class="home-nav-link <?= $currentUri === 'department' ? 'active' : '' ?>">
            校系分則查詢
        </a>
        <a href="<?= base_url('application-info') ?>"
            class="home-nav-link <?= $currentUri === 'application-info' ? 'active' : '' ?>">
            網路報名系統
        </a>
        <a href="<?= base_url('filter-result') ?>"
            class="home-nav-link <?= $currentUri === 'filter-result' ? 'active' : '' ?>">
            篩選結果查詢
        </a>
        <a href="<?= base_url('review-upload') ?>"
            class="home-nav-link <?= $currentUri === 'review-upload' ? 'active' : '' ?>">
            審查資料上傳系統
        </a>
        <a href="<?= base_url('online-selection') ?>"
            class="home-nav-link <?= $currentUri === 'online-selection' ? 'active' : '' ?>">
            網路登記志願
        </a>
        <a href="<?= base_url('distribution-result') ?>"
            class="home-nav-link <?= $currentUri === 'distribution-result' ? 'active' : '' ?>">
            分發結果查詢
        </a>
    </nav>
    <div class="home-header-right">
        <a href="<?= base_url('register') ?>" class="home-login-button" target="_blank" rel="noopener noreferrer">
            考生註冊
        </a>
        <a href="<?= base_url('login') ?>" class="home-register-button" target="_blank" rel="noopener noreferrer">
            考生登入
        </a>
    </div>
</header>