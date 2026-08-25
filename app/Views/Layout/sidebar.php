<?php
$currentUri = trim(
    uri_string(),
    '/'
);
$isHomePage = ($currentUri === '');
$isAdmissionSection =
    str_starts_with(
        $currentUri,
        'admission/'
    );
$isAdmissionSchedule =
    $currentUri === 'admission/schedule';
$isAdmissionBrochure =
    $currentUri === 'admission/brochure';
$isAdmissionRegulations =
    $currentUri === 'admission/regulations';
$isAdmissionStatistics =
    $currentUri === 'admission/statistics';
$isRelatedSection =
    str_starts_with(
        $currentUri,
        'related/'
    );
$isRelatedOrganizations =
    $currentUri === 'related/organizations';
$isRelatedExams =
    $currentUri === 'related/exams';
$isRelatedOther =
    $currentUri === 'related/other';
?>
<aside class="home-sidebar">
    <div class="home-sidebar-group <?= $isHomePage ? 'open' : '' ?>">
        <div class="home-sidebar-toggle-wrapper">
            <a href="<?= base_url('/') ?>" class="home-sidebar-toggle-link <?= $isHomePage ? 'active' : '' ?>">
                <span class="home-sidebar-toggle-content">
                    <i class="bi bi-megaphone"></i>
                    <span>
                        訊息公告
                    </span>
                </span>
            </a>
            <button type="button" class="home-sidebar-toggle-button" aria-label="展開或收合訊息公告">
                <i class="bi bi-chevron-down home-sidebar-arrow"></i>
            </button>
        </div>
        <div class="home-sidebar-submenu">
            <a href="#" class="home-sidebar-sublink">
                簡章訊息事項
            </a>
            <a href="#" class="home-sidebar-sublink">
                招生試務
            </a>
            <a href="#" class="home-sidebar-sublink">
                甄選資訊
            </a>
            <a href="#" class="home-sidebar-sublink">
                會議簡報
            </a>
            <a href="#" class="home-sidebar-sublink">
                其他事項
            </a>
            <a href="#" class="home-sidebar-sublink">
                系統公告
            </a>
            <a href="#" class="home-sidebar-sublink">
                師資保送甄試
            </a>
            <a href="#" class="home-sidebar-sublink">
                醫事人員養成計畫
            </a>
        </div>
    </div>
    <div class="home-sidebar-group <?= $isAdmissionSection ? 'open' : '' ?>">
        <button type="button" class="home-sidebar-toggle <?= $isAdmissionSection ? 'active' : '' ?>"
            <?= $isAdmissionSection ? 'aria-expanded="true"' : 'aria-expanded="false"' ?>>
            <span class="home-sidebar-toggle-content">
                <i class="bi bi-info-circle"></i>
                <span>
                    招生資訊
                </span>
            </span>
            <i class="bi bi-chevron-down home-sidebar-arrow"></i>
        </button>
        <div class="home-sidebar-submenu">
            <a href="<?= base_url('admission/schedule') ?>"
                class="home-sidebar-sublink <?= $isAdmissionSchedule ? 'active' : '' ?>">
                重要日程
            </a>
            <a href="<?= base_url('admission/brochure') ?>"
                class="home-sidebar-sublink <?= $isAdmissionBrochure ? 'active' : '' ?>">
                網路購買簡章
            </a>
            <a href="<?= base_url('admission/regulations') ?>"
                class="home-sidebar-sublink <?= $isAdmissionRegulations ? 'active' : '' ?>">
                招生相關規定
            </a>
            <a href="<?= base_url('admission/statistics') ?>"
                class="home-sidebar-sublink <?= $isAdmissionStatistics ? 'active' : '' ?>">
                招生統計資料
            </a>
        </div>
    </div>
    <div class="home-sidebar-group <?= $isRelatedSection ? 'open' : '' ?>">
        <button type="button" class="home-sidebar-toggle <?= $isRelatedSection ? 'active' : '' ?>" <?= $isRelatedSection
                  ? 'aria-expanded="true"'
                  : 'aria-expanded="false"' ?>>
            <span class="home-sidebar-toggle-content">
                <i class="bi bi-link-45deg"></i>
                <span>
                    相關網站
                </span>
            </span>
            <i class="bi bi-chevron-down home-sidebar-arrow"></i>
        </button>
        <div class="home-sidebar-submenu">
            <a href="<?= base_url('related/organizations') ?>"
                class="home-sidebar-sublink <?= $isRelatedOrganizations ? 'active' : '' ?>">
                招生單位
            </a>
            <a href="<?= base_url('related/exams') ?>"
                class="home-sidebar-sublink <?= $isRelatedExams ? 'active' : '' ?>">
                考試單位
            </a>
            <a href="<?= base_url('related/other') ?>"
                class="home-sidebar-sublink <?= $isRelatedOther ? 'active' : '' ?>">
                其他網站
            </a>
        </div>
    </div>
    <a href="<?= base_url('contact') ?>" class="home-sidebar-link <?= $currentUri === 'contact' ? 'active' : '' ?>">
        <i class="bi bi-telephone"></i>
        <span>
            聯絡資訊
        </span>
    </a>
</aside>