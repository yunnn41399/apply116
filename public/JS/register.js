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