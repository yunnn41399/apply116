/* =========================================================
   Apply 116 - 首頁
   Sidebar 展開 / 收合
   ========================================================= */
document.addEventListener("DOMContentLoaded", function () {
    const arrowButtons =
        document.querySelectorAll(
            ".home-sidebar-toggle-button"
        );
    arrowButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            const group =
                button.closest(".home-sidebar-group");
            if (!group) {
                return;
            }
            group.classList.toggle("open");
        });
    });
    const toggleButtons =
        document.querySelectorAll(
            ".home-sidebar-toggle"
        );
    toggleButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            const group =
                button.closest(".home-sidebar-group");
            if (!group) {
                return;
            }
            group.classList.toggle("open");
        });
    });
});