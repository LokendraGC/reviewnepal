document.addEventListener('DOMContentLoaded', () => {

    // --- 1. NOTIFICATIONS LOGIC ---
    const notifWrappers = document.querySelectorAll('.notification-wrapper');
    if (notifWrappers.length > 0) {
        notifWrappers.forEach(wrapper => {
            const btn = wrapper.querySelector('.notification-btn');
            const dropdown = wrapper.querySelector('.notification-dropdown');

            if (btn && dropdown) {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    document.querySelectorAll('.notification-dropdown').forEach(d => {
                        if (d !== dropdown) d.classList.remove('active');
                    });
                    dropdown.classList.toggle('active');
                });

                dropdown.addEventListener('click', (e) => {
                    e.stopPropagation();
                });
            }
        });

        document.addEventListener('click', () => {
            document.querySelectorAll('.notification-dropdown').forEach(dropdown => {
                dropdown.classList.remove('active');
            });
        });
    }

    // --- 2. SEARCH OVERLAY LOGIC ---
    const searchTriggers = document.querySelectorAll('.search-trigger-btn');
    const searchOverlay = document.getElementById('search-overlay');
    const closeSearch = document.getElementById('close-search-btn');
    const searchInput = document.getElementById('search-input-main');

    if (searchOverlay) {
        searchTriggers.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                searchOverlay.classList.add('open');
                document.body.style.overflow = 'hidden';
                if (searchInput) setTimeout(() => searchInput.focus(), 400);
            });
        });

        const hideSearch = () => {
            searchOverlay.classList.remove('open');
            document.body.style.overflow = '';
        };

        if (closeSearch) closeSearch.addEventListener('click', hideSearch);

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && searchOverlay.classList.contains('open')) {
                hideSearch();
            }
        });
    }

    // --- 3. MOBILE NAV OVERLAY ---
    const openButtons = document.querySelectorAll('.open-menu-btn');
    const closeBtn = document.getElementById('close-menu-btn');
    const navOverlay = document.getElementById('nav-overlay');

    if (navOverlay) {
        openButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                navOverlay.classList.add('open');
                document.body.style.overflow = 'hidden';
            });
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                navOverlay.classList.remove('open');
                document.body.style.overflow = '';
            });
        }
    }

    // --- 4. TABS LOGIC ---
    const tabs = document.querySelectorAll('.tab-trigger');
    if (tabs.length > 0) {
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                if (window.innerWidth < 992) {
                    const targetId = tab.getAttribute('data-tab');
                    const targetPane = document.getElementById(targetId);

                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');

                    // Select panes - using a class is safer than hardcoding IDs
                    const panes = [
                        document.getElementById('mobile-categories'),
                        document.getElementById('mobile-general')
                    ];
                    
                    panes.forEach(p => {
                        if (p) p.classList.remove('active');
                    });

                    if (targetPane) targetPane.classList.add('active');
                }
            });
        });
    }

    // --- 5. MOBILE DROPDOWNS ---
    const dropdownToggles = document.querySelectorAll('.mobile-dropdown-toggle');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', () => {
            const parent = toggle.closest('.mobile-dropdown');
            if (parent) parent.classList.toggle('active');
        });
    });

    // --- 6. STICKY HEADER FIXED ---
    const stickyBar = document.getElementById('sticky-header-fixed');
    if (stickyBar) {
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 400) {
                stickyBar.classList.add("show-sticky");
            } else {
                stickyBar.classList.remove("show-sticky");
            }
        });
    }

    // --- 7. STICKY SIDEBAR LOGIC ---
    const sidebar = document.getElementById('sticky-sidebar');
    const sidebarCol = document.getElementById('sidebar-col');
    const contentCol = document.getElementById('content-col');
    
    if (sidebar && sidebarCol && contentCol) {
        const updateSidebar = () => {
            if (window.innerWidth >= 992) {
                const contentHeight = contentCol.offsetHeight;
                const sidebarHeight = sidebar.offsetHeight;
                const contentTop = contentCol.getBoundingClientRect().top + window.scrollY;
                const scrollY = window.scrollY;
                const offsetTop = 20;

                sidebar.style.width = (sidebarCol.offsetWidth - 24) + "px";

                if (scrollY > contentTop - offsetTop) {
                    if (scrollY + sidebarHeight + offsetTop > contentTop + contentHeight) {
                        sidebar.classList.remove('is-sticky');
                        sidebar.classList.add('is-bottom');
                    } else {
                        sidebar.classList.add('is-sticky');
                        sidebar.classList.remove('is-bottom');
                    }
                } else {
                    sidebar.classList.remove('is-sticky');
                    sidebar.classList.remove('is-bottom');
                }
            } else {
                sidebar.classList.remove('is-sticky');
                sidebar.classList.remove('is-bottom');
                sidebar.style.width = "100%";
            }
        };

        window.addEventListener('scroll', updateSidebar);
        window.addEventListener('resize', updateSidebar);
        updateSidebar(); // Run once on load
    }
});

