<?php include 'includes/head.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include __DIR__ . '/../webmaster/includes/db.php'; ?>

<!-- Font Awesome dengan multiple CDN untuk memastikan semua icon tampil -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">

<style>
    /* MHTeams - Professional Styling with Poppins Font
   Color Palette:
   - Primary (Purple Pulse): #9C27B0
   - Background Dark (Carbon Black): #121212
   - Background Light (Snow White): #F9F9F9
   - Neutral Text (Ash Grey): #B0B0B0
   - Hover/Shade (Deep Plum): #7B1FA2
   - Accent Optional (Neon Blue): #2979FF
*/

/* ===== FONTS ===== */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

/* Swiper CSS */
@import url('https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');

/* ===== GLOBAL STYLES ===== */
:root {
    --primary: #9C27B0;
    --primary-dark: #7B1FA2;
    --primary-light: rgba(156, 39, 176, 0.1);
    --bg-dark: #121212;
    --bg-light: #F9F9F9;
    --text-neutral: #B0B0B0;
    --hover: #7B1FA2;
    --accent: #2979FF;
    --shadow-sm: 0 4px 6px rgba(0, 0, 0, 0.1);
    --shadow-md: 0 6px 12px rgba(0, 0, 0, 0.08);
    --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.12);
    --shadow-xl: 0 20px 40px rgba(0, 0, 0, 0.15);
    --shadow-2xl: 0 25px 50px rgba(156, 39, 176, 0.25);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --transition-slow: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    --transition-bounce: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    --radius-sm: 4px;
    --radius-md: 8px;
    --radius-lg: 16px;
    --radius-xl: 24px;
    --radius-2xl: 32px;
    --radius-full: 9999px;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    scroll-behavior: smooth;
    scroll-padding-top: 80px;
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: var(--bg-light);
    color: #333;
    line-height: 1.6;
    overflow-x: hidden;
}

body.modal-open {
    overflow: hidden;
}

.mht-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

h1, h2, h3, h4, h5, h6 {
    font-weight: 600;
    line-height: 1.3;
    margin-bottom: 1rem;
}

a {
    text-decoration: none;
    transition: var(--transition);
}

ul {
    list-style: none;
}

img {
    max-width: 100%;
    height: auto;
}

.mht-text-center {
    text-align: center;
}

/* ===== CUSTOM SCROLLBAR - KONSISTEN DENGAN HALAMAN LAIN ===== */
::-webkit-scrollbar {
    width: 12px;
}

::-webkit-scrollbar-track {
    background: var(--bg-light);
    border-radius: 6px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border-radius: 6px;
    border: 3px solid var(--bg-light);
    transition: var(--transition);
}

::-webkit-scrollbar-thumb:hover {
    background: var(--primary-dark);
}

/* Firefox scrollbar */
* {
    scrollbar-width: thin;
    scrollbar-color: var(--primary) var(--bg-light);
}

/* ===== HERO SECTION ===== */
.mht-parallax {
    position: relative;
    height: 100vh;
    min-height: 600px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    background: linear-gradient(135deg, rgba(18, 18, 18, 0.9), rgba(123, 31, 162, 0.8)), url('https://images.unsplash.com/photo-1555066931-4365d14bab8c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    overflow: hidden;
    margin-top: 0;
    padding-top: 80px;
}

.mht-parallax::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle at 30% 30%, rgba(156, 39, 176, 0.4), transparent 60%);
    animation: mhtPulse 4s ease-in-out infinite;
}

@keyframes mhtPulse {
    0%, 100% { opacity: 0.3; }
    50% { opacity: 0.6; }
}

.mht-parallax-content {
    position: relative;
    z-index: 2;
    max-width: 900px;
    padding: 0 20px;
}

.mht-hero-badge {
    display: inline-block;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    color: #fff;
    padding: 8px 24px;
    border-radius: var(--radius-full);
    font-size: 0.85rem;
    font-weight: 600;
    letter-spacing: 2px;
    margin-bottom: 25px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    text-transform: uppercase;
    animation: mhtFadeInDown 1s ease;
}

@keyframes mhtFadeInDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.mht-typewriter {
    font-size: clamp(2rem, 6vw, 3.5rem);
    font-weight: 800;
    color: #fff;
    margin-bottom: 20px;
    line-height: 1.2;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    animation: mhtFadeInUp 1s ease 0.2s both;
}

.mht-typewriter span {
    background: linear-gradient(135deg, #fff, var(--primary));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

@keyframes mhtFadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.mht-hero-subtitle {
    font-size: clamp(1rem, 2vw, 1.3rem);
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 40px;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
    animation: mhtFadeInUp 1s ease 0.4s both;
}

.mht-btn-explore {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #fff;
    padding: 14px 35px;
    border-radius: var(--radius-full);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 6px 20px rgba(156, 39, 176, 0.4);
    transition: var(--transition);
    animation: mhtFadeInUp 1s ease 0.6s both;
    position: relative;
    overflow: hidden;
}

.mht-btn-explore::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s ease;
}

.mht-btn-explore:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(156, 39, 176, 0.6);
}

.mht-btn-explore:hover::before {
    left: 100%;
}

/* ===== SECTION STYLES ===== */
section {
    padding: 100px 0;
    position: relative;
}

section:nth-child(even) {
    background-color: #fff;
}

.mht-section-title {
    text-align: center;
    margin-bottom: 15px;
    font-size: clamp(2rem, 4vw, 2.5rem);
    position: relative;
    color: var(--bg-dark);
}

.mht-section-title i {
    color: var(--primary);
    margin-right: 10px;
    background: var(--primary-light);
    padding: 10px;
    border-radius: 50%;
    font-size: 1.5rem;
}

.mht-section-title::after {
    content: '';
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 4px;
    background: linear-gradient(to right, var(--primary), var(--primary-dark));
    border-radius: 4px;
}

.mht-section-subtitle {
    text-align: center;
    margin-bottom: 50px;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
    color: var(--text-neutral);
    font-size: 1.1rem;
    padding-top: 20px;
}

/* ===== ABOUT SECTION ===== */
.mht-about-section {
    background-color: #fff;
    position: relative;
    overflow: hidden;
}

.mht-about-section::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(156, 39, 176, 0.08), transparent 70%);
    border-radius: 50%;
    z-index: 0;
    animation: mhtFloat 10s ease-in-out infinite;
}

@keyframes mhtFloat {
    0%, 100% { transform: translateY(0) translateX(0); }
    50% { transform: translateY(-20px) translateX(20px); }
}

.mht-about-container {
    position: relative;
    z-index: 2;
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 20px;
    text-align: center;
}

.mht-brand {
    color: var(--primary);
    font-weight: 700;
    position: relative;
}

.mht-about-description {
    font-size: 1.1rem;
    margin-bottom: 30px;
    line-height: 1.8;
}

.mht-about-history {
    background: var(--primary-light);
    padding: 30px;
    border-radius: var(--radius-lg);
    margin-bottom: 40px;
    border-left: 4px solid var(--primary);
    font-size: 1rem;
    line-height: 1.8;
}

.mht-about-stats {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin-bottom: 40px;
    flex-wrap: wrap;
}

.mht-stat-item {
    text-align: center;
    background: linear-gradient(135deg, #fff, var(--bg-light));
    padding: 25px 30px;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    min-width: 180px;
    transition: var(--transition);
    border: 1px solid var(--primary-light);
}

.mht-stat-item:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-lg);
    border-color: var(--primary);
}

.mht-stat-number {
    font-size: 3rem;
    font-weight: 800;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    display: block;
    line-height: 1;
    margin-bottom: 5px;
}

.mht-stat-label {
    font-size: 1rem;
    color: var(--text-neutral);
    font-weight: 500;
}

.mht-btn-learn-more {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #fff;
    padding: 14px 32px;
    border-radius: var(--radius-full);
    font-weight: 500;
    transition: var(--transition);
    box-shadow: 0 6px 20px rgba(156, 39, 176, 0.3);
    position: relative;
    overflow: hidden;
}

.mht-btn-learn-more::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s ease;
}

.mht-btn-learn-more:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(156, 39, 176, 0.5);
}

.mht-btn-learn-more:hover::before {
    left: 100%;
}

/* ===== RATECARD SECTION ===== */
.mht-ratecard-section {
    background-color: var(--bg-light);
    position: relative;
    overflow: hidden;
}

.mht-ratecard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.mht-ratecard-card {
    background-color: #fff;
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: var(--transition);
    position: relative;
    z-index: 1;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.mht-ratecard-card:hover {
    transform: translateY(-15px);
    box-shadow: var(--shadow-lg);
}

.mht-ratecard-header {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    padding: 30px 20px;
    color: #fff;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.mht-ratecard-header::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle at center, rgba(255, 255, 255, 0.2), transparent 70%);
    transform: rotate(30deg);
    animation: mhtRotate 10s linear infinite;
}

@keyframes mhtRotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.mht-package-name {
    font-size: 1.5rem;
    margin-bottom: 15px;
    position: relative;
    z-index: 1;
}

.mht-package-price {
    font-size: 2.2rem;
    font-weight: 800;
    position: relative;
    z-index: 1;
    margin-bottom: 5px;
}

.mht-ppn-note {
    font-size: 0.8rem;
    opacity: 0.9;
    position: relative;
    z-index: 1;
}

.mht-package-features {
    padding: 30px 25px;
    flex-grow: 1;
}

.mht-feature-item {
    margin-bottom: 15px;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 0.95rem;
}

.mht-feature-item i {
    color: var(--primary);
    margin-top: 3px;
    font-size: 1.1rem;
}

.mht-btn-ratecard {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #fff;
    text-align: center;
    padding: 15px;
    font-weight: 600;
    transition: var(--transition);
    margin: 0 25px 25px;
    border-radius: var(--radius-full);
    position: relative;
    overflow: hidden;
}

.mht-btn-ratecard::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s ease;
}

.mht-btn-ratecard:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(156, 39, 176, 0.4);
}

.mht-btn-ratecard:hover::before {
    left: 100%;
}

.mht-btn-view-all {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background-color: transparent;
    color: var(--primary);
    padding: 12px 30px;
    border-radius: var(--radius-full);
    font-weight: 600;
    border: 2px solid var(--primary);
    transition: var(--transition);
}

.mht-btn-view-all:hover {
    background-color: var(--primary);
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(156, 39, 176, 0.3);
}

/* ===== PROJECTS SECTION ===== */
.mht-projects-section {
    background-color: #fff;
    position: relative;
}

.mht-projects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
    gap: 30px;
}

.mht-project-card {
    background: linear-gradient(135deg, #fff, var(--bg-light));
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid rgba(156, 39, 176, 0.1);
}

.mht-project-card:hover {
    transform: translateY(-12px);
    box-shadow: var(--shadow-lg);
    border-color: var(--primary);
}

.mht-project-image-wrapper {
    position: relative;
    overflow: hidden;
    height: 220px;
}

.mht-project-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.mht-project-card:hover .mht-project-image {
    transform: scale(1.1);
}

.mht-project-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(156, 39, 176, 0.8), transparent);
    display: flex;
    align-items: flex-end;
    justify-content: flex-start;
    padding: 20px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.mht-project-card:hover .mht-project-overlay {
    opacity: 1;
}

.mht-project-overlay i {
    color: #fff;
    font-size: 2rem;
    background: rgba(255, 255, 255, 0.2);
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(5px);
}

.mht-project-info {
    padding: 25px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.mht-project-title {
    font-size: 1.3rem;
    margin-bottom: 12px;
    color: var(--bg-dark);
    display: flex;
    align-items: center;
    gap: 8px;
}

.mht-project-title i {
    color: var(--primary);
}

.mht-project-description {
    margin-bottom: 20px;
    color: #666;
    font-size: 0.95rem;
    line-height: 1.7;
    flex-grow: 1;
}

.mht-project-actions {
    display: flex;
    gap: 12px;
    margin-top: auto;
}

.mht-btn-project-detail, 
.mht-btn-project {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 10px 18px;
    border-radius: var(--radius-full);
    font-size: 0.9rem;
    font-weight: 500;
    transition: var(--transition);
    flex: 1;
}

.mht-btn-project-detail {
    background-color: var(--primary-light);
    border: 1px solid var(--primary);
    color: var(--primary);
}

.mht-btn-project {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #fff;
}

.mht-btn-project-detail:hover {
    background-color: var(--primary);
    color: #fff;
    transform: translateY(-3px);
}

.mht-btn-project:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(156, 39, 176, 0.4);
}

/* ===== EMPTY STATE STYLING ===== */
.mht-empty-state {
    text-align: center;
    padding: 60px 20px;
    background: linear-gradient(135deg, #fff, var(--bg-light));
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
    margin: 20px 0;
    border: 2px dashed var(--primary-light);
    grid-column: 1 / -1;
}

.mht-empty-icon {
    font-size: 4rem;
    color: var(--primary-light);
    margin-bottom: 20px;
    animation: mhtPulse 2s infinite;
}

.mht-empty-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 10px;
}

.mht-empty-text {
    font-size: 1rem;
    color: var(--text-neutral);
    max-width: 400px;
    margin: 0 auto 20px;
}

.mht-empty-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #fff;
    padding: 12px 30px;
    border-radius: var(--radius-full);
    font-weight: 500;
    transition: var(--transition);
    box-shadow: 0 6px 20px rgba(156, 39, 176, 0.3);
}

.mht-empty-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(156, 39, 176, 0.5);
}

/* ===== PARTNER CAROUSEL SECTION - PREMIUM AUTOPLAY ===== */
.mht-partner-section {
    background: linear-gradient(135deg, #fff, var(--bg-light));
    position: relative;
    overflow: hidden;
    padding: 80px 0;
}

.mht-partner-section::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(156, 39, 176, 0.03) 0%, transparent 70%);
    animation: mhtRotate 60s linear infinite;
    z-index: 0;
}

.mht-partner-title {
    text-align: center;
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--bg-dark);
    margin-bottom: 10px;
    position: relative;
    z-index: 2;
}

.mht-partner-title span {
    color: var(--primary);
    position: relative;
    display: inline-block;
}

.mht-partner-title span::after {
    content: '';
    position: absolute;
    bottom: 5px;
    left: 0;
    width: 100%;
    height: 8px;
    background: var(--primary-light);
    z-index: -1;
    border-radius: 4px;
}

.mht-partner-subtitle {
    text-align: center;
    color: var(--text-neutral);
    margin-bottom: 50px;
    font-size: 1.1rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    position: relative;
    z-index: 2;
}

/* Partner Swiper - Clean Autoplay Only */
.mht-partner-swiper {
    width: 100%;
    padding: 20px 0;
    margin: 0 auto;
    position: relative;
    z-index: 2;
    overflow: visible !important;
}

.mht-partner-swiper .swiper-wrapper {
    display: flex;
    align-items: center;
    transition-timing-function: linear !important;
}

.mht-partner-swiper .swiper-slide {
    display: flex;
    align-items: center;
    justify-content: center;
    height: auto;
    transition: all 0.3s ease;
}

.mht-partner-item {
    width: 200px;
    height: 130px;
    background: #fff;
    border-radius: var(--radius-xl);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 25px;
    box-shadow: var(--shadow-lg);
    transition: var(--transition);
    border: 2px solid transparent;
    margin: 0 auto;
    position: relative;
    overflow: hidden;
    cursor: pointer;
}

.mht-partner-item::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, 
        transparent 30%, 
        rgba(156, 39, 176, 0.1) 50%, 
        transparent 70%);
    transform: rotate(45deg) translate(-100%, -100%);
    transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.mht-partner-item:hover {
    transform: translateY(-8px) scale(1.05);
    box-shadow: var(--shadow-2xl);
    border-color: var(--primary);
}

.mht-partner-item:hover::before {
    transform: rotate(45deg) translate(100%, 100%);
}

.mht-partner-item::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: var(--radius-xl);
    padding: 2px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.mht-partner-item:hover::after {
    opacity: 1;
}

.mht-partner-logo {
    max-width: 100%;
    max-height: 70px;
    object-fit: contain;
    transition: var(--transition);
    position: relative;
    z-index: 2;
    filter: grayscale(100%);
    opacity: 0.7;
}

.mht-partner-item:hover .mht-partner-logo {
    filter: grayscale(0%);
    opacity: 1;
    transform: scale(1.1);
}

/* ===== CLIENTS CAROUSEL SECTION - PREMIUM AUTOPLAY ===== */
.mht-clients-section {
    background-color: #fff;
    position: relative;
    overflow: hidden;
    padding: 80px 0;
}

.mht-clients-section::before {
    content: '';
    position: absolute;
    bottom: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(156, 39, 176, 0.02) 0%, transparent 70%);
    animation: mhtRotateReverse 50s linear infinite;
    z-index: 0;
}

@keyframes mhtRotateReverse {
    from { transform: rotate(360deg); }
    to { transform: rotate(0deg); }
}

.mht-clients-swiper {
    width: 100%;
    padding: 20px 0;
    margin: 20px auto 0;
    position: relative;
    z-index: 2;
    overflow: visible !important;
}

.mht-clients-swiper .swiper-wrapper {
    display: flex;
    align-items: stretch;
    transition-timing-function: linear !important;
}

.mht-clients-swiper .swiper-slide {
    height: auto;
    display: flex;
    transition: all 0.3s ease;
}

.mht-client-card {
    background: linear-gradient(135deg, #fff, var(--bg-light));
    border-radius: var(--radius-2xl);
    padding: 30px 20px;
    text-align: center;
    box-shadow: var(--shadow-lg);
    transition: var(--transition);
    border: 2px solid transparent;
    height: 100%;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    cursor: pointer;
}

.mht-client-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 100%;
    background: linear-gradient(135deg, rgba(156, 39, 176, 0.05), rgba(123, 31, 162, 0.05));
    transform: translateY(-100%);
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.mht-client-card:hover::before {
    transform: translateY(0);
}

.mht-client-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: var(--shadow-2xl);
    border-color: var(--primary);
}

.mht-client-logo {
    width: 120px;
    height: 120px;
    object-fit: contain;
    margin-bottom: 20px;
    filter: grayscale(100%);
    opacity: 0.7;
    transition: var(--transition);
    border-radius: 50%;
    background: #fff;
    padding: 15px;
    box-shadow: var(--shadow-md);
    position: relative;
    z-index: 2;
}

.mht-client-card:hover .mht-client-logo {
    filter: grayscale(0%);
    opacity: 1;
    transform: scale(1.1);
    box-shadow: var(--shadow-xl);
}

.mht-client-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--bg-dark);
    margin-bottom: 5px;
    position: relative;
    z-index: 2;
    transition: var(--transition);
}

.mht-client-card:hover .mht-client-name {
    color: var(--primary);
}

.mht-client-industry {
    font-size: 0.85rem;
    color: var(--text-neutral);
    margin-bottom: 15px;
    position: relative;
    z-index: 2;
}

.mht-client-testimonial {
    font-size: 0.9rem;
    color: #555;
    font-style: italic;
    line-height: 1.6;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 2px dashed var(--primary-light);
    position: relative;
    z-index: 2;
    transition: var(--transition);
}

.mht-client-card:hover .mht-client-testimonial {
    color: #333;
}

/* ===== NEWS SECTION - PREMIUM STYLING ===== */
.mht-news-section {
    background: linear-gradient(135deg, #fff, var(--bg-light));
    position: relative;
    overflow: hidden;
    padding: 80px 0;
}

.mht-news-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 300px;
    background: linear-gradient(135deg, var(--primary-light), transparent);
    z-index: 0;
}

.mht-news-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    position: relative;
    z-index: 2;
}

.mht-news-card {
    background: #fff;
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-lg);
    transition: var(--transition);
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid rgba(156, 39, 176, 0.1);
    position: relative;
    backdrop-filter: blur(10px);
}

.mht-news-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary), var(--primary-dark));
    transform: scaleX(0);
    transition: transform 0.4s ease;
}

.mht-news-card:hover {
    transform: translateY(-12px);
    box-shadow: var(--shadow-xl);
    border-color: var(--primary);
}

.mht-news-card:hover::before {
    transform: scaleX(1);
}

.mht-news-image-wrapper {
    position: relative;
    height: 220px;
    overflow: hidden;
    cursor: pointer;
}

.mht-news-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.mht-news-card:hover .mht-news-image {
    transform: scale(1.15);
}

.mht-news-category {
    position: absolute;
    top: 15px;
    right: 15px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #fff;
    padding: 6px 16px;
    border-radius: 30px;
    font-size: 0.75rem;
    font-weight: 600;
    z-index: 2;
    box-shadow: var(--shadow-lg);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(5px);
}

.mht-news-date {
    position: absolute;
    bottom: 15px;
    left: 15px;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(10px);
    color: #fff;
    padding: 6px 16px;
    border-radius: 30px;
    font-size: 0.75rem;
    display: flex;
    align-items: center;
    gap: 6px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: var(--shadow-md);
}

.mht-news-date i {
    color: var(--primary);
}

.mht-news-content {
    padding: 25px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.mht-news-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--bg-dark);
    margin-bottom: 12px;
    line-height: 1.4;
    transition: var(--transition);
}

.mht-news-card:hover .mht-news-title {
    color: var(--primary);
}

.mht-news-excerpt {
    color: #666;
    font-size: 0.95rem;
    line-height: 1.7;
    margin-bottom: 20px;
    flex-grow: 1;
}

.mht-news-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid var(--primary-light);
}

.mht-news-author {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--text-neutral);
    font-size: 0.85rem;
}

.mht-news-author i {
    color: var(--primary);
}

.mht-news-read-time {
    display: flex;
    align-items: center;
    gap: 5px;
    color: var(--text-neutral);
    font-size: 0.85rem;
}

.mht-news-read-time i {
    color: var(--primary);
}

.mht-btn-read-more {
    display: inline-flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    color: var(--primary);
    font-weight: 600;
    font-size: 0.95rem;
    transition: var(--transition);
    margin-top: auto;
    padding: 10px 0;
    border-top: 1px solid transparent;
    position: relative;
}

.mht-btn-read-more::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--primary), var(--primary-dark));
    transition: width 0.3s ease;
}

.mht-btn-read-more:hover {
    color: var(--primary-dark);
    gap: 12px;
}

.mht-btn-read-more:hover::after {
    width: 100%;
}

/* ===== GALLERY SECTION WITH MODAL ===== */
.mht-gallery-section {
    background: linear-gradient(135deg, var(--bg-light), #fff);
    position: relative;
    overflow: hidden;
    padding: 80px 0;
}

.mht-gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}

.mht-gallery-item {
    position: relative;
    border-radius: var(--radius-lg);
    overflow: hidden;
    aspect-ratio: 4/3;
    cursor: pointer;
    box-shadow: var(--shadow-md);
}

.mht-gallery-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.mht-gallery-item:hover .mht-gallery-image {
    transform: scale(1.1);
}

.mht-gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(156, 39, 176, 0.8), rgba(0, 0, 0, 0.2));
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    color: #fff;
    padding: 20px;
    text-align: center;
}

.mht-gallery-item:hover .mht-gallery-overlay {
    opacity: 1;
}

.mht-gallery-overlay i {
    font-size: 2.5rem;
    margin-bottom: 10px;
    background: rgba(255, 255, 255, 0.2);
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(5px);
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.mht-gallery-overlay h4 {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 5px;
}

.mht-gallery-overlay p {
    font-size: 0.85rem;
    opacity: 0.9;
}

/* Modal Styles */
.mht-gallery-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.95);
    z-index: 9999;
    opacity: 0;
    transition: opacity 0.3s ease;
    overflow-y: auto;
}

.mht-gallery-modal.active {
    display: flex;
    opacity: 1;
    align-items: center;
    justify-content: center;
}

.mht-modal-content {
    position: relative;
    max-width: 90%;
    max-height: 90%;
    margin: auto;
    background: transparent;
    border-radius: var(--radius-lg);
    overflow: hidden;
    transform: scale(0.9);
    transition: transform 0.3s ease;
}

.mht-gallery-modal.active .mht-modal-content {
    transform: scale(1);
}

.mht-modal-image {
    max-width: 100%;
    max-height: 80vh;
    object-fit: contain;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-xl);
}

.mht-modal-close {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border: none;
    border-radius: 50%;
    color: #fff;
    font-size: 1.5rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
    z-index: 10000;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.mht-modal-close:hover {
    transform: scale(1.1) rotate(90deg);
    background: var(--primary-dark);
}

.mht-modal-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border: none;
    border-radius: 50%;
    color: #fff;
    font-size: 1.5rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
    z-index: 10000;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.mht-modal-nav:hover {
    transform: translateY(-50%) scale(1.1);
    background: var(--primary-dark);
}

.mht-modal-nav.prev {
    left: 20px;
}

.mht-modal-nav.next {
    right: 20px;
}

.mht-modal-caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
    color: #fff;
    padding: 20px;
    text-align: center;
    font-size: 1rem;
}

.mht-modal-caption h4 {
    margin-bottom: 5px;
    font-size: 1.2rem;
}

.mht-modal-caption p {
    opacity: 0.9;
    font-size: 0.9rem;
}

/* ===== EVENTS SECTION - NEW DESIGN WITH 4:5 THUMBNAIL ===== */
.mht-events-section {
    background-color: #fff;
    position: relative;
    overflow: hidden;
    padding: 80px 0;
}

.mht-events-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
}

.mht-event-card {
    background: linear-gradient(135deg, #fff, var(--bg-light));
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-lg);
    transition: var(--transition);
    display: flex;
    flex-direction: column;
    border: 1px solid var(--primary-light);
    height: 100%;
}

.mht-event-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-xl);
    border-color: var(--primary);
}

.mht-event-image-wrapper {
    position: relative;
    width: 100%;
    padding-top: 125%; /* 4:5 Aspect Ratio */
    overflow: hidden;
}

.mht-event-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.mht-event-card:hover .mht-event-image {
    transform: scale(1.1);
}

.mht-event-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 20px;
    color: #fff;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.mht-event-card:hover .mht-event-overlay {
    opacity: 1;
}

.mht-event-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #fff;
    padding: 6px 15px;
    border-radius: 30px;
    font-size: 0.75rem;
    font-weight: 600;
    z-index: 2;
    box-shadow: var(--shadow-md);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.mht-event-badge.ongoing {
    background: linear-gradient(135deg, #4CAF50, #2E7D32);
}

.mht-event-badge.upcoming {
    background: linear-gradient(135deg, #FFC107, #FF8F00);
}

.mht-event-badge.completed {
    background: linear-gradient(135deg, #9E9E9E, #616161);
}

.mht-event-content {
    padding: 25px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.mht-event-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--bg-dark);
    margin-bottom: 15px;
    line-height: 1.4;
}

.mht-event-details {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 15px;
    background: var(--primary-light);
    padding: 15px;
    border-radius: var(--radius-md);
}

.mht-event-detail {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #555;
    font-size: 0.9rem;
}

.mht-event-detail i {
    color: var(--primary);
    width: 20px;
    font-size: 1rem;
}

.mht-event-description {
    color: #666;
    font-size: 0.95rem;
    line-height: 1.7;
    margin-bottom: 20px;
    flex-grow: 1;
}

.mht-event-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    padding-top: 15px;
    border-top: 1px solid var(--primary-light);
}

.mht-event-stats {
    display: flex;
    gap: 15px;
}

.mht-event-stat {
    display: flex;
    align-items: center;
    gap: 5px;
    color: var(--text-neutral);
    font-size: 0.8rem;
}

.mht-event-stat i {
    color: var(--primary);
}

.mht-btn-event {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #fff;
    padding: 10px 20px;
    border-radius: 30px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: var(--transition);
    box-shadow: var(--shadow-md);
}

.mht-btn-event:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
    gap: 12px;
}

/* ===== COLLABORATION SECTION ===== */
.mht-collab-section {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    position: relative;
    overflow: hidden;
    color: #fff;
}

.mht-collab-section::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1), transparent 70%);
    animation: mhtRotate 40s linear infinite;
}

.mht-collab-container {
    position: relative;
    z-index: 2;
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
    padding: 0 20px;
}

.mht-collab-title {
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 15px;
}

.mht-collab-text {
    font-size: 1.1rem;
    margin-bottom: 30px;
    opacity: 0.9;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.mht-btn-collab {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: #fff;
    color: var(--primary);
    padding: 15px 40px;
    border-radius: var(--radius-full);
    font-weight: 600;
    font-size: 1.1rem;
    transition: var(--transition);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    position: relative;
    overflow: hidden;
}

.mht-btn-collab::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(156, 39, 176, 0.1), transparent);
    transition: left 0.6s ease;
}

.mht-btn-collab:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
}

.mht-btn-collab:hover::before {
    left: 100%;
}

/* ===== ERROR MESSAGE STYLING ===== */
.mht-error {
    background: linear-gradient(135deg, #ffebee, #ffcdd2);
    color: #c62828;
    padding: 20px;
    border-radius: var(--radius-lg);
    text-align: center;
    margin: 20px 0;
    border-left: 4px solid #c62828;
    font-weight: 500;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    .mht-modal-nav {
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
    }
    
    .mht-modal-nav.prev {
        left: 10px;
    }
    
    .mht-modal-nav.next {
        right: 10px;
    }
    
    .mht-modal-close {
        top: 10px;
        right: 10px;
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
    }
    
    .mht-partner-item {
        width: 160px;
        height: 110px;
    }
    
    .mht-client-logo {
        width: 100px;
        height: 100px;
    }
}

@media (max-width: 576px) {
    .mht-event-footer {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
    
    .mht-btn-event {
        width: 100%;
        justify-content: center;
    }
    
    .mht-partner-item {
        width: 140px;
        height: 100px;
    }
}
</style>

<!-- 🎭 Hero Section with Typewriter Animation -->
<section class="mht-parallax">
    <div class="mht-parallax-content">
        <span class="mht-hero-badge">PT MICROHELIX TECH SOLUTIONS</span>
        <h2 class="mht-typewriter">
            Welcome To <span>MicroHelix</span>
        </h2>
        <p class="mht-hero-subtitle">Innovating Ideas, Empowering Creativity - Solusi Digital Terpercaya untuk Bisnis Anda</p>
        <a href="#explore" class="mht-btn-explore">
            Jelajahi Sekarang <i class="fas fa-arrow-down"></i>
        </a>
    </div>
</section>    

<!-- 📌 About Section -->
<section id="mht-about" class="mht-about-section" data-aos="fade-up">
    <div class="mht-about-container">
        <h2 class="mht-section-title"><i class="fas fa-microchip"></i> Selamat Datang di <span class="mht-brand">PT MicroHelix Tech Solutions</span></h2>
        <p class="mht-about-description">
            PT MicroHelix Tech Solutions adalah perusahaan teknologi yang berfokus pada pengembangan solusi digital inovatif 
            untuk membantu bisnis berkembang di era digital. Kami menghadirkan layanan berkualitas tinggi dengan pendekatan 
            yang kreatif dan profesional.
        </p>
        <div class="mht-about-history">
            <p>
                <strong>Didirikan pada Desember 2024</strong>, PT MicroHelix Tech Solutions berkomitmen untuk menjadi mitra 
                teknologi terpercaya bagi berbagai industri dalam mewujudkan transformasi digital yang berkelanjutan. 
                Dengan tim yang berpengalaman dan passion tinggi, kami siap membantu Anda mencapai tujuan bisnis melalui teknologi.
            </p>
        </div>
        <div class="mht-about-stats">
            <div class="mht-stat-item">
                <span class="mht-stat-number" data-count="25">0</span>
                <span class="mht-stat-label">Proyek Selesai</span>
            </div>
            <div class="mht-stat-item">
                <span class="mht-stat-number" data-count="15">0</span>
                <span class="mht-stat-label">Klien Puas</span>
            </div>
            <div class="mht-stat-item">
                <span class="mht-stat-number" data-count="8">0</span>
                <span class="mht-stat-label">Kolaborasi Strategis</span>
            </div>
        </div>
        <a href="/tentang-kami" class="mht-btn-learn-more">
            <i class="fas fa-info-circle"></i> Tentang Perusahaan
        </a>
    </div>
</section>

<!-- 🤝 Partner Carousel Section - Premium Autoplay Only -->
<section class="mht-partner-section" data-aos="fade-up">
    <div class="mht-container">
        <h2 class="mht-partner-title">Mitra & <span>Kolaborator</span></h2>
        <p class="mht-partner-subtitle">Berkolaborasi dengan berbagai mitra terpercaya untuk menghadirkan solusi terbaik</p>
        
        <!-- Partner Swiper - No Navigation, No Pagination, Just Autoplay -->
        <div class="swiper mht-partner-swiper">
            <div class="swiper-wrapper">
                <?php
                // Hanya tampilkan jika ada data dari database, tanpa dummy/fallback
                try {
                    $partnerQuery = "SELECT * FROM collaborations ORDER BY RAND() LIMIT 15";
                    $partnerStmt = $pdo->query($partnerQuery);
                    
                    if ($partnerStmt && $partnerStmt->rowCount() > 0):
                        while($partner = $partnerStmt->fetch()):
                ?>
                <div class="swiper-slide">
                    <div class="mht-partner-item">
                        <img src="/webmaster/uploads/<?php echo htmlspecialchars($partner['logo']); ?>" 
                             alt="<?php echo htmlspecialchars($partner['name']); ?>" 
                             class="mht-partner-logo">
                    </div>
                </div>
                <?php 
                        endwhile;
                    endif;
                } catch (PDOException $e) {
                    // Silent catch - tidak menampilkan error, biarkan section kosong
                }
                ?>
            </div>
        </div>
        
        <!-- Empty state jika tidak ada data -->
        <?php
        try {
            $checkQuery = "SELECT COUNT(*) as total FROM collaborations";
            $checkStmt = $pdo->query($checkQuery);
            $total = $checkStmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            if ($total == 0):
        ?>
        <div class="mht-empty-state">
            <div class="mht-empty-icon">
                <i class="fas fa-handshake"></i>
            </div>
            <h3 class="mht-empty-title">Belum Ada Mitra</h3>
            <p class="mht-empty-text">Saat ini belum ada data mitra dan kolaborator. Silakan kembali lagi nanti.</p>
        </div>
        <?php 
            endif;
        } catch (PDOException $e) {
            // Tampilkan empty state jika tabel tidak ada atau error
        ?>
        <div class="mht-empty-state">
            <div class="mht-empty-icon">
                <i class="fas fa-handshake"></i>
            </div>
            <h3 class="mht-empty-title">Belum Ada Mitra</h3>
            <p class="mht-empty-text">Saat ini belum ada data mitra dan kolaborator. Silakan kembali lagi nanti.</p>
        </div>
        <?php
        }
        ?>
    </div>
</section>

<!-- 👥 Our Clients Section - Premium Autoplay Only -->
<section class="mht-clients-section" data-aos="fade-up">
    <div class="mht-container">
        <h2 class="mht-section-title"><i class="fas fa-handshake"></i> Klien <span>Kami</span></h2>
        <p class="mht-section-subtitle">Beberapa perusahaan dan brand yang telah mempercayakan layanan kami</p>

        <!-- Clients Swiper - No Navigation, No Pagination, Just Autoplay -->
        <div class="swiper mht-clients-swiper">
            <div class="swiper-wrapper">
                <?php
                // Hanya tampilkan jika ada data dari database, tanpa dummy/fallback
                try {
                    $clientsQuery = "SELECT * FROM clients ORDER BY is_featured DESC, sort_order ASC, RAND() LIMIT 10";
                    $clientsStmt = $pdo->query($clientsQuery);
                    
                    if ($clientsStmt && $clientsStmt->rowCount() > 0):
                        while ($client = $clientsStmt->fetch(PDO::FETCH_ASSOC)):
                            $clientName = htmlspecialchars($client['name']);
                            $clientIndustry = htmlspecialchars($client['industry'] ?? 'Various');
                            $clientLogo = htmlspecialchars($client['logo']);
                            $clientTestimonial = htmlspecialchars($client['testimonial'] ?? 'Kami sangat puas dengan layanan MicroHelix yang profesional dan berkualitas.');
                ?>
                <div class="swiper-slide">
                    <div class="mht-client-card">
                        <img src="/webmaster/uploads/<?php echo $clientLogo; ?>" 
                             alt="<?php echo $clientName; ?>" 
                             class="mht-client-logo"
                             onerror="this.src='/webmaster/uploads/default-client.png'">
                        <h4 class="mht-client-name"><?php echo $clientName; ?></h4>
                        <p class="mht-client-industry"><?php echo $clientIndustry; ?></p>
                        <p class="mht-client-testimonial">"<?php echo $clientTestimonial; ?>"</p>
                    </div>
                </div>
                <?php 
                        endwhile;
                    endif;
                } catch (PDOException $e) {
                    // Silent catch - tidak menampilkan error, biarkan section kosong
                }
                ?>
            </div>
        </div>

        <!-- Empty state jika tidak ada data -->
        <?php
        try {
            $checkQuery = "SELECT COUNT(*) as total FROM clients";
            $checkStmt = $pdo->query($checkQuery);
            $total = $checkStmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            if ($total == 0):
        ?>
        <div class="mht-empty-state">
            <div class="mht-empty-icon">
                <i class="fas fa-users"></i>
            </div>
            <h3 class="mht-empty-title">Belum Ada Klien</h3>
            <p class="mht-empty-text">Saat ini belum ada data klien. Silakan kembali lagi nanti.</p>
        </div>
        <?php 
            endif;
        } catch (PDOException $e) {
            // Tampilkan empty state jika tabel tidak ada atau error
        ?>
        <div class="mht-empty-state">
            <div class="mht-empty-icon">
                <i class="fas fa-users"></i>
            </div>
            <h3 class="mht-empty-title">Belum Ada Klien</h3>
            <p class="mht-empty-text">Saat ini belum ada data klien. Silakan kembali lagi nanti.</p>
        </div>
        <?php
        }
        ?>

        <div class="mht-text-center" style="margin-top: 3rem;">
            <a href="/testimoni" class="mht-btn-view-all">Lihat Semua Testimoni <i class="fas fa-chevron-right"></i></a>
        </div>
    </div>
</section>

<!-- 📢 Ratecard Section -->
<section id="mht-ratecard" class="mht-ratecard-section" data-aos="fade-up">
    <div class="mht-container">
        <h2 class="mht-section-title"><i class="fas fa-tags"></i> Layanan Pembuatan Website</h2>
        <p class="mht-section-subtitle">Solusi profesional dari PT MicroHelix Tech Solutions untuk kebutuhan digital Anda</p>
        
        <div class="mht-ratecard-grid">
            <?php
            try {
                $query = "SELECT * FROM packages ORDER BY price ASC LIMIT 3";
                $stmt = $pdo->query($query);
                
                if ($stmt && $stmt->rowCount() > 0):
                    while ($package = $stmt->fetch()):
            ?>
            <div class="mht-ratecard-card">
                <div class="mht-ratecard-header">
                    <h3 class="mht-package-name"><?php echo htmlspecialchars($package['name']); ?></h3>
                    <div class="mht-package-price">
                        Rp <?php echo number_format($package['price'], 0, ',', '.'); ?>
                    </div>
                    <small class="mht-ppn-note">*Belum termasuk PPN 11%</small>
                </div>
                <ul class="mht-package-features">
                    <?php 
                    $features = explode(',', $package['features']);
                    foreach ($features as $feature): 
                    ?>
                    <li class="mht-feature-item">
                        <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars(trim($feature)); ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <a href="/detail-paket?slug=<?php echo urlencode($package['slug']); ?>" class="mht-btn-ratecard">
                    Pilih Layanan <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <?php 
                    endwhile;
                endif;
            } catch (PDOException $e) {
                // Silent catch
            }
            ?>
        </div>
        
        <!-- Empty state jika tidak ada data -->
        <?php
        try {
            $checkQuery = "SELECT COUNT(*) as total FROM packages";
            $checkStmt = $pdo->query($checkQuery);
            $total = $checkStmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            if ($total == 0):
        ?>
        <div class="mht-empty-state">
            <div class="mht-empty-icon">
                <i class="fas fa-tags"></i>
            </div>
            <h3 class="mht-empty-title">Belum Ada Layanan</h3>
            <p class="mht-empty-text">Saat ini belum ada data layanan. Silakan kembali lagi nanti.</p>
        </div>
        <?php 
            endif;
        } catch (PDOException $e) {
            // Tampilkan empty state jika tabel tidak ada atau error
        ?>
        <div class="mht-empty-state">
            <div class="mht-empty-icon">
                <i class="fas fa-tags"></i>
            </div>
            <h3 class="mht-empty-title">Belum Ada Layanan</h3>
            <p class="mht-empty-text">Saat ini belum ada data layanan. Silakan kembali lagi nanti.</p>
        </div>
        <?php
        }
        ?>
        
        <div class="mht-text-center">
            <a href="/paket-kami" class="mht-btn-view-all">
                Lihat Semua Layanan <i class="fas fa-chevron-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- 📌 Projects Section -->
<section id="mht-projects" class="mht-projects-section" data-aos="fade-up">
    <div class="mht-container">
        <h2 class="mht-section-title"><i class="fas fa-laptop-code"></i> Portofolio Proyek</h2>
        <p class="mht-section-subtitle">
            Berikut adalah beberapa proyek inovatif yang telah dikembangkan oleh PT MicroHelix Tech Solutions.
        </p>

        <div class="mht-projects-grid">
            <?php
            try {
                $projectQuery = "SELECT * FROM projects ORDER BY date_added DESC LIMIT 3";
                $projectStmt = $pdo->query($projectQuery);

                if ($projectStmt && $projectStmt->rowCount() > 0):
                    while ($project = $projectStmt->fetch(PDO::FETCH_ASSOC)):
                        $projectSlug = htmlspecialchars($project['slug']);
                        $projectName = htmlspecialchars($project['name']);
                        $projectDesc = htmlspecialchars($project['description']);
                        $projectIcon = htmlspecialchars($project['icon']);
                        $projectImage = htmlspecialchars($project['image']);
                        $projectUrl = !empty($project['url']) ? htmlspecialchars($project['url']) : '';
            ?>
            <div class="mht-project-card" data-aos="zoom-in">
                <div class="mht-project-image-wrapper">
                    <img src="/webmaster/uploads/<?php echo $projectImage; ?>" 
                         alt="<?php echo $projectName; ?>" 
                         class="mht-project-image" 
                         loading="lazy"
                         onerror="this.src='/webmaster/uploads/default-project.jpg'" />
                    <div class="mht-project-overlay">
                        <i class="fas fa-<?php echo $projectIcon; ?>"></i>
                    </div>
                </div>
                <div class="mht-project-info">
                    <h3 class="mht-project-title"><i class="fas fa-<?php echo $projectIcon; ?>"></i> <?php echo $projectName; ?></h3>
                    <p class="mht-project-description">
                        <?php echo strlen($projectDesc) > 120 ? substr(strip_tags($projectDesc), 0, 120) . '...' : $projectDesc; ?>
                    </p>
                    <div class="mht-project-actions">
                        <a href="/detail-proyek?slug=<?php echo urlencode($projectSlug); ?>" class="mht-btn-project-detail" aria-label="Detail proyek <?php echo $projectName; ?>">
                            <i class="fas fa-info-circle"></i> Detail
                        </a>
                        <?php if ($projectUrl): ?>
                        <a href="<?php echo $projectUrl; ?>" target="_blank" rel="noopener noreferrer" class="mht-btn-project" aria-label="Kunjungi proyek <?php echo $projectName; ?>">
                            <i class="fas fa-arrow-right"></i> Kunjungi
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php 
                    endwhile;
                endif;
            } catch (PDOException $e) {
                // Silent catch
            }
            ?>
        </div>

        <!-- Empty state jika tidak ada data -->
        <?php
        try {
            $checkQuery = "SELECT COUNT(*) as total FROM projects";
            $checkStmt = $pdo->query($checkQuery);
            $total = $checkStmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            if ($total == 0):
        ?>
        <div class="mht-empty-state">
            <div class="mht-empty-icon">
                <i class="fas fa-laptop-code"></i>
            </div>
            <h3 class="mht-empty-title">Belum Ada Proyek</h3>
            <p class="mht-empty-text">Saat ini belum ada data proyek. Silakan kembali lagi nanti.</p>
        </div>
        <?php 
            endif;
        } catch (PDOException $e) {
            // Tampilkan empty state jika tabel tidak ada atau error
        ?>
        <div class="mht-empty-state">
            <div class="mht-empty-icon">
                <i class="fas fa-laptop-code"></i>
            </div>
            <h3 class="mht-empty-title">Belum Ada Proyek</h3>
            <p class="mht-empty-text">Saat ini belum ada data proyek. Silakan kembali lagi nanti.</p>
        </div>
        <?php
        }
        ?>

        <div class="mht-text-center" style="margin-top: 2rem;">
            <a href="/proyek-kami" class="mht-btn-view-all" aria-label="Lihat semua portofolio">
                Lihat Semua Portofolio <i class="fas fa-chevron-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- 📰 News Section - Premium Design -->
<section class="mht-news-section" data-aos="fade-up">
    <div class="mht-container">
        <h2 class="mht-section-title"><i class="fas fa-newspaper"></i> Berita <span>Terbaru</span></h2>
        <p class="mht-section-subtitle">Ikuti perkembangan dan informasi terbaru dari PT MicroHelix Tech Solutions</p>

        <div class="mht-news-grid">
            <?php
            try {
                $newsQuery = "SELECT * FROM news WHERE status = 'published' ORDER BY date_published DESC LIMIT 3";
                $newsStmt = $pdo->query($newsQuery);
                
                if ($newsStmt && $newsStmt->rowCount() > 0):
                    while ($news = $newsStmt->fetch(PDO::FETCH_ASSOC)):
                        $title = htmlspecialchars($news['title']);
                        $slug = htmlspecialchars($news['slug']);
                        $excerpt = htmlspecialchars($news['excerpt']);
                        $category = htmlspecialchars($news['category']);
                        $author = htmlspecialchars($news['author']);
                        $image = htmlspecialchars($news['image']);
                        $read_time = (int)$news['read_time'];
                        $date = date('d M Y', strtotime($news['date_published']));
            ?>
            <div class="mht-news-card">
                <div class="mht-news-image-wrapper">
                    <img src="/webmaster/uploads/<?php echo $image; ?>" alt="<?php echo $title; ?>" class="mht-news-image" onerror="this.src='/webmaster/uploads/default-news.jpg'">
                    <span class="mht-news-category"><?php echo $category; ?></span>
                    <span class="mht-news-date"><i class="far fa-calendar"></i> <?php echo $date; ?></span>
                </div>
                <div class="mht-news-content">
                    <h3 class="mht-news-title"><?php echo $title; ?></h3>
                    <p class="mht-news-excerpt"><?php echo $excerpt; ?></p>
                    <div class="mht-news-meta">
                        <span class="mht-news-author"><i class="far fa-user"></i> <?php echo $author; ?></span>
                        <span class="mht-news-read-time"><i class="far fa-clock"></i> <?php echo $read_time; ?> menit</span>
                    </div>
                    <!-- Link ke halaman detail berita dengan parameter slug -->
                    <a href="detail-berita?slug=<?php echo urlencode($slug); ?>" class="mht-btn-read-more">
                        Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php 
                    endwhile;
                endif;
            } catch (PDOException $e) {
                // Silent catch
            }
            ?>
        </div>

        <!-- Empty state jika tidak ada data -->
        <?php
        try {
            $checkQuery = "SELECT COUNT(*) as total FROM news WHERE status = 'published'";
            $checkStmt = $pdo->query($checkQuery);
            $total = $checkStmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            if ($total == 0):
        ?>
        <div class="mht-empty-state">
            <div class="mht-empty-icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <h3 class="mht-empty-title">Belum Ada Berita</h3>
            <p class="mht-empty-text">Saat ini belum ada berita yang dipublikasikan. Silakan kembali lagi nanti.</p>
        </div>
        <?php 
            endif;
        } catch (PDOException $e) {
            // Tampilkan empty state jika tabel tidak ada atau error
        ?>
        <div class="mht-empty-state">
            <div class="mht-empty-icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <h3 class="mht-empty-title">Belum Ada Berita</h3>
            <p class="mht-empty-text">Saat ini belum ada berita yang dipublikasikan. Silakan kembali lagi nanti.</p>
        </div>
        <?php
        }
        ?>

        <div class="mht-text-center" style="margin-top: 3rem;">
            <a href="berita" class="mht-btn-view-all">Lihat Semua Berita <i class="fas fa-chevron-right"></i></a>
        </div>
    </div>
</section>

<!-- 🖼️ Gallery Section - From Database with Modal -->
<section class="mht-gallery-section" data-aos="fade-up">
    <div class="mht-container">
        <h2 class="mht-section-title"><i class="fas fa-images"></i> Galeri <span>Kegiatan</span></h2>
        <p class="mht-section-subtitle">Dokumentasi berbagai kegiatan dan momen bersama PT MicroHelix Tech Solutions</p>

        <div class="mht-gallery-grid" id="mht-gallery-grid">
            <?php
            $galleryItems = [];
            try {
                $galleryQuery = "SELECT * FROM gallery ORDER BY is_featured DESC, sort_order ASC LIMIT 6";
                $galleryStmt = $pdo->query($galleryQuery);
                $galleryItems = $galleryStmt->fetchAll(PDO::FETCH_ASSOC);
                
                if (!empty($galleryItems)):
                    foreach ($galleryItems as $gallery):
                        $title = htmlspecialchars($gallery['title']);
                        $description = htmlspecialchars($gallery['description']);
                        $category = htmlspecialchars($gallery['category']);
                        $image = htmlspecialchars($gallery['image']);
                        $thumbnail = !empty($gallery['thumbnail']) ? htmlspecialchars($gallery['thumbnail']) : $image;
            ?>
            <div class="mht-gallery-item" onclick="openGalleryModal(<?php echo htmlspecialchars(json_encode($galleryItems), ENT_QUOTES, 'UTF-8'); ?>, <?php echo array_search($gallery, $galleryItems); ?>)">
                <img src="/webmaster/uploads/<?php echo $thumbnail; ?>" alt="<?php echo $title; ?>" class="mht-gallery-image" onerror="this.src='/webmaster/uploads/default-gallery.jpg'">
                <div class="mht-gallery-overlay">
                    <i class="fas fa-search-plus"></i>
                    <h4><?php echo $title; ?></h4>
                    <p><?php echo $category; ?></p>
                </div>
            </div>
            <?php 
                    endforeach;
                endif;
            } catch (PDOException $e) {
                // Silent catch
            }
            ?>
        </div>

        <!-- Empty state jika tidak ada data -->
        <?php
        if (empty($galleryItems)):
        ?>
        <div class="mht-empty-state">
            <div class="mht-empty-icon">
                <i class="fas fa-images"></i>
            </div>
            <h3 class="mht-empty-title">Belum Ada Galeri</h3>
            <p class="mht-empty-text">Saat ini belum ada foto kegiatan. Silakan kembali lagi nanti.</p>
        </div>
        <?php
        endif;
        ?>

        <div class="mht-text-center" style="margin-top: 3rem;">
            <a href="/gallery" class="mht-btn-view-all">Lihat Gallery Lainnya <i class="fas fa-chevron-right"></i></a>
        </div>
    </div>
</section>

<!-- Gallery Modal -->
<div class="mht-gallery-modal" id="galleryModal">
    <button class="mht-modal-close" onclick="closeGalleryModal()"><i class="fas fa-times"></i></button>
    <button class="mht-modal-nav prev" onclick="navigateGallery(-1)"><i class="fas fa-chevron-left"></i></button>
    <button class="mht-modal-nav next" onclick="navigateGallery(1)"><i class="fas fa-chevron-right"></i></button>
    
    <div class="mht-modal-content">
        <img src="" alt="" class="mht-modal-image" id="modalImage">
        <div class="mht-modal-caption" id="modalCaption">
            <h4 id="modalTitle"></h4>
            <p id="modalDescription"></p>
        </div>
    </div>
</div>

<!-- 📅 Events & Programs Section - New Design with 4:5 Thumbnail -->
<section class="mht-events-section" data-aos="fade-up">
    <div class="mht-container">
        <h2 class="mht-section-title"><i class="fas fa-calendar-alt"></i> Events & <span>Programs</span></h2>
        <p class="mht-section-subtitle">Ikuti berbagai event dan program menarik yang kami selenggarakan</p>

        <div class="mht-events-grid">
            <?php
            try {
                $eventsQuery = "SELECT * FROM events WHERE status IN ('upcoming', 'ongoing') ORDER BY 
                                CASE status 
                                    WHEN 'ongoing' THEN 1 
                                    WHEN 'upcoming' THEN 2 
                                END, date_start ASC LIMIT 3";
                $eventsStmt = $pdo->query($eventsQuery);
                
                if ($eventsStmt && $eventsStmt->rowCount() > 0):
                    while ($event = $eventsStmt->fetch(PDO::FETCH_ASSOC)):
                        $title = htmlspecialchars($event['title']);
                        $slug = htmlspecialchars($event['slug']);
                        $description = htmlspecialchars($event['short_description'] ?? $event['description']);
                        $image = htmlspecialchars($event['image'] ?? 'default-event.jpg');
                        $date_start = strtotime($event['date_start']);
                        $date_end = !empty($event['date_end']) ? strtotime($event['date_end']) : $date_start;
                        $date_day = date('d', $date_start);
                        $date_month = date('M', $date_start);
                        $date_year = date('Y', $date_start);
                        $time_start = !empty($event['time_start']) ? date('H:i', strtotime($event['time_start'])) : '00:00';
                        $time_end = !empty($event['time_end']) ? date('H:i', strtotime($event['time_end'])) : '00:00';
                        $time_display = $time_start != $time_end ? "$time_start - $time_end WIB" : "$time_start WIB";
                        $location = htmlspecialchars($event['location']);
                        $capacity = (int)$event['capacity'];
                        $registered = (int)$event['registered'];
                        $status = $event['status'];
                        
                        $statusClass = $status;
                        $statusText = $status == 'ongoing' ? 'Sedang Berlangsung' : ($status == 'upcoming' ? 'Akan Datang' : 'Selesai');
            ?>
            <div class="mht-event-card">
                <div class="mht-event-image-wrapper">
                    <img src="/webmaster/uploads/<?php echo $image; ?>" alt="<?php echo $title; ?>" class="mht-event-image" onerror="this.src='/webmaster/uploads/default-event.jpg'">
                    <span class="mht-event-badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                    <div class="mht-event-overlay">
                        <div class="mht-event-quick-info">
                            <span><i class="far fa-calendar"></i> <?php echo "$date_day $date_month $date_year"; ?></span>
                            <span><i class="far fa-clock"></i> <?php echo $time_display; ?></span>
                        </div>
                    </div>
                </div>
                <div class="mht-event-content">
                    <h3 class="mht-event-title"><?php echo $title; ?></h3>
                    
                    <div class="mht-event-details">
                        <span class="mht-event-detail"><i class="far fa-location-dot"></i> <?php echo $location; ?></span>
                        <?php if ($capacity > 0): ?>
                        <span class="mht-event-detail"><i class="far fa-users"></i> Kuota: <?php echo $registered; ?>/<?php echo $capacity; ?> peserta</span>
                        <?php endif; ?>
                    </div>
                    
                    <p class="mht-event-description"><?php echo strlen($description) > 120 ? substr($description, 0, 120) . '...' : $description; ?></p>
                    
                    <div class="mht-event-footer">
                        <div class="mht-event-stats">
                            <span class="mht-event-stat"><i class="far fa-user"></i> <?php echo $registered; ?> terdaftar</span>
                            <span class="mht-event-stat"><i class="far fa-clock"></i> <?php echo $status == 'ongoing' ? 'Sedang berlangsung' : ($status == 'upcoming' ? 'Segera' : 'Selesai'); ?></span>
                        </div>
                        <a href="/events/<?php echo $slug; ?>" class="mht-btn-event">Detail <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <?php 
                    endwhile;
                endif;
            } catch (PDOException $e) {
                // Silent catch
            }
            ?>
        </div>

        <!-- Empty state jika tidak ada data -->
        <?php
        try {
            $checkQuery = "SELECT COUNT(*) as total FROM events WHERE status IN ('upcoming', 'ongoing')";
            $checkStmt = $pdo->query($checkQuery);
            $total = $checkStmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            if ($total == 0):
        ?>
        <div class="mht-empty-state">
            <div class="mht-empty-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <h3 class="mht-empty-title">Belum Ada Event</h3>
            <p class="mht-empty-text">Saat ini belum ada event yang tersedia. Silakan kembali lagi nanti.</p>
        </div>
        <?php 
            endif;
        } catch (PDOException $e) {
            // Tampilkan empty state jika tabel tidak ada atau error
        ?>
        <div class="mht-empty-state">
            <div class="mht-empty-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <h3 class="mht-empty-title">Belum Ada Event</h3>
            <p class="mht-empty-text">Saat ini belum ada event yang tersedia. Silakan kembali lagi nanti.</p>
        </div>
        <?php
        }
        ?>

        <div class="mht-text-center" style="margin-top: 3rem;">
            <a href="/events" class="mht-btn-view-all">Lihat Semua Event <i class="fas fa-chevron-right"></i></a>
        </div>
    </div>
</section>

<!-- 🚀 Collaboration CTA Section -->
<section class="mht-collab-section" data-aos="fade-up">
    <div class="mht-collab-container">
        <h2 class="mht-collab-title">Tertarik Menjadi Mitra Kami?</h2>
        <p class="mht-collab-text">
            Kami selalu membuka peluang kerjasama untuk menciptakan inovasi bersama. 
            Mari berkolaborasi dan wujudkan ide-ide kreatif Anda!
        </p>
        <a href="/pengajuan-kolaborasi" class="mht-btn-collab">
            <i class="fas fa-handshake"></i> Ajukan Kerjasama
        </a>
    </div>
</section>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- AOS Library -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    // Initialize everything after DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Partner Swiper - Autoplay Only, No Navigation, No Pagination
        const partnerSwiper = new Swiper('.mht-partner-swiper', {
            slidesPerView: 2,
            spaceBetween: 25,
            loop: true,
            speed: 3000,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },
            breakpoints: {
                576: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 35,
                },
                1024: {
                    slidesPerView: 5,
                    spaceBetween: 40,
                },
                1400: {
                    slidesPerView: 6,
                    spaceBetween: 45,
                }
            },
            // No navigation, no pagination
            allowTouchMove: true,
            grabCursor: true,
            effect: 'slide',
            centeredSlides: true,
            centeredSlidesBounds: true
        });

        // Initialize Clients Swiper - Autoplay Only, No Navigation, No Pagination
        const clientsSwiper = new Swiper('.mht-clients-swiper', {
            slidesPerView: 1,
            spaceBetween: 25,
            loop: true,
            speed: 2500,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },
            breakpoints: {
                576: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 35,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 40,
                }
            },
            // No navigation, no pagination
            allowTouchMove: true,
            grabCursor: true,
            effect: 'slide',
            centeredSlides: true,
            centeredSlidesBounds: true
        });

        // Animated Counter for Stats
        const counters = document.querySelectorAll('.mht-stat-number');
        
        const animateCounter = (counter) => {
            const target = parseInt(counter.getAttribute('data-count'));
            const current = parseInt(counter.innerText) || 0;
            const increment = Math.ceil(target / 50);
            
            if (current < target) {
                counter.innerText = Math.min(current + increment, target);
                setTimeout(() => animateCounter(counter), 20);
            } else {
                counter.innerText = target;
            }
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    animateCounter(counter);
                    observer.unobserve(counter);
                }
            });
        }, { threshold: 0.5 });
        
        counters.forEach(counter => {
            observer.observe(counter);
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
            easing: 'ease-in-out'
        });

        // Fix for Swiper on window resize
        window.addEventListener('resize', function() {
            if (partnerSwiper) {
                partnerSwiper.update();
            }
            if (clientsSwiper) {
                clientsSwiper.update();
            }
        });

        // Font Awesome fallback check
        function checkFontAwesome() {
            var testElement = document.createElement('span');
            testElement.className = 'fas';
            testElement.style.display = 'none';
            document.body.appendChild(testElement);
            
            // Get computed style
            var computedStyle = window.getComputedStyle(testElement);
            var fontFamily = computedStyle.getPropertyValue('font-family');
            
            // Check if Font Awesome is loaded
            if (!fontFamily.includes('Font Awesome')) {
                console.log('Font Awesome not loaded, loading fallback...');
                var link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = 'https://use.fontawesome.com/releases/v6.0.0/css/all.css';
                document.head.appendChild(link);
            }
            
            document.body.removeChild(testElement);
        }
        
        // Run check after a short delay
        setTimeout(checkFontAwesome, 100);
    });

    // Gallery Modal Functions
    let currentGalleryIndex = 0;
    let galleryItems = [];

    function openGalleryModal(items, index) {
        galleryItems = items;
        currentGalleryIndex = index;
        const modal = document.getElementById('galleryModal');
        const modalImage = document.getElementById('modalImage');
        const modalTitle = document.getElementById('modalTitle');
        const modalDescription = document.getElementById('modalDescription');
        
        modalImage.src = '/webmaster/uploads/' + items[index].image;
        modalTitle.textContent = items[index].title;
        modalDescription.textContent = items[index].description || items[index].category;
        
        modal.classList.add('active');
        document.body.classList.add('modal-open');
    }

    function closeGalleryModal() {
        const modal = document.getElementById('galleryModal');
        modal.classList.remove('active');
        document.body.classList.remove('modal-open');
    }

    function navigateGallery(direction) {
        if (!galleryItems.length) return;
        
        currentGalleryIndex = (currentGalleryIndex + direction + galleryItems.length) % galleryItems.length;
        const modalImage = document.getElementById('modalImage');
        const modalTitle = document.getElementById('modalTitle');
        const modalDescription = document.getElementById('modalDescription');
        
        modalImage.src = '/webmaster/uploads/' + galleryItems[currentGalleryIndex].image;
        modalTitle.textContent = galleryItems[currentGalleryIndex].title;
        modalDescription.textContent = galleryItems[currentGalleryIndex].description || galleryItems[currentGalleryIndex].category;
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeGalleryModal();
        } else if (e.key === 'ArrowLeft') {
            navigateGallery(-1);
        } else if (e.key === 'ArrowRight') {
            navigateGallery(1);
        }
    });

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('galleryModal');
        if (e.target === modal) {
            closeGalleryModal();
        }
    });
</script>

<!-- Fallback untuk browser tanpa JavaScript -->
<noscript>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">
</noscript>

<?php include 'includes/footer.php'; ?>