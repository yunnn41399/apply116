/* ========================================
   繪製驗證碼
   ======================================== */

function drawAdminForgotCaptcha(
    canvasId,
    captcha
) {
    const canvas =
        document.getElementById(canvasId);

    if (!canvas || !captcha) {
        return;
    }

    const ctx =
        canvas.getContext('2d');

    const width =
        canvas.width;

    const height =
        canvas.height;


    /* 清除 Canvas */

    ctx.clearRect(
        0,
        0,
        width,
        height
    );


    /* ========================================
       背景
       ======================================== */

    ctx.fillStyle =
        '#f2f2f2';

    ctx.fillRect(
        0,
        0,
        width,
        height
    );


    /* ========================================
       背景干擾
       ======================================== */

    for (let i = 0; i < 12; i++) {

        const red =
            Math.floor(
                Math.random() * 180
            ) + 50;

        const green =
            Math.floor(
                Math.random() * 180
            ) + 50;

        const blue =
            Math.floor(
                Math.random() * 180
            ) + 50;

        ctx.fillStyle =
            `rgba(${red}, ${green}, ${blue}, 0.18)`;

        const x =
            Math.random() * width;

        const y =
            Math.random() * height;

        const size =
            Math.random() * 35 + 15;

        ctx.beginPath();

        ctx.arc(
            x,
            y,
            size,
            0,
            Math.PI * 2
        );

        ctx.fill();
    }


    /* ========================================
       干擾線
       ======================================== */

    for (let i = 0; i < 6; i++) {

        const red =
            Math.floor(
                Math.random() * 180
            );

        const green =
            Math.floor(
                Math.random() * 180
            );

        const blue =
            Math.floor(
                Math.random() * 180
            );

        ctx.strokeStyle =
            `rgba(${red}, ${green}, ${blue}, 0.7)`;

        ctx.lineWidth = 1;

        ctx.beginPath();

        ctx.moveTo(
            Math.random() * width,
            Math.random() * height
        );

        ctx.lineTo(
            Math.random() * width,
            Math.random() * height
        );

        ctx.stroke();
    }


    /* ========================================
       干擾雜點
       ======================================== */

    for (let i = 0; i < 50; i++) {

        const red =
            Math.floor(
                Math.random() * 200
            );

        const green =
            Math.floor(
                Math.random() * 200
            );

        const blue =
            Math.floor(
                Math.random() * 200
            );

        ctx.fillStyle =
            `rgb(${red}, ${green}, ${blue})`;

        const x =
            Math.random() * width;

        const y =
            Math.random() * height;

        const radius =
            Math.random() * 2 + 1;

        ctx.beginPath();

        ctx.arc(
            x,
            y,
            radius,
            0,
            Math.PI * 2
        );

        ctx.fill();
    }


    /* ========================================
       驗證碼文字
       ======================================== */

    const characters =
        captcha.split('');

    const charWidth =
        width / characters.length;


    characters.forEach(
        function (char, index) {

            const red =
                Math.floor(
                    Math.random() * 150
                );

            const green =
                Math.floor(
                    Math.random() * 150
                );

            const blue =
                Math.floor(
                    Math.random() * 150
                );

            ctx.fillStyle =
                `rgb(${red}, ${green}, ${blue})`;

            const fontSize =
                Math.floor(
                    Math.random() * 8
                ) + 24;

            ctx.font =
                `bold ${fontSize}px Arial`;

            const x =
                index * charWidth + 10;

            const y =
                height / 2 +
                fontSize / 3;

            const angle =
                (
                    Math.random() * 30 - 15
                ) * Math.PI / 180;

            ctx.save();

            ctx.translate(
                x + charWidth / 2,
                height / 2
            );

            ctx.rotate(angle);

            ctx.fillText(
                char,
                -charWidth / 2,
                fontSize / 3
            );

            ctx.restore();
        }
    );
}


/* ========================================
   重新產生驗證碼
   ======================================== */

function refreshAdminForgotCaptcha() {

    const canvas =
        document.getElementById(
            'adminForgotCaptcha'
        );

    if (!canvas) {
        return;
    }

    const baseUrl =
        canvas.dataset.refreshUrl;

    const refreshUrl =
        baseUrl +
        (baseUrl.includes('?') ? '&' : '?') +
        '_=' +
        Date.now();


    fetch(refreshUrl, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {

        if (data.success) {

            // 更新 Canvas 上的 CAPTCHA
            canvas.dataset.captcha =
                data.captcha;

            drawAdminForgotCaptcha(
                canvas.id,
                data.captcha
            );


            // 清空 CAPTCHA 輸入欄
            const input =
                document.getElementById(
                    'captcha'
                );

            if (input) {
                input.value = '';
            }
        }

    })
    .catch(error => {
        console.error(
            '重新產生驗證碼失敗：',
            error
        );
    });
}


/* ========================================
   初始化
   ======================================== */

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const canvas =
            document.getElementById(
                'adminForgotCaptcha'
            );

        const refreshButton =
            document.getElementById(
                'btnRefreshAdminForgotCaptcha'
            );


        /* 初始化 CAPTCHA */

        if (canvas) {

            const captcha =
                canvas.dataset.captcha;

            drawAdminForgotCaptcha(
                canvas.id,
                captcha
            );


            /*
             * 點擊 CAPTCHA 圖片
             * 重新產生
             */

            canvas.style.cursor =
                'pointer';

            canvas.addEventListener(
                'click',
                refreshAdminForgotCaptcha
            );
        }


        /* 重新產生按鈕 */

        if (refreshButton) {

            refreshButton.addEventListener(
                'click',
                function () {

                    refreshAdminForgotCaptcha();

                }
            );
        }
    }
);