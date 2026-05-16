document.addEventListener('DOMContentLoaded', function () {
    // Auto-dismiss alerts after 5 seconds
    document.querySelectorAll('.alert').forEach(function (alert) {
        setTimeout(function () {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(function () { alert.remove(); }, 500);
        }, 5000);
    });

    // Highlight active nav link
    const currentPage = window.location.pathname.split('/').pop();
    document.querySelectorAll('.navigation a').forEach(function (link) {
        if (link.getAttribute('href') === currentPage) {
            link.style.background = 'rgba(255,255,255,0.18)';
            link.style.color = '#fff';
        }
    });
});