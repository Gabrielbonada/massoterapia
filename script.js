document.addEventListener('DOMContentLoaded', () => {

    const menuBtn = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');
    const closeSidebar = document.getElementById('close-sidebar');
    const overlay = document.getElementById('overlay');
    const navLinks = document.querySelectorAll('.nav-links a');

    if (menuBtn && sidebar && closeSidebar && overlay) {

        menuBtn.addEventListener('click', () => {
            sidebar.classList.add('active');
            overlay.classList.add('active');
            menuBtn.classList.add('active');
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            menuBtn.classList.remove('active');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            menuBtn.classList.remove('active');
        });

        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                menuBtn.classList.remove('active');
            });
        });
    }

    // --- Glide ---
    if (typeof Glide !== "undefined") {
        new Glide('.glide', {
            type: 'carousel',
            perView: 3,
            focusAt: 'center',
            gap: 24,
            autoplay: 3000,
            breakpoints: {
                900: { perView: 2 },
                600: { perView: 1 }
            }
        }).mount();
    }

});