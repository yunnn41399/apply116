function showApplicationToast(
    message,
    type = 'success'
) {
    const toast =
        document.getElementById(
            'applicationToast'
        );
    const messageElement =
        document.getElementById(
            'applicationToastMessage'
        );
    if (!toast || !messageElement) {
        return;
    }
    messageElement.textContent =
        message;
    toast.classList.remove(
        'success',
        'error',
        'show'
    );
    toast.classList.add(type);
    requestAnimationFrame(() => {
        toast.classList.add('show');
    });
    clearTimeout(
        window.applicationToastTimer
    );
    window.applicationToastTimer =
        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
}
document.addEventListener(
    'DOMContentLoaded',
    () => {
        const addForms =
            document.querySelectorAll(
                '.application-add-form'
            );
        addForms.forEach((form) => {
            form.addEventListener(
                'submit',
                async (event) => {
                    event.preventDefault();
                    const button =
                        form.querySelector(
                            '.application-add-button'
                        );
                    if (!button) {
                        return;
                    }
                    if (button.disabled) {
                        return;
                    }
                    const originalHTML =
                        button.innerHTML;
                    button.disabled = true;
                    button.innerHTML =
                        '<i class="bi bi-hourglass-split"></i> 加入中...';
                    try {
                        const response =
                            await fetch(
                                form.action,
                                {
                                    method: 'POST',
                                    body:
                                        new FormData(
                                            form
                                        ),
                                    headers: {
                                        'X-Requested-With':
                                            'XMLHttpRequest',
                                        'Accept':
                                            'application/json'
                                    }
                                }
                            );
                        const data =
                            await response.json();
                        if (
                            !response.ok
                            || !data.success
                        ) {
                            throw new Error(
                                data.message
                                || '加入校系失敗，請稍後再試。'
                            );
                        }
                        showApplicationToast(
                            data.message,
                            'success'
                        );
                        button.outerHTML = `
                            <span
                                class="application-added-button"
                            >
                                <i class="bi bi-check-circle-fill"></i>
                                已加入
                            </span>
                        `;
                    } catch (error) {
                        console.error(
                            '加入校系失敗：',
                            error
                        );
                        button.disabled =
                            false;
                        button.innerHTML =
                            originalHTML;
                        showApplicationToast(
                            error.message
                            || '加入校系失敗，請稍後再試。',
                            'error'
                        );
                    }
                }
            );
        });
        const removeForms =
            document.querySelectorAll(
                '.application-remove-form'
            );
        removeForms.forEach((form) => {
            form.addEventListener(
                'submit',
                async (event) => {
                    event.preventDefault();
                    const confirmed =
                        window.confirm(
                            '確定要從校系清單移除這個校系嗎？'
                        );
                    if (!confirmed) {
                        return;
                    }
                    const button =
                        form.querySelector(
                            '.application-remove-button'
                        );
                    if (!button) {
                        return;
                    }
                    if (button.disabled) {
                        return;
                    }
                    const mainRow =
                        form.closest(
                            '.department-main-row'
                        );
                    const detailRow =
                        mainRow
                            ?.nextElementSibling;
                    const originalHTML =
                        button.innerHTML;
                    button.disabled = true;
                    button.innerHTML =
                        '<i class="bi bi-hourglass-split"></i> 移除中...';
                    try {
                        const response =
                            await fetch(
                                form.action,
                                {
                                    method: 'POST',
                                    body:
                                        new FormData(
                                            form
                                        ),
                                    headers: {
                                        'X-Requested-With':
                                            'XMLHttpRequest',
                                        'Accept':
                                            'application/json'
                                    }
                                }
                            );
                        const data =
                            await response.json();
                        if (
                            !response.ok
                            || !data.success
                        ) {
                            throw new Error(
                                data.message
                                || '移除校系失敗，請稍後再試。'
                            );
                        }
                        showApplicationToast(
                            data.message,
                            'success'
                        );
                        if (mainRow) {
                            mainRow.remove();
                        }
                        if (detailRow) {
                            detailRow.remove();
                        }
                        const remainingRows =
                            document.querySelectorAll(
                                '.department-main-row'
                            ).length;
                        if (remainingRows === 0) {
                            window.location.reload();
                        }
                    } catch (error) {
                        console.error(
                            '移除校系失敗：',
                            error
                        );
                        button.disabled =
                            false;
                        button.innerHTML =
                            originalHTML;
                        showApplicationToast(
                            error.message
                            || '移除校系失敗，請稍後再試。',
                            'error'
                        );
                    }
                }
            );
        });
    }
);
