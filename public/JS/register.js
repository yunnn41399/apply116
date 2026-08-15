/* ========================================
   考生註冊系統 JavaScript
   ======================================== */

/* ========================================
   1. 重新產生驗證碼
   ======================================== */

function refreshCaptcha() {
    const canvas = document.getElementById('registerCaptcha');
    if (!canvas) return;

    // 加上時間戳記避免 GET 被快取
    const baseUrl = canvas.dataset.refreshUrl;
    const refreshUrl = baseUrl + (baseUrl.includes('?') ? '&' : '?') + '_=' + Date.now();

    fetch(refreshUrl, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            canvas.dataset.captcha = data.captcha;
            drawCaptcha(canvas.id, data.captcha); // 重繪 Canvas
            
            const input = document.getElementById('captcha');
            if (input) input.value = '';

            // 新增：更新頁面上的 CSRF Token 避免表單送出過期
            if (data.csrfHash) {
                const csrfInput = document.querySelector('input[name="' + (canvas.dataset.csrfHeader || 'csrf_test_name') + '"]');
                if (csrfInput) csrfInput.value = data.csrfHash;
            }
        }
    })
    .catch(error => console.error('請求失敗：', error));
}

/* ========================================
   2. 顯示 / 隱藏密碼
   ======================================== */

function togglePassword(
    inputId,
    button
) {

    const input =
        document.getElementById(inputId);

    const icon =
        button.querySelector('i');

    if (!input) {
        return;
    }


    /*
     * 原本是隱藏狀態
     */
    if (input.type === 'password') {

        input.type = 'text';

        if (icon) {

            icon.classList.remove(
                'bi-eye'
            );

            icon.classList.add(
                'bi-eye-slash'
            );
        }

        button.setAttribute(
            'aria-label',
            '隱藏密碼'
        );

    }

    /*
     * 原本是顯示狀態
     */
    else {

        input.type = 'password';

        if (icon) {

            icon.classList.remove(
                'bi-eye-slash'
            );

            icon.classList.add(
                'bi-eye'
            );
        }

        button.setAttribute(
            'aria-label',
            '顯示密碼'
        );
    }
}


/* ========================================
   3. 密碼規則檢查
   ======================================== */

function updatePasswordRule(
    ruleId,
    isValid
) {

    const rule =
        document.getElementById(ruleId);

    if (!rule) {
        return;
    }

    const icon =
        rule.querySelector('.rule-icon');


    if (isValid) {

        rule.classList.remove(
            'rule-invalid'
        );

        rule.classList.add(
            'rule-valid'
        );

        if (icon) {
            icon.textContent = '✓';
        }

    }

    else {

        rule.classList.remove(
            'rule-valid'
        );

        rule.classList.add(
            'rule-invalid'
        );

        if (icon) {
            icon.textContent = '✗';
        }
    }
}


/* ========================================
   4. 檢查密碼
   ======================================== */

function checkPasswordRules() {

    const passwordInput =
        document.getElementById('password');

    if (!passwordInput) {
        return;
    }


    const password =
        passwordInput.value;


    /*
     * 至少 8 個字元
     */

    updatePasswordRule(
        'rule-length',
        password.length >= 8
    );


    /*
     * 至少 1 個大寫英文字母
     */

    updatePasswordRule(
        'rule-uppercase',
        /[A-Z]/.test(password)
    );


    /*
     * 至少 1 個小寫英文字母
     */

    updatePasswordRule(
        'rule-lowercase',
        /[a-z]/.test(password)
    );


    /*
     * 至少 1 個數字
     */

    updatePasswordRule(
        'rule-number',
        /[0-9]/.test(password)
    );


    /*
     * 同時檢查兩次密碼
     */

    checkPasswordMatch();
}


/* ========================================
   5. 檢查兩次密碼是否一致
   ======================================== */

function checkPasswordMatch() {

    const passwordInput =
        document.getElementById('password');

    const confirmInput =
        document.getElementById(
            'password_confirm'
        );

    const matchMessage =
        document.getElementById(
            'password-match'
        );


    if (
        !passwordInput ||
        !confirmInput ||
        !matchMessage
    ) {
        return;
    }


    const password =
        passwordInput.value;

    const confirmPassword =
        confirmInput.value;


    /*
     * 尚未輸入確認密碼
     */

    if (confirmPassword === '') {

        matchMessage.textContent = '';

        return;
    }


    /*
     * 兩次密碼相同
     */

    if (password === confirmPassword) {

        matchMessage.textContent =
            '✓ 兩次密碼相同';

        matchMessage.style.color =
            '#16835a';

    }


    /*
     * 兩次密碼不同
     */

    else {

        matchMessage.textContent =
            '✗ 兩次密碼不一致';

        matchMessage.style.color =
            '#d64545';
    }
}


/* ========================================
   6. 繪製驗證碼
   ======================================== */

function drawCaptcha(
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


    /*
     * 清除 Canvas
     */

    ctx.clearRect(
        0,
        0,
        width,
        height
    );


    /*
     * 背景
     */

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


            /*
             * 每個字元隨機旋轉
             */

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
   7. 初始化驗證碼
   ======================================== */

function initCaptcha() {

    const canvas =
        document.getElementById(
            'registerCaptcha'
        );

    if (!canvas) {
        return;
    }


    const captcha =
        canvas.dataset.captcha;


    /*
     * 第一次載入頁面時繪製驗證碼
     */

    drawCaptcha(
        canvas.id,
        captcha
    );
}


/* ========================================
   8. 初始化
   ======================================== */

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const passwordInput =
            document.getElementById(
                'password'
            );

        const confirmInput =
            document.getElementById(
                'password_confirm'
            );


        /*
         * 密碼輸入事件
         */

        if (passwordInput) {

            passwordInput.addEventListener(
                'input',
                checkPasswordRules
            );


            /*
             * 點進密碼欄位時顯示密碼規則
             */

            passwordInput.addEventListener(
                'focus',
                function () {

                    const rules =
                        document.getElementById(
                            'password-rules'
                        );

                    if (rules) {

                        rules.classList.add(
                            'show'
                        );
                    }
                }
            );
        }


        /*
         * 確認密碼輸入事件
         */

        if (confirmInput) {

            confirmInput.addEventListener(
                'input',
                checkPasswordMatch
            );
        }


        /*
         * 初始化密碼規則
         */

        checkPasswordRules();


        /*
         * 初始化驗證碼
         */

        initCaptcha();
    }
);

document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('registerCaptcha');
    const refreshBtn = document.getElementById('btnRefreshCaptcha'); // 抓取按鈕

    // 1. 綁定 Canvas 點擊
    if (canvas) {
        canvas.style.cursor = 'pointer';
        canvas.addEventListener('click', refreshCaptcha);
    }

    // 2. 綁定按鈕點擊
    if (refreshBtn) {
        refreshBtn.addEventListener('click', function (e) {
            e.preventDefault(); // 防止按鈕觸發 Form 預設送出行為
            refreshCaptcha();
        });
    }
});