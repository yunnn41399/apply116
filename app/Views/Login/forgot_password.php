<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>忘記密碼</title>
</head>

<body>

    <h1>網路報名系統</h1>

    <h2>忘記密碼</h2>


    <!-- 顯示錯誤訊息 -->
    <?php if (session()->getFlashdata('error')): ?>

        <p style="color: red;">
            <?= esc(session()->getFlashdata('error')) ?>
        </p>

    <?php endif; ?>


    <form
        action="<?= site_url('forgot-password/verify') ?>"
        method="post"
    >

        <?= csrf_field() ?>


        <!-- 學測應試號碼 -->
        <div>

            <label for="exam_number">
                學測應試號碼：
            </label>

            <input
                type="text"
                id="exam_number"
                name="exam_number"
                value="<?= esc(
                    session()->getFlashdata('old_exam_number') ?? ''
                ) ?>"
                required
            >

        </div>


        <br>


        <!-- 身分證末四碼 -->
        <div>

            <label for="id_last_four">
                身分證號碼：
            </label>

            <input
                type="text"
                id="id_last_four"
                name="id_last_four"
                maxlength="4"
                pattern="[0-9]{4}"
                inputmode="numeric"
                required
            >

            <span>
                請輸入末四碼
            </span>

        </div>


        <br>


        <!-- 驗證碼 -->
        <div>

            <label for="captcha">
                驗證碼：
            </label>

            <input
                type="text"
                id="captcha"
                name="captcha"
                required
            >

            <span
                id="captchaText"
                style="
                    font-weight: bold;
                    font-size: 20px;
                "
            >
                <?= esc($captcha) ?>
            </span>

            <button
                type="button"
                id="refreshCaptcha"
            >
                重新產生驗證碼
            </button>

        </div>


        <br>


        <!-- 確認身分 -->
        <button type="submit">
            確認身分
        </button>

    </form>


    <br>


    <!-- 返回登入 -->
    <a href="<?= base_url('login') ?>">
        返回登入
    </a>


    <script>

        document
            .getElementById('refreshCaptcha')
            .addEventListener('click', function () {

                fetch('<?= site_url('login/refresh-captcha') ?>')
                    .then(response => response.json())
                    .then(data => {

                        if (data.success) {

                            // 更新畫面上的驗證碼
                            document
                                .getElementById('captchaText')
                                .textContent = data.captcha;


                            // 清空原本輸入的驗證碼
                            document
                                .getElementById('captcha')
                                .value = '';

                        }

                    })
                    .catch(error => {

                        console.error(
                            '驗證碼重新產生失敗：',
                            error
                        );

                    });

            });

    </script>

</body>

</html>