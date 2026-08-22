/* =========================================================
   Apply 116 - 首頁
   Sidebar 展開 / 收合
   ========================================================= */
document.addEventListener("DOMContentLoaded", function () {
    const sidebarToggles =
        document.querySelectorAll(".home-sidebar-toggle");
    sidebarToggles.forEach(function (toggle) {
        toggle.addEventListener("click", function () {
            const group =
                toggle.closest(".home-sidebar-group");
            if (!group) {
                return;
            }
            group.classList.toggle("open");
        });
    });
});