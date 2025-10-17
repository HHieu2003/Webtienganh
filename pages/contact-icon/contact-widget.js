// Contact Widget JavaScript - PHIÊN BẢN TINH GỌN
document.addEventListener('DOMContentLoaded', function() {
    const widget = document.querySelector('.contact-support-widget');
    const toggleBtn = document.getElementById('contactToggleBtn');
    const popupMenu = document.getElementById('contactPopupMenu');

    if (!widget || !toggleBtn || !popupMenu) {
        console.error('Contact Widget elements not found.');
        return;
    }

    let isOpen = false;

    const openMenu = () => {
        if (isOpen) return;
        widget.classList.add('active');
        popupMenu.classList.add('show');
        isOpen = true;
    };

    const closeMenu = () => {
        if (!isOpen) return;
        widget.classList.remove('active');
        popupMenu.classList.remove('show');
        isOpen = false;
    };

    toggleBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        isOpen ? closeMenu() : openMenu();
    });

    // Đóng khi click ra ngoài widget
    document.addEventListener('click', (e) => {
        if (isOpen && !widget.contains(e.target)) {
            closeMenu();
        }
    });
});