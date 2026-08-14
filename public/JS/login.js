function togglePassword(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('i');
    if (!input) {
        return;
    }
    if (input.type === 'password') {
        input.type = 'text';
        if (icon) {
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
        button.setAttribute(
            'aria-label',
            '隱藏內容'
        );
    } else {
        input.type = 'password';
        if (icon) {
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
        button.setAttribute(
            'aria-label',
            '顯示內容'
        );
    }
}
function updatePasswordRule(element, valid) {
    if (!element) {
        return;
    }
    const icon = element.querySelector('.rule-icon');
    if (valid) {
        element.classList.remove('rule-invalid');
        element.classList.add('rule-valid');
        if (icon) {
            icon.textContent = '✓';
        }
    } else {
        element.classList.remove('rule-valid');
        element.classList.add('rule-invalid');
        if (icon) {
            icon.textContent = '✗';
        }
    }
}
function checkPasswordRules() {
    const passwordInput =
        document.getElementById('password');
    if (!passwordInput) {
        return;
    }
    const password =
        passwordInput.value;
    updatePasswordRule(
        document.getElementById('rule-length'),
        password.length >= 8
    );
    updatePasswordRule(
        document.getElementById('rule-uppercase'),
        /[A-Z]/.test(password)
    );
    updatePasswordRule(
        document.getElementById('rule-lowercase'),
        /[a-z]/.test(password)
    );
    updatePasswordRule(
        document.getElementById('rule-number'),
        /[0-9]/.test(password)
    );
    checkPasswordMatch();
}
function checkPasswordMatch() {
    const passwordInput =
        document.getElementById('password');
    const confirmInput =
        document.getElementById('password_confirm');
    const matchMessage =
        document.getElementById('password-match');
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
    if (confirmPassword === '') {
        matchMessage.textContent = '';
        return;
    }
    if (password === confirmPassword) {
        matchMessage.textContent =
            '✓ 兩次密碼相同';
        matchMessage.style.color =
            'green';
    } else {
        matchMessage.textContent =
            '✗ 兩次密碼不一致';
        matchMessage.style.color =
            'red';
    }
}
function initPasswordValidation() {
    const passwordInput =
        document.getElementById('password');
    const confirmInput =
        document.getElementById('password_confirm');
    if (!passwordInput) {
        return;
    }
    passwordInput.addEventListener(
        'input',
        checkPasswordRules
    );
    if (confirmInput) {
        confirmInput.addEventListener(
            'input',
            checkPasswordMatch
        );
    }
    checkPasswordRules();
}
function drawCaptcha(canvasId, captcha) {
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
    ctx.clearRect(
        0,
        0,
        width,
        height
    );
    ctx.fillStyle =
        '#f2f2f2';
    ctx.fillRect(
        0,
        0,
        width,
        height
    );
    for (let i = 0; i < 12; i++) {
        const red =
            Math.floor(Math.random() * 180) + 50;
        const green =
            Math.floor(Math.random() * 180) + 50;
        const blue =
            Math.floor(Math.random() * 180) + 50;
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
    for (let i = 0; i < 6; i++) {
        const red =
            Math.floor(Math.random() * 180);
        const green =
            Math.floor(Math.random() * 180);
        const blue =
            Math.floor(Math.random() * 180);
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
    for (let i = 0; i < 50; i++) {
        const red =
            Math.floor(Math.random() * 200);
        const green =
            Math.floor(Math.random() * 200);
        const blue =
            Math.floor(Math.random() * 200);
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
    const characters =
        captcha.split('');
    const charWidth =
        width / characters.length;
    characters.forEach(function (char, index) {
        const red =
            Math.floor(Math.random() * 150);
        const green =
            Math.floor(Math.random() * 150);
        const blue =
            Math.floor(Math.random() * 150);
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
            height / 2 + fontSize / 3;
        const angle =
            (Math.random() * 30 - 15)
            * Math.PI / 180;
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
    });
}
function refreshCaptcha(canvasId, url, inputId) {
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                drawCaptcha(
                    canvasId,
                    data.captcha
                );
                const input =
                    document.getElementById(inputId);
                if (input) {
                    input.value = '';
                }
            }
        })
        .catch(error => {
            console.error(
                '驗證碼重新產生失敗：',
                error
            );
        });
}
function initCaptcha() {
    const canvas =
        document.querySelector('.captcha-canvas');
    if (!canvas) {
        return;
    }
    const captcha =
        canvas.dataset.captcha;
    const refreshUrl =
        canvas.dataset.refreshUrl;
    const inputId =
        canvas.dataset.inputId;
    drawCaptcha(
        canvas.id,
        captcha
    );
    const refreshButton =
        document.getElementById('refreshCaptcha');
    if (refreshButton) {
        refreshButton.addEventListener(
            'click',
            function () {
                refreshCaptcha(
                    canvas.id,
                    refreshUrl,
                    inputId
                );
            }
        );
    }
}
document.addEventListener(
    'DOMContentLoaded',
    function () {
        initPasswordValidation();
        initCaptcha();
    }
);