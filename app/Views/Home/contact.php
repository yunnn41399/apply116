<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Apply 116 - 聯絡資訊
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
                    <i class="bi bi-telephone"></i>
                    聯絡資訊
                </h2>
                <p>
                    如有報名及招生相關問題，請於服務時間內與我們聯繫。
                </p>
            </section>
            <section class="contact-card">
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div class="contact-content">
                        <h3>
                            聯絡地址
                        </h3>
                        <p>
                            621301 嘉義縣民雄鄉大學路一段168號
                        </p>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <div class="contact-content">
                        <h3>
                            聯絡電話
                        </h3>
                        <p class="contact-phone">
                            (05) 272-1799
                        </p>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="bi bi-clock-fill"></i>
                    </div>
                    <div class="contact-content">
                        <h3>
                            服務時間
                        </h3>
                        <p>
                            平日（週一至週五）
                        </p>
                        <p>
                            上午 8:00～12:00
                        </p>
                        <p>
                            下午 13:00～17:00
                        </p>
                        <p class="contact-note">
                            例假日及國定假日暫停服務。
                        </p>
                    </div>
                </div>
            </section>
            <div class="system-info-highlight">
                <i class="bi bi-info-circle"></i>
                <span>
                    建議考生於服務時間內聯繫，以便取得即時協助。
                </span>
            </div>
        </div>
    </main>
    <script src="<?= base_url('JS/sidebar.js') ?>"></script>
</body>

</html>