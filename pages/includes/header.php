<?php
// Cek halaman aktif untuk menentukan class active
$current_page = basename($_SERVER['PHP_SELF']);
$current_uri = $_SERVER['REQUEST_URI'];
?>

<!-- MHT Header - Custom dengan prefix mht- untuk menghindari konflik -->
<header id="mht-header" class="mht-header" role="banner">
    <div class="mht-header-container">
        <div class="mht-header-navbar">

            <!-- Logo -->
            <div class="mht-header-logo">
                <h1 class="mht-header-logo-text">
                    <a href="/" class="mht-header-logo-link" aria-label="Beranda MicroHelix Tech Solutions">
                        MicroHelix Tech Solutions
                    </a>
                </h1>
            </div>

            <!-- Burger Menu Mobile & Close Button -->
            <button class="mht-header-burger" id="mht-header-burger" aria-label="Buka navigasi" aria-expanded="false">
                <span class="mht-header-burger-icon">
                    <span class="mht-header-burger-bar"></span>
                    <span class="mht-header-burger-bar"></span>
                    <span class="mht-header-burger-bar"></span>
                </span>
                <span class="mht-header-close-icon">
                    <span class="mht-header-close-bar"></span>
                    <span class="mht-header-close-bar"></span>
                </span>
            </button>

            <!-- Navigation -->
            <nav id="mht-header-nav" class="mht-header-nav" role="navigation" aria-label="Navigasi Utama">
                <ul class="mht-header-menu">
                    <li class="mht-header-menu-item">
                        <a href="/" class="mht-header-link <?= $current_page === 'index.php' ? 'mht-header-active' : '' ?>">
                            <span class="mht-header-link-text">Beranda</span>
                        </a>
                    </li>

                    <!-- Tentang Dropdown -->
                    <li class="mht-header-menu-item mht-header-dropdown" id="mht-header-dropdown-tentang">
                        <a href="/tentang-kami" class="mht-header-link <?= strpos($current_uri, '/tentang') !== false ? 'mht-header-active' : '' ?>" aria-haspopup="true" aria-expanded="false">
                            <span class="mht-header-link-text">Tentang</span>
                            <i class="mht-header-dropdown-icon fa-solid fa-chevron-down"></i>
                        </a>
                        <ul class="mht-header-dropdown-menu" aria-label="Submenu Tentang">
                            <li class="mht-header-dropdown-item">
                                <a href="/testimoni" class="mht-header-dropdown-link">
                                    <i class="fa-regular fa-star"></i>
                                    Testimoni
                                </a>
                            </li>
                            <li class="mht-header-dropdown-item">
                                <a href="/frequently-asked-question" class="mht-header-dropdown-link">
                                    <i class="fa-regular fa-circle-question"></i>
                                    FAQ
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Layanan Dropdown -->
                    <li class="mht-header-menu-item mht-header-dropdown" id="mht-header-dropdown-layanan">
                        <a href="/proyek-kami" class="mht-header-link <?= (strpos($current_uri, '/proyek-kami') !== false || strpos($current_uri, '/paket-kami') !== false) ? 'mht-header-active' : '' ?>" aria-haspopup="true" aria-expanded="false">
                            <span class="mht-header-link-text">Layanan</span>
                            <i class="mht-header-dropdown-icon fa-solid fa-chevron-down"></i>
                        </a>
                        <ul class="mht-header-dropdown-menu" aria-label="Submenu Layanan">
                            <li class="mht-header-dropdown-item">
                                <a href="/proyek-kami" class="mht-header-dropdown-link">
                                    <i class="fa-regular fa-folder-open"></i>
                                    Proyek Kami
                                </a>
                            </li>
                            <li class="mht-header-dropdown-item">
                                <a href="/paket-kami" class="mht-header-dropdown-link">
                                    <i class="fa-regular fa-file-lines"></i>
                                    Paket Website
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- CTA Button -->
                    <li class="mht-header-menu-item mht-header-cta-item">
                        <a href="/jadwal-temu" class="mht-header-cta-button <?= strpos($current_uri, '/jadwal-temu') !== false ? 'mht-header-active' : '' ?>">
                            <i class="fa-regular fa-calendar-check"></i>
                            <span class="mht-header-cta-text">Jadwalkan Temu</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<!-- Mobile Menu Overlay -->
<div class="mht-header-overlay" id="mht-header-overlay"></div>

<style>
/* ===== MHT HEADER - CUSTOM STYLES WITH PREFIX ===== */
/* Semua class menggunakan prefix mht-header untuk menghindari konflik */

/* Import Font */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

/* CSS Variables khusus untuk header */
:root {
    --mht-header-primary: #9C27B0;
    --mht-header-primary-dark: #7B1FA2;
    --mht-header-bg-start: #1E1E1E;
    --mht-header-bg-end: #9C27B0;
    --mht-header-text: #FFFFFF;
    --mht-header-text-light: #F0F0F0;
    --mht-header-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    --mht-header-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Reset untuk elemen header saja */
.mht-header *,
.mht-header *::before,
.mht-header *::after {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Header Utama */
.mht-header {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, var(--mht-header-bg-start) 0%, var(--mht-header-bg-end) 100%);
    color: var(--mht-header-text);
    padding: 12px 0;
    position: sticky;
    top: 0;
    z-index: 9999;
    box-shadow: var(--mht-header-shadow);
    transition: var(--mht-header-transition);
    width: 100%;
    left: 0;
    right: 0;
}

/* Container */
.mht-header-container {
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Navbar Layout */
.mht-header-navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    min-height: 60px;
}

/* Logo */
.mht-header-logo {
    flex-shrink: 0;
    z-index: 10001;
}

.mht-header-logo-text {
    line-height: 1;
    margin: 0;
    font-size: 1.5rem;
}

.mht-header-logo-link {
    color: var(--mht-header-text);
    text-decoration: none;
    font-weight: 700;
    font-size: 1.5rem;
    letter-spacing: -0.5px;
    background: linear-gradient(to right, #FFFFFF, #E0E0E0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    transition: var(--mht-header-transition);
    white-space: nowrap;
}

.mht-header-logo-link:hover {
    background: linear-gradient(to right, var(--mht-header-primary), #FFFFFF);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Navigation */
.mht-header-nav {
    display: flex;
    align-items: center;
}

.mht-header-menu {
    display: flex;
    align-items: center;
    gap: 8px;
    list-style: none;
    margin: 0;
    padding: 0;
}

.mht-header-menu-item {
    position: relative;
    list-style: none;
}

.mht-header-link {
    color: var(--mht-header-text);
    text-decoration: none;
    font-weight: 500;
    font-size: 1rem;
    padding: 10px 16px;
    border-radius: 8px;
    transition: var(--mht-header-transition);
    display: flex;
    align-items: center;
    gap: 8px;
    position: relative;
    white-space: nowrap;
}

.mht-header-link:hover {
    background: rgba(255, 255, 255, 0.1);
}

.mht-header-link.mht-header-active {
    background: var(--mht-header-primary);
    box-shadow: 0 4px 10px rgba(156, 39, 176, 0.3);
}

.mht-header-link-text {
    position: relative;
    z-index: 1;
}

/* Dropdown */
.mht-header-dropdown {
    position: relative;
}

.mht-header-dropdown-icon {
    font-size: 0.8rem;
    transition: transform 0.3s ease;
}

.mht-header-dropdown:hover .mht-header-dropdown-icon {
    transform: rotate(180deg);
}

.mht-header-dropdown-menu {
    position: absolute;
    top: calc(100% + 10px);
    left: 0;
    background: #FFFFFF;
    min-width: 220px;
    padding: 8px 0;
    border-radius: 12px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: var(--mht-header-transition);
    z-index: 10000;
    list-style: none;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.mht-header-dropdown:hover .mht-header-dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.mht-header-dropdown-item {
    list-style: none;
    margin: 0;
    padding: 0;
}

.mht-header-dropdown-link {
    color: #333333;
    text-decoration: none;
    padding: 12px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: var(--mht-header-transition);
    font-size: 0.95rem;
    font-weight: 500;
    width: 100%;
}

.mht-header-dropdown-link i {
    color: var(--mht-header-primary);
    font-size: 1rem;
    width: 20px;
    text-align: center;
}

.mht-header-dropdown-link:hover {
    background: rgba(156, 39, 176, 0.05);
    color: var(--mht-header-primary);
    padding-left: 28px;
}

/* CTA Button */
.mht-header-cta-item {
    margin-left: 10px;
}

.mht-header-cta-button {
    background: var(--mht-header-primary);
    color: var(--mht-header-text) !important;
    padding: 10px 22px !important;
    border-radius: 50px !important;
    font-weight: 600 !important;
    display: flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    transition: var(--mht-header-transition);
    position: relative;
    overflow: hidden;
    border: none;
    box-shadow: 0 5px 15px rgba(156, 39, 176, 0.3);
}

.mht-header-cta-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s ease;
}

.mht-header-cta-button:hover {
    background: var(--mht-header-primary-dark) !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(123, 31, 162, 0.4);
}

.mht-header-cta-button:hover::before {
    left: 100%;
}

.mht-header-cta-button.mht-header-active {
    background: var(--mht-header-primary-dark);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.mht-header-cta-text {
    position: relative;
    z-index: 1;
}

/* Burger & Close Icons */
.mht-header-burger {
    display: none;
    width: 40px;
    height: 40px;
    background: transparent;
    border: none;
    cursor: pointer;
    z-index: 10001;
    padding: 0;
    position: relative;
    border-radius: 8px;
    transition: var(--mht-header-transition);
}

.mht-header-burger:focus {
    outline: none;
}

.mht-header-burger:hover {
    background: rgba(255, 255, 255, 0.1);
}

.mht-header-burger-icon,
.mht-header-close-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 24px;
    height: 24px;
    transition: var(--mht-header-transition);
}

.mht-header-close-icon {
    opacity: 0;
    transform: translate(-50%, -50%) rotate(90deg);
}

.mht-header-burger-bar {
    display: block;
    width: 24px;
    height: 3px;
    background: var(--mht-header-text);
    border-radius: 3px;
    transition: var(--mht-header-transition);
    position: absolute;
    left: 0;
}

.mht-header-burger-bar:nth-child(1) {
    top: 4px;
}

.mht-header-burger-bar:nth-child(2) {
    top: 11px;
}

.mht-header-burger-bar:nth-child(3) {
    top: 18px;
}

.mht-header-close-bar {
    display: block;
    width: 24px;
    height: 3px;
    background: var(--mht-header-text);
    border-radius: 3px;
    transition: var(--mht-header-transition);
    position: absolute;
    left: 0;
    top: 11px;
}

.mht-header-close-bar:nth-child(1) {
    transform: rotate(45deg);
}

.mht-header-close-bar:nth-child(2) {
    transform: rotate(-45deg);
}

/* Active state for burger/close */
.mht-header-burger.active .mht-header-burger-icon {
    opacity: 0;
    transform: translate(-50%, -50%) rotate(-90deg);
}

.mht-header-burger.active .mht-header-close-icon {
    opacity: 1;
    transform: translate(-50%, -50%) rotate(0deg);
}

/* Overlay */
.mht-header-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    z-index: 9998;
    opacity: 0;
    visibility: hidden;
    transition: var(--mht-header-transition);
}

.mht-header-overlay.active {
    opacity: 1;
    visibility: visible;
}

/* ===== RESPONSIVE STYLES ===== */
@media (max-width: 992px) {
    .mht-header-link {
        padding: 8px 12px;
        font-size: 0.95rem;
    }
    
    .mht-header-cta-button {
        padding: 8px 18px !important;
        font-size: 0.95rem;
    }
    
    .mht-header-logo-link {
        font-size: 1.3rem;
    }
}

@media (max-width: 768px) {
    .mht-header-burger {
        display: block;
    }
    
    .mht-header-nav {
        position: fixed;
        top: 0;
        right: -100%;
        width: 85%;
        max-width: 400px;
        height: 100vh;
        background: linear-gradient(135deg, #1E1E1E 0%, #9C27B0 100%);
        flex-direction: column;
        padding: 90px 20px 30px;
        transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 10000;
        overflow-y: auto;
        box-shadow: -5px 0 20px rgba(0, 0, 0, 0.2);
    }
    
    .mht-header-nav.active {
        right: 0;
    }
    
    .mht-header-menu {
        flex-direction: column;
        width: 100%;
        gap: 8px;
    }
    
    .mht-header-menu-item {
        width: 100%;
    }
    
    .mht-header-link {
        width: 100%;
        padding: 14px 16px;
        font-size: 1rem;
        justify-content: space-between;
    }
    
    .mht-header-dropdown-menu {
        position: static;
        opacity: 1;
        visibility: visible;
        transform: none;
        max-height: 0;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.1);
        box-shadow: none;
        margin: 0;
        padding: 0;
        transition: max-height 0.4s ease;
        border: none;
        width: 100%;
        border-radius: 8px;
    }
    
    .mht-header-dropdown-menu::before {
        display: none;
    }
    
    .mht-header-dropdown.active .mht-header-dropdown-menu {
        max-height: 300px;
        padding: 8px 0;
    }
    
    .mht-header-dropdown-link {
        color: var(--mht-header-text);
        padding: 12px 30px;
    }
    
    .mht-header-dropdown-link i {
        color: var(--mht-header-text);
    }
    
    .mht-header-dropdown-link:hover {
        background: rgba(255, 255, 255, 0.15);
        color: #FFFFFF;
    }
    
    .mht-header-cta-item {
        margin-left: 0;
        margin-top: 15px;
        width: 100%;
    }
    
    .mht-header-cta-button {
        width: 100%;
        justify-content: center;
        padding: 14px !important;
    }
    
    /* Animation for mobile menu items */
    @keyframes mhtHeaderSlideIn {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    .mht-header-nav.active .mht-header-menu-item {
        animation: mhtHeaderSlideIn 0.3s ease forwards;
        opacity: 0;
    }
    
    .mht-header-nav.active .mht-header-menu-item:nth-child(1) { animation-delay: 0.1s; }
    .mht-header-nav.active .mht-header-menu-item:nth-child(2) { animation-delay: 0.15s; }
    .mht-header-nav.active .mht-header-menu-item:nth-child(3) { animation-delay: 0.2s; }
    .mht-header-nav.active .mht-header-menu-item:nth-child(4) { animation-delay: 0.25s; }
}

@media (max-width: 480px) {
    .mht-header-logo-link {
        font-size: 1.1rem;
    }
    
    .mht-header-container {
        padding: 0 15px;
    }
    
    .mht-header-nav {
        width: 100%;
        max-width: none;
    }
}

/* Utility classes */
.mht-header-hidden {
    display: none !important;
}

.mht-header-no-scroll {
    overflow: hidden;
}
</style>

<script>
// MHT Header JavaScript - Custom dengan prefix mht-header
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const headerBurger = document.getElementById('mht-header-burger');
    const headerNav = document.getElementById('mht-header-nav');
    const headerOverlay = document.getElementById('mht-header-overlay');
    const headerDropdowns = document.querySelectorAll('.mht-header-dropdown');
    const headerLinks = document.querySelectorAll('.mht-header-link');
    
    // Toggle Mobile Menu
    if (headerBurger && headerNav && headerOverlay) {
        function toggleMobileMenu(force) {
            const isActive = headerBurger.classList.contains('active');
            
            if (force === false || (force === undefined && isActive)) {
                // Close menu
                headerBurger.classList.remove('active');
                headerNav.classList.remove('active');
                headerOverlay.classList.remove('active');
                document.body.classList.remove('mht-header-no-scroll');
                headerBurger.setAttribute('aria-expanded', 'false');
                
                // Close all dropdowns
                document.querySelectorAll('.mht-header-dropdown.active').forEach(drop => {
                    drop.classList.remove('active');
                });
            } else {
                // Open menu
                headerBurger.classList.add('active');
                headerNav.classList.add('active');
                headerOverlay.classList.add('active');
                document.body.classList.add('mht-header-no-scroll');
                headerBurger.setAttribute('aria-expanded', 'true');
            }
        }
        
        headerBurger.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleMobileMenu();
        });
        
        headerOverlay.addEventListener('click', function() {
            toggleMobileMenu(false);
        });
        
        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && headerNav.classList.contains('active')) {
                toggleMobileMenu(false);
            }
        });
    }
    
    // Handle dropdowns on mobile with resize observer
    function initMobileDropdowns() {
        if (window.innerWidth <= 768) {
            headerDropdowns.forEach(dropdown => {
                const link = dropdown.querySelector('.mht-header-link');
                
                if (link && !link._hasMobileHandler) {
                    link._hasMobileHandler = true;
                    
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        // Close other dropdowns
                        headerDropdowns.forEach(other => {
                            if (other !== dropdown && other.classList.contains('active')) {
                                other.classList.remove('active');
                            }
                        });
                        
                        // Toggle current
                        dropdown.classList.toggle('active');
                    });
                }
            });
        } else {
            // Remove mobile handlers
            headerDropdowns.forEach(dropdown => {
                const link = dropdown.querySelector('.mht-header-link');
                if (link) {
                    link._hasMobileHandler = false;
                }
            });
        }
    }
    
    // Initial call
    initMobileDropdowns();
    
    // Handle window resize with debounce
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            // Reset mobile menu state
            if (window.innerWidth > 768 && headerBurger && headerNav && headerOverlay) {
                headerBurger.classList.remove('active');
                headerNav.classList.remove('active');
                headerOverlay.classList.remove('active');
                document.body.classList.remove('mht-header-no-scroll');
                headerBurger.setAttribute('aria-expanded', 'false');
                
                // Close all dropdowns
                headerDropdowns.forEach(drop => {
                    drop.classList.remove('active');
                });
            }
            
            // Reinitialize dropdown handlers
            initMobileDropdowns();
        }, 150);
    });
    
    // Active link handling
    function setActiveLink() {
        const currentPath = window.location.pathname;
        
        headerLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href && href !== '#' && href !== '/') {
                if (currentPath === href || (href !== '/' && currentPath.startsWith(href))) {
                    link.classList.add('mht-header-active');
                }
            }
        });
        
        // Handle home page
        if (currentPath === '/' || currentPath === '/index.php') {
            const homeLink = document.querySelector('.mht-header-link[href="/"]');
            if (homeLink) {
                homeLink.classList.add('mht-header-active');
            }
        }
    }
    
    setActiveLink();
});
</script>