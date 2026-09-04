<?php
$currentUri = trim(uri_string(), '/');
$navbarPages = $navbarPages ?? [];
?>

<header class="home-header">

    <!-- 網站標題 -->
    <div class="home-header-title">
        <a href="<?= base_url('/') ?>">
            Apply 116
        </a>
    </div>

    <!-- Navbar -->
    <nav class="home-nav">

        <!-- 首頁 -->
        <a href="<?= base_url('/') ?>"
            class="home-nav-link <?= $currentUri === '' ? 'active' : '' ?>">
            首頁
        </a>

        <?php foreach ($navbarPages as $item): ?>

            <?php
            $page = $item['page'];
            $visible = $item['visible'];
            $message = $item['message'];

            // 關閉期間且設定為隱藏
            if (!$visible) {
                continue;
            }

            // 考生註冊／考生登入改由右側按鈕顯示
            if (in_array($page['page_key'], ['register', 'login'], true)) {
                continue;
            }

            $route = trim($page['route'], '/');
            $isActive = $currentUri === $route;
            ?>

            <a href="<?= base_url($route) ?>"
                class="home-nav-link <?= $isActive ? 'active' : '' ?>">

                <?= esc($page['title']) ?>

            </a>

        <?php endforeach; ?>

    </nav>

    <!-- 右側：註冊／登入 -->
    <div class="home-header-right">

        <?php
        $registerPage = null;
        $loginPage = null;

        foreach ($navbarPages as $item) {

            if ($item['page']['page_key'] === 'register') {
                $registerPage = $item;
            }

            if ($item['page']['page_key'] === 'login') {
                $loginPage = $item;
            }
        }
        ?>

        <!-- 考生註冊 -->
        <?php if ($registerPage && $registerPage['visible']): ?>

            <a href="<?= base_url($registerPage['page']['route']) ?>"
                class="home-login-button"
                rel="noopener noreferrer">

                <?= esc($registerPage['page']['title']) ?>

            </a>

        <?php endif; ?>

        <!-- 考生登入 -->
        <?php if ($loginPage && $loginPage['visible']): ?>

            <a href="<?= base_url($loginPage['page']['route']) ?>"
                class="home-register-button"
                rel="noopener noreferrer">

                <?= esc($loginPage['page']['title']) ?>

            </a>

        <?php endif; ?>

    </div>

</header>