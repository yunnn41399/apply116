<h1>網路報名首頁</h1>

<p>
    歡迎您，
    <?= esc(session()->get('exam_number')) ?>
    號考生
</p>

<a href="<?= site_url('logout') ?>">登出</a>