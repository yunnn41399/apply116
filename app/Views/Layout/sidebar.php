<?php
$currentUri = trim(uri_string(), '/');

// 確保變數存在，若 Controller 沒傳入則設為空陣列
$sidebarPages = $sidebarPages ?? [];
$sidebarGroups = $sidebarGroups ?? [];

/*
 * 將 sidebar 頁面依 page_key 分組
 */
$admissionPages = [];
$relatedPages = [];
$contactPage = null;

foreach ($sidebarPages as $item) {
    if (!$item['visible']) {
        continue;
    }

    $page = $item['page'];

    if (str_starts_with($page['page_key'], 'admission_')) {
        $admissionPages[] = $item;
    } elseif (str_starts_with($page['page_key'], 'related_')) {
        $relatedPages[] = $item;
    } elseif ($page['page_key'] === 'contact') {
        $contactPage = $item;
    }
}

/*
 * 判斷目前所在頁面
 */
$isHomePage = ($currentUri === '');
$isAnnouncementCategory = str_starts_with($currentUri, 'announcement/category');
$isNoticeSection = $isHomePage || $isAnnouncementCategory;

$isAdmissionSection = str_starts_with($currentUri, 'admission/');
$isRelatedSection   = str_starts_with($currentUri, 'related/');

// 安全存取群組設定
$admissionGroup = $sidebarGroups['admission'] ?? null;
$relatedGroup   = $sidebarGroups['related'] ?? null;
?>

<aside class="home-sidebar">

    <!-- 訊息公告 -->
    <div class="home-sidebar-group <?= $isNoticeSection ? 'open' : '' ?>">

        <div class="home-sidebar-toggle-wrapper">
            <a href="<?= base_url('/') ?>"
                class="home-sidebar-toggle-link <?= $isHomePage ? 'active' : '' ?>">
                <span class="home-sidebar-toggle-content">
                    <i class="bi bi-megaphone"></i>
                    <span>訊息公告</span>
                </span>
            </a>

            <button type="button"
                class="home-sidebar-toggle-button"
                aria-label="展開或收合訊息公告">
                <i class="bi bi-chevron-down home-sidebar-arrow"></i>
            </button>
        </div>

        <div class="home-sidebar-submenu">
            <?php
            $categories = [
                1 => '簡章訊息事項', 2 => '招生試務', 3 => '甄選資訊', 4 => '會議簡報',
                5 => '其他事項', 6 => '系統公告', 7 => '師資保送甄試', 8 => '醫事人員養成計畫'
            ];
            ?>
            <?php foreach ($categories as $id => $name): ?>
                <?php 
                    $catRoute = 'announcement/category/' . $id;
                    $isCatActive = ($currentUri === $catRoute);
                ?>
                <a href="<?= site_url($catRoute) ?>"
                    class="home-sidebar-sublink <?= $isCatActive ? 'active' : '' ?>">
                    <?= $name ?>
                </a>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- 招生資訊 -->
    <?php if ($admissionGroup && !empty($admissionGroup['visible']) && !empty($admissionPages)): ?>
        <div class="home-sidebar-group <?= $isAdmissionSection ? 'open' : '' ?>">
            <button type="button"
                class="home-sidebar-toggle <?= $isAdmissionSection ? 'active' : '' ?>"
                <?= $isAdmissionSection ? 'aria-expanded="true"' : 'aria-expanded="false"' ?>>
                <span class="home-sidebar-toggle-content">
                    <i class="bi bi-info-circle"></i>
                    <span>招生資訊</span>
                </span>
                <i class="bi bi-chevron-down home-sidebar-arrow"></i>
            </button>

            <div class="home-sidebar-submenu">
                <?php foreach ($admissionPages as $item): ?>
                    <?php
                    $page = $item['page'];
                    $route = trim($page['route'], '/');
                    $isActive = ($currentUri === $route);
                    $message = $item['message'] ?? null;
                    ?>
                    <a href="<?= base_url($route) ?>"
                        class="home-sidebar-sublink <?= $isActive ? 'active' : '' ?>">
                        <?= esc($page['title']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- 相關網站 -->
    <?php if ($relatedGroup && !empty($relatedGroup['visible']) && !empty($relatedPages)): ?>
        <div class="home-sidebar-group <?= $isRelatedSection ? 'open' : '' ?>">
            <button type="button"
                class="home-sidebar-toggle <?= $isRelatedSection ? 'active' : '' ?>"
                <?= $isRelatedSection ? 'aria-expanded="true"' : 'aria-expanded="false"' ?>>
                <span class="home-sidebar-toggle-content">
                    <i class="bi bi-link-45deg"></i>
                    <span>相關網站</span>
                </span>
                <i class="bi bi-chevron-down home-sidebar-arrow"></i>
            </button>

            <div class="home-sidebar-submenu">
                <?php foreach ($relatedPages as $item): ?>
                    <?php
                    $page = $item['page'];
                    $route = trim($page['route'], '/');
                    $isActive = ($currentUri === $route);
                    $message = $item['message'] ?? null;
                    ?>
                    <a href="<?= base_url($route) ?>"
                        class="home-sidebar-sublink <?= $isActive ? 'active' : '' ?>">
                        <?= esc($page['title']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- 聯絡資訊 -->
    <?php if ($contactPage): ?>
        <?php
        $page = $contactPage['page'];
        $route = trim($page['route'], '/');
        $isActive = ($currentUri === $route);
        ?>
        <a href="<?= base_url($route) ?>"
            class="home-sidebar-link <?= $isActive ? 'active' : '' ?>">
            <i class="bi bi-telephone"></i>
            <span><?= esc($page['title']) ?></span>
        </a>
    <?php endif; ?>

</aside>