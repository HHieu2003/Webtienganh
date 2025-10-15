<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Chính sách đảm bảo đầu ra tại Fighter English - Cam kết điểm IELTS bằng hợp đồng, đúng thời hạn với phương pháp EMPOWER hiện đại">
    <meta name="keywords" content="Fighter English, IELTS, học tiếng Anh, cam kết đầu ra, phương pháp EMPOWER">
    <meta name="author" content="Fighter English">
    <meta property="og:title" content="Chính sách đảm bảo đầu ra - Fighter English">
    <meta property="og:description" content="Cam kết điểm IELTS bằng hợp đồng với phương pháp học hiện đại">
    <meta property="og:type" content="website">
    <title>Chính sách đảm bảo đầu ra - Fighter English</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<style>
    /* ==================== RESET & BASE ==================== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    /* Colors */
    --primary-color: #6366f1;
    --primary-dark: #4f46e5;
    --primary-light: #818cf8;
    --secondary-color: #07e672ff;
    --secondary-dark: #db2777;
    --accent-color: #f59e0b;
    
    --text-dark: #1f2937;
    --text-gray: #6b7280;
    --text-light: #9ca3af;
    
    --bg-white: #ffffff;
    --bg-light: #f9fafb;
    --bg-gray: #f3f4f6;
    
    --gradient-primary: linear-gradient(135deg, #1ad45eff 0%, #4ba276ff 100%);
    --gradient-secondary: linear-gradient(135deg, #33b6c2ff 0%, #43e37bff 100%);
    --gradient-accent: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    
    /* Shadows */
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    
    /* Transitions */
    --transition-fast: 0.2s ease;
    --transition-base: 0.3s ease;
    --transition-slow: 0.5s ease;
    
    /* Border Radius */
    --radius-sm: 0.375rem;
    --radius-md: 0.5rem;
    --radius-lg: 0.75rem;
    --radius-xl: 1rem;
    --radius-2xl: 1.5rem;
    --radius-full: 9999px;
}

html {
    scroll-behavior: smooth;
    font-size: 16px;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    line-height: 1.6;
    color: var(--text-dark);
    background-color: var(--bg-light);
    overflow-x: hidden;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

img {
    max-width: 100%;
    height: auto;
    display: block;
}

a {
    text-decoration: none;
    color: inherit;
    transition: var(--transition-base);
}

ul {
    list-style: none;
}

/* ==================== LOADING SCREEN ==================== */
#loading-screen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--gradient-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    transition: opacity 0.5s ease, visibility 0.5s ease;
}

#loading-screen.hidden {
    opacity: 0;
    visibility: hidden;
}

.loader {
    text-align: center;
    color: white;
}

.spinner {
    width: 60px;
    height: 60px;
    border: 4px solid rgba(255, 255, 255, 0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 20px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.loader p {
    font-size: 18px;
    font-weight: 500;
}

.btn-contact {
    background: var(--gradient-primary);
    color: white;
    padding: 0.625rem 1.5rem;
    border-radius: var(--radius-full);
    font-weight: 600;
}

.btn-contact::after {
    display: none;
}

.btn-contact:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.mobile-menu-toggle {
    display: none;
    flex-direction: column;
    gap: 5px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 5px;
}

.mobile-menu-toggle span {
    width: 25px;
    height: 3px;
    background: var(--primary-color);
    border-radius: var(--radius-full);
    transition: var(--transition-base);
}

.mobile-menu-toggle.active span:nth-child(1) {
    transform: rotate(45deg) translate(8px, 8px);
}

.mobile-menu-toggle.active span:nth-child(2) {
    opacity: 0;
}

.mobile-menu-toggle.active span:nth-child(3) {
    transform: rotate(-45deg) translate(7px, -7px);
}

/* ==================== BREADCRUMB ==================== */
.breadcrumb {
    background: var(--bg-gray);
    padding: 1rem 0;
    font-size: 14px;
    color: var(--text-gray);
}

.breadcrumb a {
    color: var(--primary-color);
    transition: var(--transition-fast);
}

.breadcrumb a:hover {
    text-decoration: underline;
}

.separator {
    margin: 0 0.5rem;
}

.current {
    color: var(--text-dark);
    font-weight: 500;
}

/* ==================== HERO SECTION ==================== */
.hero {
    position: relative;
    background: var(--gradient-primary);
    color: white;
    padding: 9px 0 80px;
    overflow: hidden;
    min-height: 400px;
    display: flex;
    align-items: center;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><path fill="rgba(255,255,255,0.05)" d="M0,150 Q300,50 600,150 T1200,150 L1200,600 L0,600 Z"/></svg>') no-repeat bottom;
    background-size: cover;
    opacity: 0.5;
}

.hero-content {
    position: relative;
    z-index: 2;
    max-width: 800px;
    animation: fadeInUp 0.8s ease;
}

.hero-badge {
    display: inline-block;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    padding: 0.5rem 1.25rem;
    border-radius: var(--radius-full);
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 1.5rem;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.main-title {
    font-size: 52px;
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 1.5rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.subtitle {
    font-size: 20px;
    opacity: 0.95;
    margin-bottom: 2.5rem;
    line-height: 1.7;
}

.hero-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 2rem;
    border-radius: var(--radius-full);
    font-weight: 600;
    font-size: 16px;
    transition: all var(--transition-base);
    cursor: pointer;
    border: 2px solid transparent;
}

.btn-primary {
    background: white;
    color: var(--primary-color);
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-xl);
}

.btn-secondary {
    background: transparent;
    color: white;
    border-color: white;
}

.btn-secondary:hover {
    background: white;
    color: var(--primary-color);
}

/* Hero Decorations */
.hero-decoration {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 1;
}

.floating-shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
}

.shape-1 {
    width: 300px;
    height: 300px;
    top: -100px;
    right: -50px;
    animation: float 8s ease-in-out infinite;
}

.shape-2 {
    width: 200px;
    height: 200px;
    bottom: -50px;
    left: 10%;
    animation: float 6s ease-in-out infinite 2s;
}

.shape-3 {
    width: 150px;
    height: 150px;
    top: 50%;
    right: 20%;
    animation: float 7s ease-in-out infinite 1s;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0) rotate(0deg);
    }
    50% {
        transform: translateY(-30px) rotate(180deg);
    }
}

/* Scroll Indicator */
.scroll-indicator {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    text-align: center;
    z-index: 2;
    animation: bounce 2s infinite;
}

.mouse {
    width: 24px;
    height: 40px;
    border: 2px solid white;
    border-radius: 12px;
    position: relative;
    margin: 0 auto 10px;
}

.wheel {
    width: 4px;
    height: 8px;
    background: white;
    border-radius: 2px;
    position: absolute;
    top: 8px;
    left: 50%;
    transform: translateX(-50%);
    animation: scroll 1.5s infinite;
}

@keyframes scroll {
    0% {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
    100% {
        opacity: 0;
        transform: translateX(-50%) translateY(12px);
    }
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateX(-50%) translateY(0);
    }
    40% {
        transform: translateX(-50%) translateY(-10px);
    }
    60% {
        transform: translateX(-50%) translateY(-5px);
    }
}

.scroll-indicator p {
    font-size: 12px;
    opacity: 0.8;
}

/* ==================== SECTION COMMON STYLES ==================== */
section {
    padding: 20px 0;
}

.section-intro {
    text-align: center;
    margin-bottom: 60px;
}

.section-title {
    font-size: 42px;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 1rem;
    position: relative;
    display: inline-block;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: var(--gradient-primary);
    border-radius: var(--radius-full);
}

.section-description {
    font-size: 18px;
    color: var(--text-gray);
    max-width: 600px;
    margin: 0 auto;
}

.section-badge {
    display: inline-block;
    background: var(--gradient-primary);
    color: white;
    padding: 0.5rem 1.25rem;
    border-radius: var(--radius-full);
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 1rem;
}

/* ==================== KEY FACTORS ==================== */
.key-factors {
    background: var(--bg-white);
}

.factors-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.factor-card {
    background: var(--gradient-primary);
    color: white;
    padding: 3rem 2rem;
    border-radius: var(--radius-2xl);
    text-align: center;
    transition: all var(--transition-base);
    box-shadow: var(--shadow-lg);
    position: relative;
    overflow: hidden;
}

.factor-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    transform: rotate(45deg);
    transition: var(--transition-slow);
}

.factor-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: var(--shadow-2xl);
}

.factor-card:hover::before {
    transform: rotate(45deg) scale(1.5);
}

.factor-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: var(--radius-xl);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    position: relative;
    z-index: 1;
}

.factor-icon svg {
    width: 40px;
    height: 40px;
    stroke-width: 2.5;
}

.factor-card h3 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 1rem;
    position: relative;
    z-index: 1;
}

.factor-card p {
    font-size: 16px;
    opacity: 0.95;
    position: relative;
    z-index: 1;
}

/* ==================== COMMITMENTS ==================== */
.commitments {
    background: var(--bg-light);
}

.commitment-item {
    display: flex;
    gap: 2.5rem;
    align-items: flex-start;
    margin-bottom: 3rem;
    background: var(--bg-white);
    padding: 2rem;
    border-radius: var(--radius-2xl);
    box-shadow: var(--shadow-md);
    transition: all var(--transition-base);
    opacity: 0;
    transform: translateX(-50px);
}

.commitment-item.animate-in {
    opacity: 1;
    transform: translateX(0);
}

.commitment-item:hover {
    box-shadow: var(--shadow-xl);
    transform: translateX(10px);
}

.commitment-badge {
    flex-shrink: 0;
}

.commitment-number {
    width: 80px;
    height: 80px;
    background: var(--gradient-primary);
    color: white;
    border-radius: var(--radius-xl);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    font-weight: 800;
    box-shadow: var(--shadow-lg);
}

.commitment-content h2 {
    color: var(--primary-color);
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 1rem;
}

.commitment-content p {
    font-size: 17px;
    color: var(--text-gray);
    line-height: 1.8;
    margin-bottom: 1.5rem;
}

.commitment-features {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.commitment-features li {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 15px;
    color: var(--text-gray);
}

.commitment-features svg {
    width: 20px;
    height: 20px;
    color: var(--primary-color);
    flex-shrink: 0;
}

/* ==================== FEATURES ==================== */
.features {
    background: var(--bg-white);
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
}

.feature-item {
    background: var(--bg-light);
    padding: 2rem;
    border-radius: var(--radius-xl);
    border-left: 4px solid var(--primary-color);
    transition: all var(--transition-base);
    opacity: 0;
    transform: translateY(30px);
}

.feature-item.animate-in {
    opacity: 1;
    transform: translateY(0);
}

.feature-item:hover {
    background: var(--gradient-primary);
    color: white;
    transform: translateY(-5px);
    box-shadow: var(--shadow-xl);
}

.feature-icon-wrapper {
    width: 60px;
    height: 60px;
    background: var(--primary-color);
    color: white;
    border-radius: var(--radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    transition: var(--transition-base);
}

.feature-item:hover .feature-icon-wrapper {
    background: white;
    color: var(--primary-color);
}

.feature-icon-wrapper svg {
    width: 30px;
    height: 30px;
}

.feature-item h3 {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 0.75rem;
}

.feature-item p {
    font-size: 15px;
    line-height: 1.7;
    opacity: 0.9;
}

/* ==================== EMPOWER SECTION ==================== */
.empower-section {
    background: var(--gradient-primary);
    color: white;
    position: relative;
    overflow: hidden;
}

.empower-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.gradient-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.3;
    animation: floatOrb 10s ease-in-out infinite;
}

.orb-1 {
    width: 400px;
    height: 400px;
    background: #f093fb;
    top: -100px;
    right: -100px;
    animation-delay: 0s;
}

.orb-2 {
    width: 300px;
    height: 300px;
    background: #4facfe;
    bottom: -100px;
    left: -100px;
    animation-delay: 2s;
}

.orb-3 {
    width: 250px;
    height: 250px;
    background: #f5576c;
    top: 50%;
    left: 50%;
    animation-delay: 4s;
}

@keyframes floatOrb {
    0%, 100% {
        transform: translate(0, 0);
    }
    50% {
        transform: translate(50px, 50px);
    }
}

.section-header {
    text-align: center;
    margin-bottom: 60px;
    position: relative;
    z-index: 1;
}

.section-header h2 {
    font-size: 42px;
    font-weight: 800;
    margin-bottom: 1rem;
}

.tagline {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 2rem;
    opacity: 0.95;
}

.method-title {
    font-size: 32px;
    font-weight: 800;
    letter-spacing: 3px;
    margin-bottom: 1rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.method-desc {
    font-size: 18px;
    opacity: 0.9;
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.7;
}

.empower-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    position: relative;
    z-index: 1;
}

.empower-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    padding: 2.5rem;
    border-radius: var(--radius-2xl);
    border: 2px solid rgba(255, 255, 255, 0.2);
    transition: all var(--transition-base);
    opacity: 0;
    transform: rotateY(-90deg);
}

.empower-card.animate-in {
    opacity: 1;
    transform: rotateY(0);
}

.empower-card:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.empower-letter {
    width: 70px;
    height: 70px;
    background: white;
    color: var(--primary-color);
    border-radius: var(--radius-xl);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    font-weight: 800;
    margin-bottom: 1.5rem;
    box-shadow: var(--shadow-lg);
}

.empower-letter.secondary {
    background: var(--gradient-secondary);
    color: white;
}

.empower-card h4 {
    font-size: 26px;
    font-weight: 700;
    margin-bottom: 1rem;
}

.empower-divider {
    width: 60px;
    height: 3px;
    background: white;
    margin-bottom: 1rem;
    border-radius: var(--radius-full);
}

.empower-card p {
    font-size: 16px;
    line-height: 1.7;
    opacity: 0.95;
}

/* ==================== STATS SECTION ==================== */
.stats-section {
    background: var(--bg-white);
    padding: 60px 0;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 3rem;
    text-align: center;
}

.stat-item {
    position: relative;
}

.stat-number {
    font-size: 56px;
    font-weight: 800;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    display: inline-block;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-suffix {
    font-size: 32px;
    font-weight: 700;
    color: var(--primary-color);
    display: inline-block;
    margin-left: 5px;
}

.stat-label {
    font-size: 18px;
    color: var(--text-gray);
    font-weight: 600;
}

/* ==================== LOCATIONS ==================== */
.locations {
    background: var(--bg-light);
}

.locations-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
}

.location-card {
    background: var(--gradient-secondary);
    color: white;
    padding: 2.5rem;
    border-radius: var(--radius-2xl);
    text-align: center;
    box-shadow: var(--shadow-lg);
    transition: all var(--transition-base);
    opacity: 0;
    transform: scale(0.9);
}

.location-card.animate-in {
    opacity: 1;
    transform: scale(1);
}

.location-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: var(--shadow-2xl);
}

.location-icon {
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: var(--radius-xl);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.location-icon svg {
    width: 35px;
    height: 35px;
}

.location-card h5 {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 1rem;
}

.location-card p {
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 1.5rem;
    opacity: 0.95;
}

.location-contact {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: white;
    color: var(--secondary-color);
    padding: 0.75rem 1.5rem;
    border-radius: var(--radius-full);
    font-weight: 600;
    transition: var(--transition-base);
}

.location-contact svg {
    width: 18px;
    height: 18px;
}

.location-contact:hover {
    transform: scale(1.05);
    box-shadow: var(--shadow-lg);
}

/* ==================== CONTACT FORM ==================== */
.contact-section {
    background: var(--bg-white);
}

.contact-wrapper {
    display: grid;
    grid-template-columns: 1fr 1.5fr;
    gap: 4rem;
    align-items: start;
}

.contact-info h2 {
    font-size: 36px;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 1rem;
}

.contact-info > p {
    font-size: 17px;
    color: var(--text-gray);
    line-height: 1.7;
    margin-bottom: 2rem;
}

.contact-details {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.contact-detail-item {
    display: flex;
    gap: 1rem;
    align-items: flex-start;
}

.contact-detail-item svg {
    width: 24px;
    height: 24px;
    color: var(--primary-color);
    flex-shrink: 0;
    margin-top: 5px;
}

.contact-detail-item h4 {
    font-size: 16px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
}

.contact-detail-item p {
    font-size: 15px;
    color: var(--text-gray);
}

.contact-form {
    background: var(--bg-light);
    padding: 3rem;
    border-radius: var(--radius-2xl);
    box-shadow: var(--shadow-lg);
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

.form-group {
    position: relative;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 1rem;
    border: 2px solid var(--bg-gray);
    border-radius: var(--radius-lg);
    font-size: 15px;
    font-family: inherit;
    transition: var(--transition-base);
    background: var(--bg-white);
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary-color);
}

.form-group label {
    position: absolute;
    top: 1rem;
    left: 1rem;
    font-size: 15px;
    color: var(--text-gray);
    pointer-events: none;
    transition: var(--transition-base);
}

.form-group input:focus + label,
.form-group input:not(:placeholder-shown) + label,
.form-group select:focus + label,
.form-group select:valid + label,
.form-group textarea:focus + label,
.form-group textarea:not(:placeholder-shown) + label {
    top: -10px;
    left: 0.75rem;
    font-size: 12px;
    color: var(--primary-color);
    background: var(--bg-light);
    padding: 0 0.5rem;
}

.form-group textarea {
    resize: vertical;
    min-height: 120px;
}

.btn-submit {
    grid-column: 1 / -1;
    background: var(--gradient-primary);
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: var(--radius-lg);
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: var(--transition-base);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-xl);
}

.btn-submit svg {
    width: 20px;
    height: 20px;
    transition: var(--transition-base);
}

.btn-submit:hover svg {
    transform: translateX(5px);
}


.social-links {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
}

.social-links a {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: var(--radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition-base);
}

.social-links a:hover {
    background: var(--primary-color);
    transform: translateY(-3px);
}

.social-links svg {
    width: 20px;
    height: 20px;
}

.footer-bottom {
    padding-top: 2rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    text-align: center;
}

.footer-bottom p {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.6);
}

/* ==================== SCROLL TO TOP ==================== */
.scroll-to-top {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    background: var(--gradient-primary);
    color: white;
    border: none;
    border-radius: var(--radius-full);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    opacity: 0;
    visibility: hidden;
    transition: all var(--transition-base);
    box-shadow: var(--shadow-xl);
    z-index: 99;
}

.scroll-to-top.visible {
    opacity: 1;
    visibility: visible;
}

.scroll-to-top:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-2xl);
}

.scroll-to-top svg {
    width: 24px;
    height: 24px;
}

/* ==================== ANIMATIONS ==================== */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 1024px) {
    .contact-wrapper {
        grid-template-columns: 1fr;
        gap: 3rem;
    }
   
}

@media (max-width: 768px) {
    .mobile-menu-toggle {
        display: flex;
    }
    
    .nav-menu {
        position: fixed;
        top: 70px;
        left: -100%;
        width: 100%;
        height: calc(100vh - 70px);
        background: var(--bg-white);
        flex-direction: column;
        align-items: flex-start;
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        transition: left var(--transition-base);
    }
    
    .nav-menu.active {
        left: 0;
    }
    
    .nav-link {
        width: 100%;
        padding: 1rem 0;
        border-bottom: 1px solid var(--bg-gray);
    }
    
    .btn-contact {
        width: 100%;
        text-align: center;
        justify-content: center;
    }
    
    .main-title {
        font-size: 36px;
    }
    
    .subtitle {
        font-size: 18px;
    }
    
    .section-title {
        font-size: 32px;
    }
    
    .hero-buttons {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
    
    .commitment-item {
        flex-direction: column;
        text-align: center;
        padding: 2rem;
    }
    
    .commitment-badge {
        margin: 0 auto 1.5rem;
    }
    
    .contact-form {
        grid-template-columns: 1fr;
        padding: 2rem;
    }
    
    
    .stat-number {
        font-size: 42px;
    }
}

@media (max-width: 480px) {
    .main-title {
        font-size: 28px;
    }
    
    .section-title {
        font-size: 26px;
    }
    
    .factors-grid,
    .features-grid,
    .empower-grid,
    .locations-grid {
        grid-template-columns: 1fr;
    }
    
    .hero {
        padding: 80px 0 60px;
    }
    
    section {
        padding: 60px 0;
    }
}

/* ==================== PRINT STYLES ==================== */
@media print {
    .header,
    .breadcrumb,
    .hero-buttons,
    .contact-section,
    .scroll-to-top,
    .footer {
        display: none;
    }
    
    body {
        background: white;
    }
    
    * {
        box-shadow: none !important;
    }
}

</style>
<body>
    <!-- Loading Screen -->
    <div id="loading-screen">
        <div class="loader">
            <div class="spinner"></div>
            <p>Đang tải...</p>
        </div>
    </div>

 
    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <span class="hero-badge">Cam kết chất lượng</span>
                <h1 class="main-title">Chính sách đảm bảo đầu ra tại Fighter</h1>
                <p class="subtitle">Đối với Fighter English, 3 yếu tố quan trọng luôn được đặt lên hàng đầu</p>
                <div class="hero-buttons">
                    <a href="#commitments" class="btn btn-primary">Khám phá ngay</a>
                    <a href="#contact" class="btn btn-secondary">Đăng ký tư vấn</a>
                </div>
            </div>
            <div class="hero-decoration">
                <div class="floating-shape shape-1"></div>
                <div class="floating-shape shape-2"></div>
                <div class="floating-shape shape-3"></div>
            </div>
        </div>
        <div class="scroll-indicator">
            <div class="mouse">
                <div class="wheel"></div>
            </div>
            <p>Cuộn xuống</p>
        </div>
    </section>

    <!-- Three Key Factors -->
    <section class="key-factors" id="factors">
        <div class="container">
            <div class="section-intro">
                <h2 class="section-title">3 Trụ cột chất lượng</h2>
                <p class="section-description">Những cam kết vững chắc của Fighter với học viên</p>
            </div>
            <div class="factors-grid">
                <div class="factor-card" data-aos="fade-up" data-delay="0">
                    <div class="factor-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3>Đảm bảo điểm số cam kết</h3>
                    <p>Cam kết điểm IELTS bằng hợp đồng pháp lý</p>
                </div>
                <div class="factor-card" data-aos="fade-up" data-delay="100">
                    <div class="factor-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3>Đúng thời hạn</h3>
                    <p>100% tuân thủ lộ trình đã cam kết</p>
                </div>
                <div class="factor-card" data-aos="fade-up" data-delay="200">
                    <div class="factor-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3>Ứng dụng vào thực tế</h3>
                    <p>Học là phải dùng được trong đời sống</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Commitments Section -->
    <section class="commitments" id="commitments">
        <div class="container">
            <div class="section-intro">
                <h2 class="section-title">Cam kết của Fighter</h2>
                <p class="section-description">Những đảm bảo cụ thể và rõ ràng cho học viên</p>
            </div>
            
            <div class="commitment-item" data-aos="slide-right">
                <div class="commitment-badge">
                    <div class="commitment-number">01</div>
                </div>
                <div class="commitment-content">
                    <h2>Cam kết điểm số IELTS bằng hợp đồng</h2>
                    <p><strong>Điểm số IELTS tại Fighter được cam kết bằng hợp đồng</strong>, theo đúng lộ trình và lượng kiến thức học viên đã học. Mọi rủi ro trong quá trình học và kết quả thi thực tế của học viên đều được Fighter dự trù và quản trị, can thiệp kịp thời giúp học viên đạt kết quả mong muốn.</p>
                    <ul class="commitment-features">
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Hợp đồng pháp lý rõ ràng
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Theo dõi tiến độ liên tục
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Can thiệp kịp thời khi cần
                        </li>
                    </ul>
                </div>
            </div>

            <div class="commitment-item" data-aos="slide-left">
                <div class="commitment-badge">
                    <div class="commitment-number">02</div>
                </div>
                <div class="commitment-content">
                    <h2>Cam kết đúng thời hạn</h2>
                    <p>Fighter <strong>đảm bảo 100% thời gian cam kết ban đầu</strong>, không kéo dài thời lượng, đảm bảo học viên theo kịp lộ trình để xét tuyển đại học, xét tốt nghiệp, du học, làm hồ sơ cao học, định cư nước ngoài, … như mong muốn.</p>
                    <ul class="commitment-features">
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Lộ trình rõ ràng từ đầu
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Không kéo dài thời gian
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Đáp ứng deadline của bạn
                        </li>
                    </ul>
                </div>
            </div>

            <div class="commitment-item" data-aos="slide-right">
                <div class="commitment-badge">
                    <div class="commitment-number">03</div>
                </div>
                <div class="commitment-content">
                    <h2>Cam kết ứng dụng được ngôn ngữ trong thực tế</h2>
                    <p>Với phương châm <strong>"Học là phải dùng được"</strong>, kết hợp với phương pháp E.M.P.O.W.E.R, Fighter luôn hướng tới học viên có thể ứng dụng kiến thức ngôn ngữ trong quá trình học tập, làm việc và trong đời sống. Khác với việc "cam kết điểm số" bằng cách chỉ tập trung dạy mẹo làm bài, Fighter đề cao năng lực sử dụng ngôn ngữ trong và ngoài lớp học.</p>
                    <ul class="commitment-features">
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Học để sử dụng thực tế
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Không chỉ học mẹo thi
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Phương pháp EMPOWER hiện đại
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="section-intro">
                <h2 class="section-title">Điểm nổi bật</h2>
                <p class="section-description">Những yếu tố tạo nên sự khác biệt của Fighter</p>
            </div>
            <div class="features-grid">
                <div class="feature-item" data-aos="zoom-in">
                    <div class="feature-icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <h3>Đầu vào chính xác</h3>
                    <p>Đầu vào luôn được xác định chính xác để xây dựng lộ trình phù hợp</p>
                </div>
                <div class="feature-item" data-aos="zoom-in" data-delay="100">
                    <div class="feature-icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3>Kho bài tập LMS</h3>
                    <p>Kho bài tập thực hành và luyện đề phong phú trên LMS Fighter</p>
                </div>
                <div class="feature-item" data-aos="zoom-in" data-delay="200">
                    <div class="feature-icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3>Kiểm tra định kỳ</h3>
                    <p>Kiểm tra giữa khoá, cuối kỳ để theo sát năng lực học viên</p>
                </div>
                <div class="feature-item" data-aos="zoom-in">
                    <div class="feature-icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3>Đội ngũ hỗ trợ</h3>
                    <p>Giáo viên, trợ giảng luôn sẵn sàng hỗ trợ mọi thắc mắc</p>
                </div>
                <div class="feature-item" data-aos="zoom-in" data-delay="100">
                    <div class="feature-icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3>Phương pháp đặc biệt</h3>
                    <p><strong>Phát huy điểm mạnh – cải thiện điểm yếu</strong> của từng học viên</p>
                </div>
            </div>
        </div>
    </section>

    <!-- EMPOWER Method -->
    <section class="empower-section" id="method">
        <div class="empower-background">
            <div class="gradient-orb orb-1"></div>
            <div class="gradient-orb orb-2"></div>
            <div class="gradient-orb orb-3"></div>
        </div>
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Phương pháp độc quyền</span>
                <h2>Phương pháp giảng dạy tại Fighter</h2>
                <p class="tagline">Đúng phương pháp – Trúng mục tiêu</p>
                <h3 class="method-title">PHƯƠNG PHÁP HỌC HIỆN ĐẠI E.M.P.O.W.E.R</h3>
                <p class="method-desc">Trong tất cả các khóa học, học viên luôn là trung tâm,<br>là ưu tiên hàng đầu trong mọi bài dạy.</p>
            </div>

            <div class="empower-grid">
                <div class="empower-card" data-aos="flip-left">
                    <div class="empower-letter">E</div>
                    <h4>Engage</h4>
                    <div class="empower-divider"></div>
                    <p>Kích thích sự tò mò thông qua <strong>Guided Discovery</strong> và phương pháp học <strong>tương tác</strong>.</p>
                </div>

                <div class="empower-card" data-aos="flip-left" data-delay="50">
                    <div class="empower-letter">M</div>
                    <h4>Motivate</h4>
                    <div class="empower-divider"></div>
                    <p>Thúc đẩy <strong>tính tự chủ</strong> của người học bằng hướng dẫn có cấu trúc.</p>
                </div>

                <div class="empower-card" data-aos="flip-left" data-delay="100">
                    <div class="empower-letter">P</div>
                    <h4>Practice</h4>
                    <div class="empower-divider"></div>
                    <p>Củng cố kiến thức qua <strong>luyện tập nhiều lần</strong> và <strong>tự chỉnh sửa</strong>.</p>
                </div>

                <div class="empower-card" data-aos="flip-left" data-delay="150">
                    <div class="empower-letter">O</div>
                    <h4>Optimize</h4>
                    <div class="empower-divider"></div>
                    <p>Tối ưu hóa hiệu quả học tập với <strong>công nghệ và thực hành</strong> (LMS, phòng máy).</p>
                </div>

                <div class="empower-card" data-aos="flip-left" data-delay="200">
                    <div class="empower-letter">W</div>
                    <h4>Widen</h4>
                    <div class="empower-divider"></div>
                    <p>Mở rộng tư duy với <strong>học tập qua khám phá và phản biện.</strong></p>
                </div>

                <div class="empower-card" data-aos="flip-left" data-delay="250">
                    <div class="empower-letter secondary">E</div>
                    <h4>Evaluate</h4>
                    <div class="empower-divider"></div>
                    <p>Tăng cường <strong>tự đánh giá, phản hồi nhóm</strong>, và <strong>nhận xét chung.</strong></p>
                </div>

                <div class="empower-card" data-aos="flip-left" data-delay="300">
                    <div class="empower-letter">R</div>
                    <h4>Reflect</h4>
                    <div class="empower-divider"></div>
                    <p>Giúp học viên <strong>phân tích tiến bộ</strong> và cải thiện kỹ năng liên tục.</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Locations Section -->
    <section class="locations" id="locations">
        <div class="container">
            <div class="section-intro">
                <h2 class="section-title">Hệ thống cơ sở</h2>
                <p class="section-description">Gặp chúng mình ở Cơ sở Fighter gần bạn nhất nhé!</p>
            </div>
            <div class="locations-grid">
                <div class="location-card" data-aos="fade-up">
                    <div class="location-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h5>Quận Phú Nhuận</h5>
                    <p>70 Hoa Cúc, P. 7, Phú Nhuận</p>
                    <a href="tel:02873008898" class="location-contact">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        Gọi ngay
                    </a>
                </div>
                <div class="location-card" data-aos="fade-up" data-delay="100">
                    <div class="location-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h5>Quận Gò Vấp</h5>
                    <p>664 Lê Quang Định, P. 1, Gò Vấp</p>
                    <a href="tel:02873008898" class="location-contact">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        Gọi ngay
                    </a>
                </div>
                <div class="location-card" data-aos="fade-up" data-delay="200">
                    <div class="location-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h5>Quận 10</h5>
                    <p>769 Lê Hồng Phong, P. 12, Q. 10</p>
                    <a href="tel:02873008898" class="location-contact">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        Gọi ngay
                    </a>
                </div>
              
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-section" id="contact">
     <?php include('form-dk.php'); ?>
        
    </section>



    <!-- Scroll to Top Button -->
    <button id="scroll-to-top" class="scroll-to-top" aria-label="Scroll to top">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

    <script src="script.js"></script>
</body>
</html>
<script>
    // ==================== INITIALIZATION ====================
document.addEventListener('DOMContentLoaded', () => {
    initLoader();
    initNavigation();
    initScrollEffects();
    initAnimations();
    initForm();
    initCounters();
});

// ==================== LOADER ====================
function initLoader() {
    const loader = document.getElementById('loading-screen');
    
    window.addEventListener('load', () => {
        setTimeout(() => {
            loader.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 500);
    });
}

// ==================== NAVIGATION ====================
function initNavigation() {
    const header = document.getElementById('header');
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const navMenu = document.getElementById('nav-menu');
    const navLinks = document.querySelectorAll('.nav-link');
    
    // Sticky header on scroll
    let lastScroll = 0;
    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
        
        lastScroll = currentScroll;
    });
    
    // Mobile menu toggle
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', () => {
            mobileMenuToggle.classList.toggle('active');
            navMenu.classList.toggle('active');
            document.body.style.overflow = navMenu.classList.contains('active') ? 'hidden' : 'auto';
        });
    }
    
    // Smooth scroll & active link
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            
            if (href.startsWith('#')) {
                e.preventDefault();
                const target = document.querySelector(href);
                
                if (target) {
                    const offset = 80;
                    const targetPosition = target.offsetTop - offset;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu
                    if (navMenu.classList.contains('active')) {
                        mobileMenuToggle.classList.remove('active');
                        navMenu.classList.remove('active');
                        document.body.style.overflow = 'auto';
                    }
                    
                    // Update active link
                    navLinks.forEach(l => l.classList.remove('active'));
                    link.classList.add('active');
                }
            }
        });
    });
    
    // Update active link on scroll
    const sections = document.querySelectorAll('section[id]');
    window.addEventListener('scroll', () => {
        const scrollPos = window.pageYOffset + 150;
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.offsetHeight;
            const sectionId = section.getAttribute('id');
            
            if (scrollPos >= sectionTop && scrollPos < sectionTop + sectionHeight) {
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${sectionId}`) {
                        link.classList.add('active');
                    }
                });
            }
        });
    });
}

// ==================== SCROLL EFFECTS ====================
function initScrollEffects() {
    // Scroll to top button
    const scrollToTopBtn = document.getElementById('scroll-to-top');
    
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            scrollToTopBtn.classList.add('visible');
        } else {
            scrollToTopBtn.classList.remove('visible');
        }
    });
    
    scrollToTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // Parallax effect for hero
    const hero = document.querySelector('.hero');
    if (hero) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            if (scrolled < window.innerHeight) {
                hero.style.transform = `translateY(${scrolled * 0.4}px)`;
            }
        });
    }
}

// ==================== ANIMATIONS ====================
function initAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                const delay = entry.target.dataset.delay || 0;
                entry.target.style.animationDelay = `${delay}ms`;
            }
        });
    }, observerOptions);
    
    // Animate commitment items
    const commitmentItems = document.querySelectorAll('.commitment-item');
    commitmentItems.forEach((item, index) => {
        item.style.transition = `all 0.6s ease ${index * 0.2}s`;
        observer.observe(item);
    });
    
    // Animate EMPOWER cards
    const empowerCards = document.querySelectorAll('.empower-card');
    empowerCards.forEach((card, index) => {
        card.style.transition = `all 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });
    
    // Animate location cards
    const locationCards = document.querySelectorAll('.location-card');
    locationCards.forEach((card, index) => {
        card.style.transition = `all 0.5s ease ${index * 0.15}s`;
        observer.observe(card);
    });
    
    // Animate feature items
    const featureItems = document.querySelectorAll('.feature-item');
    featureItems.forEach((item, index) => {
        item.style.transition = `all 0.5s ease ${index * 0.1}s`;
        observer.observe(item);
    });
    
    // Animate factor cards
    const factorCards = document.querySelectorAll('.factor-card');
    factorCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 200);
    });
}

// ==================== COUNTERS ====================
function initCounters() {
    const counters = document.querySelectorAll('.stat-number');
    let hasRun = false;
    
    const runCounters = () => {
        if (hasRun) return;
        hasRun = true;
        
        counters.forEach(counter => {
            const target = parseInt(counter.dataset.target);
            const duration = 2000;
            const increment = target / (duration / 16);
            let current = 0;
            
            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    counter.textContent = Math.floor(current);
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target;
                }
            };
            
            updateCounter();
        });
    };
    
    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    runCounters();
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(statsSection);
    }
}

// ==================== FORM HANDLING ====================
function initForm() {
    const form = document.getElementById('contact-form');
    
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            
            // Show loading state
            const submitBtn = form.querySelector('.btn-submit');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span>Đang gửi...</span>';
            submitBtn.disabled = true;
            
            // Simulate form submission (replace with actual API call)
            setTimeout(() => {
                console.log('Form data:', data);
                
                // Show success message
                showNotification('Đăng ký thành công! Chúng tôi sẽ liên hệ với bạn sớm.', 'success');
                
                // Reset form
                form.reset();
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 2000);
        });
        
        // Form validation
        const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
        inputs.forEach(input => {
            input.addEventListener('invalid', (e) => {
                e.preventDefault();
                input.classList.add('error');
                showNotification('Vui lòng điền đầy đủ thông tin', 'error');
            });
            
            input.addEventListener('input', () => {
                input.classList.remove('error');
            });
        });
    }
}

// ==================== NOTIFICATIONS ====================
function showNotification(message, type = 'info') {
    // Remove existing notification
    const existing = document.querySelector('.notification');
    if (existing) {
        existing.remove();
    }
    
    // Create notification
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.75rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        animation: slideInRight 0.3s ease;
        max-width: 400px;
    `;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

// Add notification animations to CSS dynamically
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes slideOutRight {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100px);
        }
    }
    
    .form-group input.error,
    .form-group select.error,
    .form-group textarea.error {
        border-color: #ef4444;
    }
`;
document.head.appendChild(style);

// ==================== UTILITY FUNCTIONS ====================
// Throttle function for scroll events
function throttle(func, delay) {
    let timeoutId;
    let lastExecTime = 0;
    
    return function(...args) {
        const currentTime = Date.now();
        const timeSinceLastExec = currentTime - lastExecTime;
        
        clearTimeout(timeoutId);
        
        if (timeSinceLastExec > delay) {
            func.apply(this, args);
            lastExecTime = currentTime;
        } else {
            timeoutId = setTimeout(() => {
                func.apply(this, args);
                lastExecTime = Date.now();
            }, delay - timeSinceLastExec);
        }
    };
}

// Debounce function for resize events
function debounce(func, delay) {
    let timeoutId;
    
    return function(...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            func.apply(this, args);
        }, delay);
    };
}

// Handle window resize
window.addEventListener('resize', debounce(() => {
    const navMenu = document.getElementById('nav-menu');
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    
    if (window.innerWidth > 768 && navMenu.classList.contains('active')) {
        navMenu.classList.remove('active');
        mobileMenuToggle.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
}, 250));

// ==================== ACCESSIBILITY ====================
// Keyboard navigation
document.addEventListener('keydown', (e) => {
    // Escape key closes mobile menu
    if (e.key === 'Escape') {
        const navMenu = document.getElementById('nav-menu');
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        
        if (navMenu.classList.contains('active')) {
            navMenu.classList.remove('active');
            mobileMenuToggle.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    }
});

// Focus management
const focusableElements = 'a[href], button, textarea, input, select, [tabindex]:not([tabindex="-1"])';

document.querySelectorAll('button, a').forEach(element => {
    element.addEventListener('focus', function() {
        this.style.outline = '2px solid #6366f1';
        this.style.outlineOffset = '2px';
    });
    
    element.addEventListener('blur', function() {
        this.style.outline = '';
        this.style.outlineOffset = '';
    });
});

// ==================== PERFORMANCE MONITORING ====================
if ('performance' in window) {
    window.addEventListener('load', () => {
        const perfData = window.performance.timing;
        const pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;
        console.log(`⚡ Page loaded in ${pageLoadTime}ms`);
    });
}

// ==================== CONSOLE MESSAGE ====================
console.log('%cFighter English 🎓', 'color: #6366f1; font-size: 24px; font-weight: bold;');
console.log('%cWebsite loaded successfully!', 'color: #10b981; font-size: 14px;');
console.log('%cDeveloped with ❤️ for learning', 'color: #6b7280; font-size: 12px;');

</script>