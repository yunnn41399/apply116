<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Apply 116 - 網路報名系統
    </title>
    <link rel="stylesheet" href="<?= base_url('CSS/common.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/home.css') ?>">
    <link rel="stylesheet" href="<?= base_url('CSS/system-info.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
    <?= $this->include('Layout/navbar') ?>
    <?= $this->include('Layout/sidebar') ?>
    <main class="home-main">
        <div class="home-content">
            <section class="system-info-header">
                <h2>
                    <i class="bi bi-pencil-square"></i>
                    網路報名系統
                </h2>
                <p>
                    請考生詳閱以下注意事項，確認了解後再進入網路報名系統。
                </p>
            </section>
            <section class="system-info-card">
                <div class="system-info-section">
                    <h3>
                        <span class="system-info-number">
                            1
                        </span>
                        報名資格與時間
                    </h3>
                    <p>
                        請依照當年度招生簡章所公告之報名資格及時間辦理網路報名。
                        實際報名起訖時間及相關規定，請以正式公告內容為準。
                    </p>
                </div>
                <div class="system-info-section">
                    <h3>
                        <span class="system-info-number">
                            2
                        </span>
                        報名基本資料
                    </h3>
                    <p>
                        登入後請先確認並填寫報名基本資料，包括出生年月日、
                        手機號碼、通訊地址及電子郵件等資訊。
                    </p>
                    <p>
                        請務必確認所填資料正確，以免影響後續報名及相關通知。
                    </p>
                </div>
                <div class="system-info-section">
                    <h3>
                        <span class="system-info-number">
                            3
                        </span>
                        選擇報名校系
                    </h3>
                    <p>
                        考生可以先將有興趣的校系加入「我的校系清單」，
                        再從候選校系中選擇正式報名的校系。
                    </p>
                    <div class="system-info-highlight">
                        <i class="bi bi-info-circle"></i>
                        <span>
                            正式報名時至少選擇 1 個、最多選擇 6 個校系，
                            且本系統正式報名校系不分志願序。
                        </span>
                    </div>
                </div>
                <div class="system-info-section">
                    <h3>
                        <span class="system-info-number">
                            4
                        </span>
                        正式送出報名
                    </h3>
                    <p>
                        在正式送出前，考生可以修改報名基本資料及調整候選校系。
                    </p>
                    <div class="system-info-warning">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div>
                            <strong>
                                請特別注意
                            </strong>
                            <p>
                                正式送出報名後，報名資料及正式報名校系將無法再修改、
                                新增或移除，請務必在送出前仔細核對所有資料。
                            </p>
                        </div>
                    </div>
                </div>
                <div class="system-info-section">
                    <h3>
                        <span class="system-info-number">
                            5
                        </span>
                        資料確認與權益
                    </h3>
                    <p>
                        正式送出前，系統會提供最後確認頁面供考生核對。
                        請確認學測應試號碼、身分證號碼、姓名、
                        報名資料及正式報名校系皆正確無誤。
                    </p>
                    <p>
                        若因考生提供錯誤或不完整資料而影響相關權益，
                        概由考生自行負責。
                    </p>
                </div>
                <div class="system-info-section">
                    <h3>
                        <span class="system-info-number">
                            6
                        </span>
                        系統使用提醒
                    </h3>
                    <p>
                        建議使用穩定的網路環境進行報名，並於完成正式送出後，
                        前往「報名狀態查詢」確認報名是否成功。
                    </p>
                </div>
            </section>
            <section class="system-info-actions">
                <div class="system-info-actions-text">
                    <i class="bi bi-person-check"></i>
                    <span>
                        已閱讀以上注意事項後，請先登入考生帳號。
                    </span>
                </div>
                <div class="system-info-action-buttons">
                    <a href="<?= base_url('login') ?>" class="system-info-primary-button">
                        <i class="bi bi-box-arrow-in-right"></i>
                        前往考生登入
                    </a>
                </div>
            </section>
        </div>
    </main>
</body>

</html>