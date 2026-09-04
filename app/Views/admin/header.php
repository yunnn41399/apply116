<?php $adminDisplayName = session()->get('admin_name') ?? session()->get('admin_username') ?? '管理員'; ?>

<header class="apply-header">
    <h1 class="apply-header-title">
        後臺管理系統
    </h1>

    <nav class="apply-nav">
        <a href="<?= site_url('admin') ?>" class="apply-nav-link <?= (url_is('admin') || url_is('admin/')) ? 'active' : '' ?>">
            首頁
        </a>

        <?php if (session()->get('admin_role') === 'super_admin'): ?>
            <a href="<?= site_url('admin/admins') ?>" class="apply-nav-link <?= url_is('admin/admins*') ? 'active' : '' ?>">
                管理員帳號
            </a>
        <?php endif; ?>

        <a href="<?= site_url('admin/announcement') ?>" class="apply-nav-link <?= url_is('admin/announcement*') ? 'active' : '' ?>">
            公告管理
        </a>

        <a href="<?= site_url('admin/candidates') ?>" class="apply-nav-link <?= url_is('admin/candidates*') ? 'active' : '' ?>">
            考生資料
        </a>

        <a href="<?= site_url('admin/applications') ?>" class="apply-nav-link <?= url_is('admin/applications*') ? 'active' : '' ?>">
            報名資料
        </a>

        <a href="<?= site_url('admin/homepage-pages') ?>" class="apply-nav-link <?= url_is('admin/homepage-pages*') ? 'active' : '' ?>">
            首頁管理
        </a>
    </nav>

    <div class="apply-header-right">
        <div class="apply-header-user">
            <span class="apply-header-text">
                您好，<?= esc($adminDisplayName) ?>
            </span>
        </div>

        <a href="<?= site_url('admin/profile') ?>" class="apply-logout-button <?= url_is('admin/profile*') ? 'active' : '' ?>">
            <i class="bi bi-person-circle"></i>
            我的帳號
        </a>

        <form action="<?= site_url('admin/logout') ?>" method="post" style="margin: 0;">
            <?= csrf_field() ?>
            <button 
                type="submit" 
                class="apply-logout-button"
                onclick="return confirm('確定要登出管理員系統嗎？');"
            >
                <i class="bi bi-box-arrow-right"></i>
                登出
            </button>
        </form>
    </div>
</header>