function toggleDepartmentDetail(button) {
    const mainRow = button.closest('tr');
    if (!mainRow) {
        return;
    }
    const detailRow = mainRow.nextElementSibling;
    if (!detailRow) {
        return;
    }
    const isHidden =
        detailRow.style.display === 'none'
        || detailRow.style.display === '';
    if (isHidden) {
        detailRow.style.display = 'table-row';
        button.innerHTML =
            '<i class="bi bi-chevron-up"></i> 收起詳細';
    } else {
        detailRow.style.display = 'none';
        button.innerHTML =
            '<i class="bi bi-chevron-down"></i> 查看詳細';
    }
}