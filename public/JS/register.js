function refreshCaptcha() {
    const captchaImg = document.getElementById('captcha-img');
    const captchaUrl = captchaImg.dataset.captchaUrl;

    captchaImg.src = captchaUrl + '?' + new Date().getTime();
}

function togglePassword(inputId, element) {
    const input = document.getElementById(inputId);
    const icon = element.querySelector('i');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
        element.setAttribute('aria-label', '隱藏密碼');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
        element.setAttribute('aria-label', '顯示密碼');
    }
}


const passwordInput = document.getElementById('password');
const passwordRules = document.getElementById('password-rules');

if (passwordInput && passwordRules) {

    // 點進密碼欄位時顯示規則
    passwordInput.addEventListener('focus', function () {
        passwordRules.classList.add('show');
    });

    // 輸入密碼時即時檢查
    passwordInput.addEventListener('input', function () {
        const password = this.value;

        updatePasswordRule(
            'rule-length',
            password.length >= 8
        );

        updatePasswordRule(
            'rule-uppercase',
            /[A-Z]/.test(password)
        );

        updatePasswordRule(
            'rule-lowercase',
            /[a-z]/.test(password)
        );

        updatePasswordRule(
            'rule-number',
            /[0-9]/.test(password)
        );
    });
}

function updatePasswordRule(ruleId, isValid) {
    const rule = document.getElementById(ruleId);

    if (!rule) {
        return;
    }

    const icon = rule.querySelector('.rule-icon');

    if (isValid) {
        rule.classList.remove('invalid');
        rule.classList.add('valid');
        icon.textContent = '✓';
    } else {
        rule.classList.remove('valid');
        rule.classList.add('invalid');
        icon.textContent = '✗';
    }
}