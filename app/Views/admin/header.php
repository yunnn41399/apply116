<nav style="
    padding: 15px;
    background-color: #f2f2f2;
    border-bottom: 1px solid #ccc;
    margin-bottom: 20px;
">

    <!-- 左側：後臺功能 -->
    <div style="display: inline-block;">

        <strong>後臺管理系統</strong>

        <a
            href="<?= site_url('admin/announcement') ?>"
            style="margin-left: 20px;"
        >
            公告管理
        </a>

        <a
            href="#"
            style="margin-left: 15px;"
        >
            考生資料
        </a>

        <a
            href="#"
            style="margin-left: 15px;"
        >
            報名資料
        </a>

        <a
            href="#"
            style="margin-left: 15px;"
        >
            首頁管理
        </a>

    </div>


    <!-- 右側：管理員資訊與登出 -->
    <div style="
        float: right;
        display: flex;
        align-items: center;
        gap: 15px;
    ">

        <span>
            您好，
            <?= esc(session()->get('admin_name') ?? session()->get('admin_username')) ?>
        </span>

        <form
            action="<?= site_url('admin/logout') ?>"
            method="post"
            style="display: inline;"
        >

            <?= csrf_field() ?>

            <button
                type="submit"
                onclick="return confirm('確定要登出管理員系統嗎？');"
            >
                登出
            </button>

        </form>

    </div>

    <div style="clear: both;"></div>

</nav>