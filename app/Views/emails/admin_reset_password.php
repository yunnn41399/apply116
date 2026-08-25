<!DOCTYPE html>
<html lang="zh-Hant">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Apply116後臺系統 管理員密碼重設</title>
</head>

<body style="
    margin: 0;
    padding: 0;
    background-color: #f4f6f8;
    font-family: Arial, 'Microsoft JhengHei', 'Noto Sans TC', sans-serif;
    color: #333333;
">

    <div style="
        width: 100%;
        padding: 40px 20px;
        box-sizing: border-box;
    ">

        <div style="
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        ">

            <!-- Header -->

            <div style="
                background-color: #502f8c;
                padding: 24px 30px;
                text-align: center;
            ">

                <h1 style="
                    margin: 0;
                    color: #ffffff;
                    font-size: 24px;
                    font-weight: bold;
                ">
                    Apply116
                </h1>

                <p style="
                    margin: 8px 0 0;
                    color: #eaf2f8;
                    font-size: 14px;
                ">
                    後臺管理系統
                </p>

            </div>


            <!-- Content -->

            <div style="
                padding: 35px 30px;
            ">

                <h2 style="
                    margin: 0 0 24px;
                    font-size: 22px;
                    color: #333333;
                ">
                    管理員密碼重設
                </h2>


                <p style="
                    margin: 0 0 16px;
                    line-height: 1.8;
                ">
                    您好，<?= esc($username) ?>：
                </p>


                <p style="
                    margin: 0 0 16px;
                    line-height: 1.8;
                ">
                    後臺管理系統已收到您的密碼重設申請。
                    <br>
                    如果這是您本人提出的申請，請點擊下方按鈕進行密碼重設。
                </p>


                <!-- Reset Button -->

                <div style="
                    text-align: center;
                    margin: 30px 0;
                ">

                    <a
                        href="<?= esc($resetUrl) ?>"
                        style="
                            display: inline-block;
                            padding: 13px 28px;
                            background-color: #502f8c;
                            color: #ffffff;
                            text-decoration: none;
                            border-radius: 6px;
                            font-size: 16px;
                            font-weight: bold;
                        "
                    >
                        重設管理員密碼
                    </a>

                </div>


                <!-- Expiration Notice -->

                <div style="
                    padding: 15px 18px;
                    background-color: #f8f9fa;
                    border-left: 4px solid #502f8c;
                    margin-bottom: 25px;
                ">

                    <p style="
                        margin: 0;
                        line-height: 1.7;
                        font-size: 14px;
                        color: #555555;
                    ">
                        此重設連結有效期限為
                        <strong>30 分鐘</strong>。
                        請於期限內完成密碼重設。
                    </p>

                </div>


                <!-- Security Notice -->

                <p style="
                    margin: 0 0 12px;
                    line-height: 1.8;
                    font-size: 14px;
                    color: #666666;
                ">
                    如果您沒有申請密碼重設，請忽略此信件。
                    <br>
                    您的管理員密碼不會因此變更。
                </p>


                <p style="
                    margin: 0;
                    line-height: 1.8;
                    font-size: 14px;
                    color: #666666;
                ">
                    為確保帳號安全，請勿將此信件或重設連結提供給他人。
                </p>

            </div>


            <!-- Footer -->

            <div style="
                padding: 20px 30px;
                background-color: #f8f9fa;
                border-top: 1px solid #eeeeee;
                text-align: center;
            ">

                <p style="
                    margin: 0;
                    font-size: 13px;
                    color: #888888;
                ">
                    Apply116 後臺管理系統
                </p>

                <p style="
                    margin: 6px 0 0;
                    font-size: 12px;
                    color: #aaaaaa;
                ">
                    此為系統自動寄送的通知信件，請勿直接回覆。
                </p>

            </div>

        </div>

    </div>

</body>

</html>