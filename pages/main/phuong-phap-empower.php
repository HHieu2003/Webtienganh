<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Phương pháp E.M.P.O.W.E.R - Trao quyền & Khai phóng tiềm năng - Fighter English">
    <title>Phương pháp E.M.P.O.W.E.R® - Fighter English</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --primary-color: #0066cc;
        --secondary-color: #ff6b35;
        --accent-color: #ffd700;
        --dark-color: #1a1a2e;
        --light-color: #f8f9fa;
        --white: #ffffff;
        --gray: #6c757d;
        --success: #28a745;
        --danger: #dc3545;
        --info: #17a2b8;
        --gradient-primary: linear-gradient(135deg, #48db96ff 0%, #3a9859ff 100%);
        --gradient-secondary: linear-gradient(135deg, #93f3b5ff 0%, #23c876ff 100%);
        --gradient-success: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 5px 20px rgba(0, 0, 0, 0.12);
        --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.15);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    html {
        scroll-behavior: smooth;
        font-size: 16px;
    }

    body {
        font-family: 'Times New Roman', Times, serif;
        line-height: 1.7;
        color: var(--dark-color);
        background: var(--white);
        overflow-x: hidden;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .btn-nav-contact {
        padding: 0.7rem 1.8rem;
        background: var(--secondary-color);
        color: var(--white) !important;
        border-radius: 50px;
        font-weight: 600;
        transition: var(--transition);
    }

    .btn-nav-contact:hover {
        background: #e55a2b;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
    }

    .hamburger {
        display: none;
        flex-direction: column;
        cursor: pointer;
        gap: 5px;
    }

    .hamburger span {
        width: 28px;
        height: 3px;
        background: var(--dark-color);
        border-radius: 3px;
        transition: var(--transition);
    }

    .hamburger.active span:nth-child(1) {
        transform: rotate(45deg) translate(8px, 8px);
    }

    .hamburger.active span:nth-child(2) {
        opacity: 0;
    }

    .hamburger.active span:nth-child(3) {
        transform: rotate(-45deg) translate(7px, -7px);
    }

    /* ===================================
   Hero Section
   =================================== */
    .hero {
        background: var(--gradient-primary);
        color: var(--white);
        padding: 6rem 0 4rem;
        position: relative;
        overflow: hidden;
        min-height: 90vh;
        display: flex;
        align-items: center;
    }

    .hero-bg-animation {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background:
            radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        animation: pulse 8s ease-in-out infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 0.5;
        }

        50% {
            opacity: 1;
        }
    }

    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 950px;
        margin: 0 auto;
    }

    .empower-logo {
        display: inline-block;
        font-size: 4rem;
        font-weight: 900;
        letter-spacing: 5px;
        background: linear-gradient(45deg, #fff, #ffd700);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: slideInDown 1s ease-out;
    }

    .hero-title {
        font-size: 2.8rem;
        font-weight: 800;
        line-height: 1.2;
        animation: fadeInUp 1s ease-out 0.2s both;
    }

    .hero-description {
        font-size: 1.2rem;
        line-height: 1.8;
        margin-bottom: 2rem;
        opacity: 0.95;
        animation: fadeInUp 1s ease-out 0.4s both;
    }

    .hero-badge-wrapper {
        margin: 2rem 0;
        animation: fadeInUp 1s ease-out 0.6s both;
    }

    .hero-badge {
        display: flex;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .badge-item {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 1rem 2rem;
        border-radius: 50px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .badge-item i {
        font-size: 1.5rem;
    }

    .hero-cta {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        margin-top: 2.5rem;
        animation: fadeInUp 1s ease-out 0.8s both;
    }

    .btn-primary,
    .btn-secondary {
        padding: 1rem 2.5rem;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: var(--white);
        color: var(--primary-color);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    }

    .btn-secondary {
        background: transparent;
        color: var(--white);
        border: 2px solid var(--white);
    }

    .btn-secondary:hover {
        background: var(--white);
        color: var(--primary-color);
    }

    .hero-scroll-indicator {
        position: absolute;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%);
        text-align: center;
        animation: bounce 2s infinite;
    }

    .hero-scroll-indicator span {
        display: block;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    @keyframes bounce {

        0%,
        20%,
        50%,
        80%,
        100% {
            transform: translateX(-50%) translateY(0);
        }

        40% {
            transform: translateX(-50%) translateY(-10px);
        }

        60% {
            transform: translateX(-50%) translateY(-5px);
        }
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===================================
   Section Styles
   =================================== */
    .section-header {
        text-align: center;
        margin-bottom: 4rem;
    }

    .section-tag {
        display: inline-block;
        padding: 0.5rem 1.5rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: var(--white);
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--dark-color);
        margin-bottom: 1.0rem;
        line-height: 1.3;
    }

    .section-description {
        font-size: 1.1rem;
        color: var(--gray);
        max-width: 800px;
        margin: 0 auto;
        line-height: 1.8;
    }

    /* ===================================
   Certified Section
   =================================== */
    .certified {
        padding: 3rem 0;
        background: var(--light-color);
    }

    .certified-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 2rem;
    }

    .certified-card {
        background: var(--white);
        padding: 2.5rem;
        border-radius: 20px;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        text-align: center;
    }

    .certified-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
    }

    .certified-icon {
        width: 80px;
        height: 80px;
        background: var(--gradient-primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .certified-icon i {
        font-size: 2rem;
        color: var(--white);
    }

    .certified-card h3 {
        font-size: 1.5rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .certified-card p {
        font-size: 1rem;
        line-height: 1.7;
        color: var(--gray);
    }

    /* ===================================
   Benefits Section
   =================================== */
    .benefits {
        padding: 3rem 0;
        background: var(--white);
    }

    .comparison-intro {
        text-align: center;
        margin: 3rem 0;
    }

    .comparison-intro h3 {
        font-size: 2rem;
        color: var(--dark-color);
        margin-bottom: 1rem;
    }

    .comparison-intro p {
        font-size: 1.1rem;
        color: var(--gray);
    }

    .comparison-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .comparison-item {
        background: var(--light-color);
        padding: 2rem;
        border-radius: 15px;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        transition: var(--transition);
        border-left: 4px solid transparent;
    }

    .comparison-item:hover {
        border-left-color: var(--primary-color);
        transform: translateX(5px);
        box-shadow: var(--shadow-md);
    }

    .old-method {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        color: var(--danger);
        font-size: 0.95rem;
    }

    .old-method i {
        font-size: 1.2rem;
    }

    .arrow-transform {
        text-align: center;
        color: var(--secondary-color);
    }

    .arrow-transform i {
        font-size: 1.5rem;
    }

    .new-method {
        display: flex;
        align-items: flex-start;
        gap: 0.8rem;
        color: var(--dark-color);
        font-size: 1rem;
        font-weight: 600;
    }

    .new-method i {
        font-size: 1.2rem;
        color: var(--success);
        margin-top: 0.2rem;
    }

    /* ===================================
   Skills Section
   =================================== */
    .skills-section {
        padding: 3rem 0;
        background: var(--light-color);
    }

    .skills-tabs {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 3rem;
    }

    .skill-tab {
        padding: 1rem 2rem;
        background: var(--white);
        border: 2px solid transparent;
        border-radius: 50px;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.8rem;
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray);
    }

    .skill-tab:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
    }

    .skill-tab.active {
        background: var(--gradient-primary);
        color: var(--white);
        border-color: transparent;
    }

    .skill-tab i {
        font-size: 1.3rem;
    }

    .skill-content {
        display: none;
        animation: fadeIn 0.5s ease-out;
    }

    .skill-content.active {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .skill-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .skill-box {
        background: var(--white);
        padding: 2rem;
        border-radius: 15px;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .skill-box:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-5px);
    }

    .skill-box h4 {
        font-size: 1.3rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .skill-box.problem h4 {
        color: var(--danger);
    }

    .skill-box.solution h4 {
        color: var(--primary-color);
    }

    .skill-box.result h4 {
        color: var(--success);
    }

    .skill-box ul {
        list-style: none;
        padding: 0;
    }

    .skill-box li {
        padding: 0.7rem 0 0.7rem 1.8rem;
        position: relative;
        line-height: 1.6;
        font-size: 0.95rem;
    }

    .skill-box li::before {
        content: '•';
        position: absolute;
        left: 0;
        font-size: 1.5rem;
        line-height: 1.4;
    }

    .skill-box.problem li::before {
        color: var(--danger);
    }

    .skill-box.solution li::before {
        color: var(--primary-color);
    }

    .skill-box.result li::before {
        color: var(--success);
    }

    /* ===================================
   Career Section
   =================================== */
    .career-section {
        padding: 3rem 0;
        background: var(--white);
    }

    .career-table-wrapper {
        overflow-x: auto;
        margin-top: 3rem;
        box-shadow: var(--shadow-md);
        border-radius: 15px;
    }

    .career-table {
        width: 100%;
        border-collapse: collapse;
        background: var(--white);
    }

    .career-table thead {
        background: var(--gradient-primary);
        color: var(--white);
    }

    .career-table th {
        padding: 1.5rem;
        text-align: left;
        font-weight: 600;
        font-size: 1.05rem;
    }

    .career-table td {
        padding: 1.5rem;
        border-bottom: 1px solid var(--light-color);
        font-size: 0.95rem;
        line-height: 1.7;
        vertical-align: top;
    }

    .career-table tbody tr:hover {
        background: var(--light-color);
    }

    .career-table .tag {
        display: inline-block;
        padding: 0.3rem 0.8rem;
        background: rgba(102, 126, 234, 0.1);
        color: var(--primary-color);
        border-radius: 20px;
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }

    /* ===================================
   Class Flow Section
   =================================== */
    .class-flow {
        padding: 3rem 0;
        background: var(--light-color);
    }

    .flow-steps {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.3rem;
        margin-top: 3rem;
    }

    .flow-step {
        background: var(--white);
        padding: 1.0rem;
        border-radius: 15px;
        box-shadow: var(--shadow-sm);
        text-align: center;
        transition: var(--transition);
    }

    .flow-step:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-md);
    }

    .step-number {
        width: 50px;
        height: 50px;
        background: var(--gradient-primary);
        color: var(--white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: bold;
        margin: 0 auto 1rem;
    }

    .step-content h4 {
        font-size: 1.2rem;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .step-content p {
        font-size: 0.9rem;
        color: var(--gray);
    }

    .flow-arrow {
        font-size: 2rem;
        color: var(--secondary-color);
    }

    /* ===================================
   Success Section
   =================================== */
    .success-section {
        padding: 3rem 0;
        background: var(--gradient-secondary);
        color: var(--white);
    }

    .success-section .section-tag {
        background: rgba(255, 255, 255, 0.2);
    }

    .success-section .section-title,
    .success-section .section-description {
        color: var(--white);
    }

    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .testimonial-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 2rem;
        transition: var(--transition);
    }

    .testimonial-card:hover {
        transform: translateY(-10px);
        background: rgba(255, 255, 255, 0.25);
    }

    .testimonial-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .testimonial-avatar img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 3px solid var(--white);
    }

    .testimonial-info h4 {
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
    }

    .testimonial-score {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--accent-color);
    }

    .testimonial-body p {
        font-size: 1rem;
        line-height: 1.7;
        font-style: italic;
    }

    .testimonial-footer {
        text-align: right;
        margin-top: 1rem;
    }

    .quote-icon {
        font-size: 3rem;
        opacity: 0.3;
    }

    /* ===================================
   FAQ Section
   =================================== */
    .faq-section {
        padding: 3rem 0;
        background: var(--gradient-primary);
        ;
    }

    .faq-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .faq-item {
        background: var(--white);
        margin-bottom: 1.5rem;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .faq-question {
        padding: 1.5rem 2rem;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: var(--transition);
    }

    .faq-question:hover {
        background: var(--light-color);
    }

    .faq-question h4 {
        font-size: 1.1rem;
        color: var(--dark-color);
        margin: 0;
    }

    .faq-toggle i {
        font-size: 1.5rem;
        color: var(--primary-color);
        transition: transform 0.3s ease;
    }

    .faq-item.active .faq-toggle i {
        transform: rotate(45deg);
    }

    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease, padding 0.3s ease;
        padding: 0 2rem;
    }

    .faq-item.active .faq-answer {
        max-height: 1000px;
        padding: 1.5rem 2rem 2rem;
    }

    .faq-answer ul {
        list-style: none;
        padding: 0;
    }

    .faq-answer li {
        padding: 0.5rem 0 0.5rem 1.5rem;
        position: relative;
        line-height: 1.6;
    }

    .faq-answer li::before {
        content: '✓';
        position: absolute;
        left: 0;
        color: var(--success);
        font-weight: bold;
    }

    /* ===================================
   CTA Section
   =================================== */
    .cta-section {
        padding: 3rem 0;
        background: var(--gradient-primary);
        color: var(--white);
        text-align: center;
    }

    .cta-content h2 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .cta-content p {
        font-size: 1.2rem;
        margin-bottom: 2.5rem;
        opacity: 0.95;
    }

    .cta-buttons {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .btn-cta-primary,
    .btn-cta-secondary {
        padding: 1rem 2.5rem;
        border: none;
        border-radius: 50px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.8rem;
    }

    .btn-cta-primary {
        background: var(--white);
        color: var(--primary-color);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .btn-cta-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    }

    .btn-cta-secondary {
        background: transparent;
        color: var(--white);
        border: 2px solid var(--white);
    }

    .btn-cta-secondary:hover {
        background: var(--white);
        color: var(--primary-color);
    }

    /* ===================================
   Back to Top Button
   =================================== */
    .back-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background: var(--primary-color);
        color: var(--white);
        border: none;
        border-radius: 50%;
        font-size: 1.3rem;
        cursor: pointer;
        box-shadow: var(--shadow-lg);
        opacity: 0;
        visibility: hidden;
        transition: var(--transition);
        z-index: 999;
    }

    .back-to-top.show {
        opacity: 1;
        visibility: visible;
    }

    .back-to-top:hover {
        background: var(--secondary-color);
        transform: translateY(-5px);
    }

    /* ===================================
   Responsive Design
   =================================== */
    @media (max-width: 968px) {
        .hamburger {
            display: flex;
        }

        .nav-menu {
            position: fixed;
            left: -100%;
            top: 75px;
            flex-direction: column;
            background: var(--white);
            width: 100%;
            text-align: center;
            transition: 0.3s;
            box-shadow: var(--shadow-lg);
            padding: 2rem 0;
            gap: 1.5rem;
        }

        .nav-menu.active {
            left: 0;
        }

        .hero {
            padding: 4rem 0 3rem;
            min-height: auto;
        }

        .empower-logo {
            font-size: 2.5rem;
        }

        .hero-title {
            font-size: 2rem;
        }

        .hero-description {
            font-size: 1rem;
        }

        .hero-badge {
            flex-direction: column;
            align-items: center;
        }

        .hero-cta {
            flex-direction: column;
        }

        .section-title {
            font-size: 2rem;
        }

        .skills-tabs {
            flex-direction: column;
            align-items: stretch;
        }

        .skill-grid {
            grid-template-columns: 1fr;
        }

        .flow-steps {
            flex-direction: column;
        }

        .flow-arrow {
            transform: rotate(90deg);
        }

        .career-table {
            font-size: 0.85rem;
        }

        .career-table th,
        .career-table td {
            padding: 1rem;
        }
    }

    @media (max-width: 480px) {
        .container {
            padding: 0 15px;
        }

        .empower-logo {
            font-size: 2rem;
            letter-spacing: 2px;
        }

        .hero-title {
            font-size: 1.5rem;
        }

        .section-title {
            font-size: 1.6rem;
        }

        .certified-grid,
        .comparison-grid,
        .testimonials-grid {
            grid-template-columns: 1fr;
        }
    }

    /* ===================================
   Utility Classes
   =================================== */
    .text-center {
        text-align: center;
    }

    .text-left {
        text-align: left;
    }

    .text-right {
        text-align: right;
    }

    .d-none {
        display: none;
    }

    .d-block {
        display: block;
    }

    .d-flex {
        display: flex;
    }

    .justify-center {
        justify-content: center;
    }

    .align-center {
        align-items: center;
    }

    .gap-1 {
        gap: 1rem;
    }

    .gap-2 {
        gap: 2rem;
    }

    .mt-1 {
        margin-top: 1rem;
    }

    .mt-2 {
        margin-top: 2rem;
    }

    .mb-1 {
        margin-bottom: 1rem;
    }

    .mb-2 {
        margin-bottom: 2rem;
    }
</style>

<body>


    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg-animation"></div>
        <div class="container">
            <div class="hero-content">
                <div class="empower-logo">E.M.P.O.W.E.R®</div>
                <h1 class="hero-title">TRAO QUYỀN & KHAI PHÓNG TIỀM NĂNG</h1>
                <p class="hero-description">Phương pháp học tiếng Anh, IELTS độc quyền tại Fighter. Giúp bạn chủ động khám phá, luyện – sửa – luyện lại, nhận feedback liên tục và tiến bộ từng buổi. Học để thực sự làm được, không chỉ để thi.</p>
                <div class="hero-badge-wrapper">
                    <div class="hero-badge">
                        <div class="badge-item">
                            <i class="fas fa-heart"></i>
                            <span>Niềm tin từ học viên</span>
                        </div>
                        <div class="badge-item">
                            <i class="fas fa-certificate"></i>
                            <span>Sự công nhận từ đối tác</span>
                        </div>
                    </div>
                </div>
                <div class="hero-cta">
                    <a href="#contact" class="btn-primary">Đăng ký học thử</a>
                    <a href="#gioi-thieu" class="btn-secondary">Tìm hiểu thêm</a>
                </div>
            </div>
        </div>
        <div class="hero-scroll-indicator">
            <span>Cuộn xuống</span>
            <i class="fas fa-chevron-down"></i>
        </div>
    </section>

    <!-- Certified Section -->
    <section class="certified" id="gioi-thieu">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Công nhận Sở Hữu Trí Tuệ</span>
                <h2 class="section-title">E.M.P.O.W.E.R® – Phương pháp học Tiếng Anh, IELTS độc quyền bởi Fighter được công nhận Sở Hữu Trí Tuệ</h2>
            </div>

            <div class="certified-grid">
                <div class="certified-card" data-aos="fade-up" data-aos-delay="0">
                    <div class="certified-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3>Đội ngũ IELTS 8.0+</h3>
                    <p><strong>Phát triển bởi đội ngũ giáo viên IELTS 8.0+</strong>, E.M.P.O.W.E.R® ra đời để giải quyết những khó khăn cốt lõi của người học Việt: học thụ động, dễ quên kiến thức, thiếu tự tin khi đi thi.</p>
                </div>

                <div class="certified-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="certified-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3>Toàn diện 4 kỹ năng</h3>
                    <p><strong>Ứng dụng toàn diện vào 4 kỹ năng</strong>, từ Nghe – Nói – Đọc – Viết, giúp học viên học chủ động, thực hành nhiều vòng, nhận feedback liên tục và tiến bộ từng buổi.</p>
                </div>

                <div class="certified-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="certified-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3>Công nhận chính thức</h3>
                    <p>Là thành quả nghiên cứu và áp dụng tại Fighter trong nhiều năm, E.M.P.O.W.E.R® đã giúp hàng ngàn học viên bứt phá band điểm, đồng thời được chính thức công nhận <strong>Sở hữu trí tuệ tại Việt Nam</strong> – khẳng định giá trị khác biệt và tính khoa học của phương pháp.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="benefits" id="uu-diem">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Vượt trội</span>
                <h2 class="section-title">Những ưu điểm vượt trội của E.M.P.O.W.E.R®</h2>
                <p class="section-description">Không còn thụ động ghi chép. <strong>E.M.P.O.W.E.R®</strong> giúp bạn tự khám phá, thực hành, nhận feedback tức thì và thấy rõ sự tiến bộ sau mỗi lần học.</p>
            </div>

            <div class="comparison-intro">
                <h3>Cách học truyền thống được thay thế bởi phương pháp E.M.P.O.W.E.R® như thế nào?</h3>
                <p>Phương pháp 8 bước chủ động: Khám phá – Luyện tập – Phản hồi – Tiến bộ rõ rệt sau từng buổi học.</p>
            </div>

            <div class="comparison-grid">
                <div class="comparison-item" data-aos="fade-right">
                    <div class="old-method">
                        <i class="fas fa-times-circle"></i>
                        <span>Thầy giảng – trò chép</span>
                    </div>
                    <div class="arrow-transform">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    <div class="new-method">
                        <i class="fas fa-check-circle"></i>
                        <span>Học viên chủ động khám phá, tham gia xây dựng bài học 😊</span>
                    </div>
                </div>

                <div class="comparison-item" data-aos="fade-right" data-aos-delay="50">
                    <div class="old-method">
                        <i class="fas fa-times-circle"></i>
                        <span>Ít hoặc không có tương tác</span>
                    </div>
                    <div class="arrow-transform">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    <div class="new-method">
                        <i class="fas fa-check-circle"></i>
                        <span>Tương tác cao qua thảo luận, thực hành liên tục 😘</span>
                    </div>
                </div>

                <div class="comparison-item" data-aos="fade-right" data-aos-delay="100">
                    <div class="old-method">
                        <i class="fas fa-times-circle"></i>
                        <span>Học rập khuôn theo giáo trình cố định</span>
                    </div>
                    <div class="arrow-transform">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    <div class="new-method">
                        <i class="fas fa-check-circle"></i>
                        <span>Học linh hoạt có định hướng, phù hợp từng cá nhân 😍</span>
                    </div>
                </div>

                <div class="comparison-item" data-aos="fade-right" data-aos-delay="150">
                    <div class="old-method">
                        <i class="fas fa-times-circle"></i>
                        <span>Bài tập máy móc, ít thử lại</span>
                    </div>
                    <div class="arrow-transform">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    <div class="new-method">
                        <i class="fas fa-check-circle"></i>
                        <span>Luyện nhiều vòng, tự sửa lỗi và cải thiện dần 😄</span>
                    </div>
                </div>

                <div class="comparison-item" data-aos="fade-right" data-aos-delay="200">
                    <div class="old-method">
                        <i class="fas fa-times-circle"></i>
                        <span>Ít hoặc không ứng dụng công nghệ</span>
                    </div>
                    <div class="arrow-transform">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    <div class="new-method">
                        <i class="fas fa-check-circle"></i>
                        <span>Ứng dụng LMS, Moore, phòng máy chuẩn thi thật 😎</span>
                    </div>
                </div>

                <div class="comparison-item" data-aos="fade-right" data-aos-delay="250">
                    <div class="old-method">
                        <i class="fas fa-times-circle"></i>
                        <span>Chỉ ghi nhớ, lặp lại – Thiếu phản biện</span>
                    </div>
                    <div class="arrow-transform">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    <div class="new-method">
                        <i class="fas fa-check-circle"></i>
                        <span>Đặt câu hỏi, tranh luận, phát triển tư duy phản biện 😊</span>
                    </div>
                </div>

                <div class="comparison-item" data-aos="fade-right" data-aos-delay="300">
                    <div class="old-method">
                        <i class="fas fa-times-circle"></i>
                        <span>Đánh giá dựa trên điểm số cuối kỳ</span>
                    </div>
                    <div class="arrow-transform">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    <div class="new-method">
                        <i class="fas fa-check-circle"></i>
                        <span>Feedback liên tục, tự đánh giá và đánh giá chéo 🙂</span>
                    </div>
                </div>

                <div class="comparison-item" data-aos="fade-right" data-aos-delay="350">
                    <div class="old-method">
                        <i class="fas fa-times-circle"></i>
                        <span>Học thụ động, khó tự cải thiện</span>
                    </div>
                    <div class="arrow-transform">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    <div class="new-method">
                        <i class="fas fa-check-circle"></i>
                        <span>Phản tư, điều chỉnh phương pháp học theo tiến bộ bản thân 🤩</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section class="skills-section" id="ky-nang">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Toàn diện</span>
                <h2 class="section-title">E.M.P.O.W.E.R® – Một phương pháp, toàn diện 4 kỹ năng</h2>
            </div>

            <!-- Skill Tabs -->
            <div class="skills-tabs">
                <button class="skill-tab active" data-skill="vocabulary">
                    <i class="fas fa-book"></i>
                    <span>Vocabulary</span>
                </button>
                <button class="skill-tab" data-skill="grammar">
                    <i class="fas fa-spell-check"></i>
                    <span>Grammar</span>
                </button>
                <button class="skill-tab" data-skill="listening">
                    <i class="fas fa-headphones"></i>
                    <span>Listening</span>
                </button>
                <button class="skill-tab" data-skill="reading">
                    <i class="fas fa-book-open"></i>
                    <span>Reading</span>
                </button>
                <button class="skill-tab" data-skill="writing">
                    <i class="fas fa-pen"></i>
                    <span>Writing</span>
                </button>
            </div>

            <!-- Vocabulary Content -->
            <div class="skill-content active" id="vocabulary-content">
                <div class="skill-grid">
                    <div class="skill-box problem">
                        <h4><i class="fas fa-exclamation-triangle"></i> Vấn đề</h4>
                        <ul>
                            <li>Vốn từ ít, chỉ biết từ cơ bản.</li>
                            <li>Nhanh quên, khó dùng đúng ngữ cảnh.</li>
                        </ul>
                    </div>
                    <div class="skill-box solution">
                        <h4><i class="fas fa-lightbulb"></i> E.M.P.O.W.E.R® giải quyết</h4>
                        <ul>
                            <li>Học từ qua hình ảnh, video và tình huống thực tế.</li>
                            <li>LMS + Luyện 4 kỹ năng → Gặp lại từ nhiều lần.</li>
                            <li>Dùng từ trong bài nghe/đọc và áp dụng ngay vào nói/viết.</li>
                        </ul>
                    </div>
                    <div class="skill-box result">
                        <h4><i class="fas fa-trophy"></i> Kết quả</h4>
                        <ul>
                            <li>Tăng nhanh vốn từ và nhớ lâu hơn.</li>
                            <li>Biết áp dụng từ đúng ngữ cảnh.</li>
                            <li>Tự tin dùng lại Từ vựng trong giao tiếp và bài thi.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Grammar Content -->
            <div class="skill-content" id="grammar-content">
                <div class="skill-grid">
                    <div class="skill-box problem">
                        <h4><i class="fas fa-exclamation-triangle"></i> Vấn đề</h4>
                        <ul>
                            <li>Sai cấu trúc cơ bản.</li>
                            <li>Không nắm chắc quy tắc đơn giản.</li>
                        </ul>
                    </div>
                    <div class="skill-box solution">
                        <h4><i class="fas fa-lightbulb"></i> E.M.P.O.W.E.R® giải quyết</h4>
                        <ul>
                            <li>Khám phá quy tắc qua ví dụ thực tế.</li>
                            <li>Thực hành nhiều vòng trong và ngoài lớp.</li>
                            <li>LMS hỗ trợ luyện thêm + Đặt ngữ pháp vào tình huống Nghe – Nói – Đọc – Viết.</li>
                        </ul>
                    </div>
                    <div class="skill-box result">
                        <h4><i class="fas fa-trophy"></i> Kết quả</h4>
                        <ul>
                            <li>Hiểu và dùng đúng cấu trúc đơn giản.</li>
                            <li>Giảm lỗi ngữ pháp phổ biến.</li>
                            <li>Viết và nói câu rõ ràng, dễ hiểu.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Listening Content -->
            <div class="skill-content" id="listening-content">
                <div class="skill-grid">
                    <div class="skill-box problem">
                        <h4><i class="fas fa-exclamation-triangle"></i> Vấn đề</h4>
                        <ul>
                            <li>Từ vựng hạn chế, khó bắt ý chính.</li>
                            <li>Phát âm sai → nghe không chính xác.</li>
                            <li>Không hiểu thông tin nền khi nghe.</li>
                        </ul>
                    </div>
                    <div class="skill-box solution">
                        <h4><i class="fas fa-lightbulb"></i> E.M.P.O.W.E.R® giải quyết</h4>
                        <ul>
                            <li>Học từ, phát âm qua tình huống, hình ảnh và video trước khi nghe.</li>
                            <li>Thực hành nghe nhiều lần, được sửa lỗi ngay sau bài nghe.</li>
                            <li>LMS hỗ trợ luyện thêm ngoài lớp.</li>
                            <li>Nghe đa dạng tình huống, giọng nói thật (video, audio).</li>
                            <li>Phản chiếu sau mỗi lần nghe để nhận diện lỗi & khắc phục.</li>
                        </ul>
                    </div>
                    <div class="skill-box result">
                        <h4><i class="fas fa-trophy"></i> Kết quả</h4>
                        <ul>
                            <li>Hiểu được nội dung cơ bản của bài nghe → Tự tin hơn khi giao tiếp.</li>
                            <li>Có kiến thức nền để nắm bắt ngữ cảnh bài nghe.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Reading Content -->
            <div class="skill-content" id="reading-content">
                <div class="skill-grid">
                    <div class="skill-box problem">
                        <h4><i class="fas fa-exclamation-triangle"></i> Vấn đề</h4>
                        <ul>
                            <li>Thiếu từ vựng và kiến thức nền → đọc không hiểu.</li>
                            <li>Đọc chậm, dịch từng từ, không nắm ý tổng quát.</li>
                        </ul>
                    </div>
                    <div class="skill-box solution">
                        <h4><i class="fas fa-lightbulb"></i> E.M.P.O.W.E.R® giải quyết</h4>
                        <ul>
                            <li>Gợi hứng thú và xây nền trước khi đọc bằng hình ảnh, câu hỏi.</li>
                            <li>Học phương pháp đọc lấy ý chính và chi tiết.</li>
                            <li>Thực hành + Sửa lỗi sau mỗi bài đọc.</li>
                            <li>LMS hỗ trợ luyện thêm ngoài lớp.</li>
                            <li>Đọc chủ đề thực tế, mở rộng góc nhìn và thảo luận.</li>
                            <li>Phản chiếu mỗi buổi để nhận diện điểm mạnh và điểm cần cải thiện.</li>
                        </ul>
                    </div>
                    <div class="skill-box result">
                        <h4><i class="fas fa-trophy"></i> Kết quả</h4>
                        <ul>
                            <li>Cải thiện tốc độ đọc và hiểu trực tiếp bằng tiếng Anh.</li>
                            <li>Hiểu ý chính của các bài đọc ngắn, cơ bản.</li>
                            <li>Tích lũy kiến thức nền để nắm bắt ngữ cảnh bài đọc.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Writing Content -->
            <div class="skill-content" id="writing-content">
                <div class="skill-grid">
                    <div class="skill-box problem">
                        <h4><i class="fas fa-exclamation-triangle"></i> Vấn đề</h4>
                        <ul>
                            <li>Viết sai ngữ pháp, cấu trúc câu chưa rõ.</li>
                            <li>Không hiểu đề, thiếu từ vựng diễn đạt.</li>
                        </ul>
                    </div>
                    <div class="skill-box solution">
                        <h4><i class="fas fa-lightbulb"></i> E.M.P.O.W.E.R® giải quyết</h4>
                        <ul>
                            <li>Xây bối cảnh rõ ràng trước khi viết.</li>
                            <li>Hướng dẫn từng bước: Viết câu đơn giản, bổ sung từ vựng.</li>
                            <li>Thực hành viết nhiều vòng, tự sửa trước khi GV feedback.</li>
                            <li>LMS hỗ trợ bài tập viết thêm ngoài lớp.</li>
                            <li>Viết về chủ đề thực tế để mở rộng góc nhìn.</li>
                            <li>Đánh giá quá trình: Tự đánh giá và đánh giá chéo.</li>
                            <li>Phản chiếu sau mỗi bài để nhận diện lỗi và cách cải thiện.</li>
                        </ul>
                    </div>
                    <div class="skill-box result">
                        <h4><i class="fas fa-trophy"></i> Kết quả</h4>
                        <ul>
                            <li>Viết câu rõ ý, đúng ngữ pháp.</li>
                            <li>Hiểu yêu cầu và viết đúng trọng tâm đề.</li>
                            <li>Tăng khả năng tự sửa lỗi, cải thiện theo feedback giáo viên.</li>
                            <li>Hình thành tư duy viết học thuật sớm.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Career Skills Section -->
    <section class="career-section" id="su-nghiep">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Phát triển toàn diện</span>
                <h2 class="section-title">Chìa khóa cho học tập & sự nghiệp</h2>
                <p class="section-description">Không chỉ giúp chinh phục IELTS – Tiếng Anh, <strong>E.M.P.O.W.E.R®</strong> còn rèn luyện kỹ năng tự học, tư duy phản biện, giao tiếp và viết học thuật – những năng lực quan trọng trong học tập đại học và môi trường làm việc quốc tế.</p>
            </div>

            <div class="career-table-wrapper">
                <table class="career-table">
                    <thead>
                        <tr>
                            <th>Năng lực phát triển qua E.M.P.O.W.E.R®</th>
                            <th>Ứng dụng trong học tập</th>
                            <th>Ứng dụng trong công việc</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <strong>Tư duy phản biện và năng lực đánh giá thông tin</strong>
                                <span class="tag">Widen Perspectives</span>
                            </td>
                            <td>Phân tích bài đọc, bài nghe. Nhận diện quan điểm, mâu thuẫn, thông tin sai lệch trong bài thi hoặc tài liệu học thuật.</td>
                            <td>Đánh giá báo cáo, dữ liệu, lập luận. Đưa ra quyết định có phân tích và phản biện khi làm việc nhóm hoặc ra chiến lược.</td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Khả năng tự học và tự chủ tiến trình học tập</strong>
                                <span class="tag">Engage, Motivate, Evaluate, Reflect</span>
                            </td>
                            <td>Biết đặt mục tiêu học tập, sử dụng LMS và tài nguyên online để học thêm; tự sửa lỗi và theo dõi sự tiến bộ.</td>
                            <td>Chủ động học kỹ năng mới, làm việc độc lập, theo dõi tiến độ công việc. Không phụ thuộc quá nhiều vào cấp trên.</td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Kỹ năng trình bày ý tưởng và thể hiện quan điểm cá nhân</strong>
                                <span class="tag">Practice, Evaluate, Reflect</span>
                            </td>
                            <td>Trình bày quan điểm trong bài viết học thuật hoặc bài nói; đưa ra ví dụ và lập luận rõ ràng.</td>
                            <td>Trình bày ý kiến trong cuộc họp, phản hồi hiệu quả, thuyết trình hoặc bảo vệ ý tưởng trong dự án.</td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Mở rộng kiến thức xã hội và góc nhìn đa chiều</strong>
                                <span class="tag">Widen Perspectives</span>
                            </td>
                            <td>Nhận thức các vấn đề xã hội, môi trường, giáo dục, nghề nghiệp thông qua nội dung bài học.</td>
                            <td>Hiểu sự đa dạng trong môi trường làm việc, thích nghi với các góc nhìn khác nhau khi làm việc nhóm hoặc quốc tế.</td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Tư duy phát triển – Growth mindset</strong>
                                <span class="tag">Practice, Evaluate, Reflect</span>
                            </td>
                            <td>Chấp nhận phản hồi, không sợ sai, xem lỗi là cơ hội học tập. Duy trì động lực học tập lâu dài.</td>
                            <td>Chủ động cải thiện kỹ năng, thử thách bản thân với vai trò mới, học từ thất bại và sẵn sàng thích nghi với thay đổi.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Class Flow Section -->
    <section class="class-flow">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Trải nghiệm học tập</span>
                <h2 class="section-title">Một buổi học với E.M.P.O.W.E.R® diễn ra thế nào?</h2>
                <p class="section-description">Không còn "Nghe giảng – chép bài" như truyền thống, mỗi buổi học theo E.M.P.O.W.E.R® được thiết kế thành <strong>8 bước liên hoàn</strong>: Bắt đầu với phần Lead-in khơi gợi tò mò → Language Focus và Practice nhiều vòng → Exam Practice mô phỏng thi thật → Cuối buổi, học viên tự đánh giá & đánh giá chéo để nhìn rõ tiến bộ.</p>
                <p class="section-description">Nhờ vậy, học viên vừa được rèn kỹ năng, vừa được trao quyền chủ động trong việc học, sửa lỗi và cải thiện band điểm liên tục.</p>
            </div>

            <div class="flow-steps">
                <div class="flow-step" data-step="1">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h4>Lead-in</h4>
                        <p>Khơi gợi tò mò và hứng thú</p>
                    </div>
                </div>
                <div class="flow-arrow">→</div>
                <div class="flow-step" data-step="2">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h4>Language Focus</h4>
                        <p>Khám phá kiến thức mới</p>
                    </div>
                </div>
                <div class="flow-arrow">→</div>
                <div class="flow-step" data-step="3">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h4>Practice</h4>
                        <p>Thực hành nhiều vòng</p>
                    </div>
                </div>
                <div class="flow-arrow">→</div>
                <div class="flow-step" data-step="4">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h4>Exam Practice</h4>
                        <p>Mô phỏng thi thật</p>
                    </div>
                </div>
                <div class="flow-arrow">→</div>
                <div class="flow-step" data-step="5">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <h4>Evaluation</h4>
                        <p>Tự đánh giá & đánh giá chéo</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- FAQ Section -->
    <section class="faq-section" id="faq">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Giải đáp thắc mắc</span>
                <h2 class="section-title">Các câu hỏi thường gặp</h2>
            </div>

            <div class="faq-container">
                <div class="faq-item">
                    <div class="faq-question">
                        <h4>E.M.P.O.W.E.R® khác gì với phương pháp học truyền thống?</h4>
                        <span class="faq-toggle"><i class="fas fa-plus"></i></span>
                    </div>
                    <div class="faq-answer">
                        <ul>
                            <li>Học viên <strong>chủ động khám phá</strong> thay vì thụ động nghe giảng.</li>
                            <li><strong>Thực hành – tự sửa – luyện lại nhiều vòng</strong> trong mỗi buổi học.</li>
                            <li><strong>Feedback liên tục</strong> từ giáo viên, bạn học & chính bản thân.</li>
                            <li>Ứng dụng <strong>LMS, Moore, phòng máy thi thử</strong> để học & kiểm tra như thi thật.</li>
                        </ul>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h4>Thời lượng thực hành trong một buổi học là bao nhiêu?</h4>
                        <span class="faq-toggle"><i class="fas fa-plus"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p>Trung bình <strong>60–70% thời lượng buổi học</strong> dành cho thực hành (thảo luận, luyện đề, sửa lỗi, phản chiếu). Không chỉ nghe giảng, học viên được "trao quyền" để tự học và làm chủ tiến bộ.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h4>Có được thi thử để chuẩn bị cho kỳ thi thật không?</h4>
                        <span class="faq-toggle"><i class="fas fa-plus"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p>Có! Học viên được <strong>thi thử phòng máy mô phỏng 100% thi thật</strong>. Sau mỗi bài thi, <strong>nhận feedback chi tiết</strong> về điểm mạnh, điểm cần cải thiện & lộ trình ôn tập tiếp theo.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h4>Học bao lâu thì đạt band điểm mục tiêu?</h4>
                        <span class="faq-toggle"><i class="fas fa-plus"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p>👉 Trung bình <strong>4–6 tháng</strong>, tuỳ theo:</p>
                        <ul>
                            <li>Xuất phát điểm & tốc độ tiếp thu.</li>
                            <li>Thời lượng học (3 buổi/tuần hay 5 buổi/tuần).</li>
                            <li>Mức độ tự học & luyện tập thêm ngoài lớp.</li>
                        </ul>
                        <p><em>*Học viên sẽ được kiểm tra đầu vào và nhận lộ trình cá nhân hoá cụ thể.</em></p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h4>Thi thử tại Fighter có mất phí không?</h4>
                        <span class="faq-toggle"><i class="fas fa-plus"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p>Thi thử tại Fighter English <strong>hoàn toàn miễn phí</strong>. Học viên được tham gia thi thử đầy đủ 4 kỹ năng IELTS, trải nghiệm kỳ thi IELTS chuẩn như thi THẬT, quy trình và đề thi đạt chuẩn IDP và BC, giúp học viên có được sự chuẩn bị tốt nhất trước khi thi IELTS.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </button>

</body>

</html>
<script>
    // ===================================
    // Global Variables
    // ===================================
    let lastScrollTop = 0;
    const header = document.querySelector('.header');
    const backToTopBtn = document.getElementById('backToTop');
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');

    // ===================================
    // Hamburger Menu Toggle
    // ===================================
    if (hamburger && navMenu) {
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
            document.body.style.overflow = navMenu.classList.contains('active') ? 'hidden' : '';
        });

        // Close menu when clicking on a link
        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
                document.body.style.overflow = '';
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!hamburger.contains(e.target) && !navMenu.contains(e.target)) {
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    }

    // ===================================
    // Smooth Scrolling
    // ===================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const headerHeight = header ? header.offsetHeight : 0;
                const targetPosition = target.offsetTop - headerHeight;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // ===================================
    // Header Scroll Effect
    // ===================================
    window.addEventListener('scroll', () => {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        // Header shadow on scroll
        if (header) {
            if (scrollTop > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }

            // Hide/show header on scroll
            if (scrollTop > lastScrollTop && scrollTop > 200) {
                header.style.transform = 'translateY(-100%)';
            } else {
                header.style.transform = 'translateY(0)';
            }
            lastScrollTop = scrollTop;
        }

        // Back to top button
        if (backToTopBtn) {
            if (scrollTop > 300) {
                backToTopBtn.classList.add('show');
            } else {
                backToTopBtn.classList.remove('show');
            }
        }
    });

    // ===================================
    // Back to Top Button
    // ===================================
    if (backToTopBtn) {
        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // ===================================
    // Skills Tabs Functionality
    // ===================================
    const skillTabs = document.querySelectorAll('.skill-tab');
    const skillContents = document.querySelectorAll('.skill-content');

    skillTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const targetSkill = tab.getAttribute('data-skill');

            // Remove active class from all tabs and contents
            skillTabs.forEach(t => t.classList.remove('active'));
            skillContents.forEach(c => c.classList.remove('active'));

            // Add active class to clicked tab and corresponding content
            tab.classList.add('active');
            const targetContent = document.getElementById(`${targetSkill}-content`);
            if (targetContent) {
                targetContent.classList.add('active');
            }
        });
    });

    // ===================================
    // FAQ Accordion
    // ===================================
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');

        if (question) {
            question.addEventListener('click', () => {
                const isActive = item.classList.contains('active');

                // Close all other items
                faqItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('active');
                    }
                });

                // Toggle current item
                if (isActive) {
                    item.classList.remove('active');
                } else {
                    item.classList.add('active');
                }
            });
        }
    });

    // ===================================
    // Intersection Observer for Animations
    // ===================================
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';

                // Add stagger animation for children
                const children = entry.target.querySelectorAll('[data-aos]');
                children.forEach((child, index) => {
                    setTimeout(() => {
                        child.style.opacity = '1';
                        child.style.transform = 'translateY(0) translateX(0)';
                    }, index * 100);
                });
            }
        });
    }, observerOptions);

    // Observe elements with animations
    const animateElements = document.querySelectorAll('.certified-card, .comparison-item, .skill-box, .testimonial-card, .flow-step');
    animateElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });

    // Initialize AOS-style attributes
    document.querySelectorAll('[data-aos]').forEach(el => {
        el.style.opacity = '0';
        const aosType = el.getAttribute('data-aos');

        if (aosType === 'fade-up') {
            el.style.transform = 'translateY(30px)';
        } else if (aosType === 'fade-right') {
            el.style.transform = 'translateX(-30px)';
        } else if (aosType === 'fade-left') {
            el.style.transform = 'translateX(30px)';
        } else if (aosType === 'zoom-in') {
            el.style.transform = 'scale(0.9)';
        }

        const delay = el.getAttribute('data-aos-delay') || '0';
        el.style.transitionDelay = `${delay}ms`;
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';

        observer.observe(el);
    });

    // ===================================
    // Counter Animation
    // ===================================
    function animateCounter(element, target, duration = 2000) {
        let start = 0;
        const increment = target / (duration / 16);
        const timer = setInterval(() => {
            start += increment;
            if (start >= target) {
                element.textContent = Math.floor(target);
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(start);
            }
        }, 16);
    }

    // Initialize counters if they exist
    const counters = document.querySelectorAll('.counter');
    if (counters.length > 0) {
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = parseInt(entry.target.getAttribute('data-target'));
                    animateCounter(entry.target, target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.5
        });

        counters.forEach(counter => counterObserver.observe(counter));
    }

    // ===================================
    // Parallax Effect for Hero
    // ===================================
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.hero');
        const heroContent = document.querySelector('.hero-content');

        if (hero && scrolled < window.innerHeight) {
            const parallaxSpeed = 0.5;
            heroContent.style.transform = `translateY(${scrolled * parallaxSpeed}px)`;
            hero.style.opacity = 1 - (scrolled / window.innerHeight);
        }
    });

    // ===================================
    // Ripple Effect for Buttons
    // ===================================
    function createRipple(event) {
        const button = event.currentTarget;
        const ripple = document.createElement('span');
        const diameter = Math.max(button.clientWidth, button.clientHeight);
        const radius = diameter / 2;

        const rect = button.getBoundingClientRect();
        ripple.style.width = ripple.style.height = `${diameter}px`;
        ripple.style.left = `${event.clientX - rect.left - radius}px`;
        ripple.style.top = `${event.clientY - rect.top - radius}px`;
        ripple.classList.add('ripple-effect');

        const existingRipple = button.querySelector('.ripple-effect');
        if (existingRipple) {
            existingRipple.remove();
        }

        button.appendChild(ripple);

        setTimeout(() => {
            ripple.remove();
        }, 600);
    }

    // Add ripple effect to all buttons
    const rippleButtons = document.querySelectorAll('.btn-primary, .btn-secondary, .btn-nav-contact, .btn-cta-primary, .btn-cta-secondary, .skill-tab');
    rippleButtons.forEach(button => {
        button.style.position = 'relative';
        button.style.overflow = 'hidden';
        button.addEventListener('click', createRipple);
    });

    // Add ripple CSS dynamically
    const rippleStyle = document.createElement('style');
    rippleStyle.textContent = `
    .ripple-effect {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        transform: scale(0);
        animation: ripple-animation 0.6s ease-out;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
    document.head.appendChild(rippleStyle);

    // ===================================
    // Typing Effect for Hero Title (Optional)
    // ===================================
    function typeWriter(element, text, speed = 100) {
        let i = 0;
        element.textContent = '';

        function type() {
            if (i < text.length) {
                element.textContent += text.charAt(i);
                i++;
                setTimeout(type, speed);
            }
        }

        type();
    }

    // Uncomment to enable typing effect
    // const heroTitle = document.querySelector('.hero-title');
    // if (heroTitle) {
    //     const originalText = heroTitle.textContent;
    //     typeWriter(heroTitle, originalText, 80);
    // }

    // ===================================
    // Form Validation (if you add a contact form)
    // ===================================
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }

    function validatePhone(phone) {
        const re = /^(0|\+84)(\d{9,10})$/;
        return re.test(String(phone));
    }

    // Example form submission handler
    const contactForms = document.querySelectorAll('form');
    contactForms.forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            const emailInput = form.querySelector('input[type="email"]');
            const phoneInput = form.querySelector('input[type="tel"]');

            let isValid = true;

            if (emailInput && !validateEmail(emailInput.value)) {
                emailInput.style.borderColor = 'var(--danger)';
                isValid = false;
            } else if (emailInput) {
                emailInput.style.borderColor = 'var(--success)';
            }

            if (phoneInput && !validatePhone(phoneInput.value)) {
                phoneInput.style.borderColor = 'var(--danger)';
                isValid = false;
            } else if (phoneInput) {
                phoneInput.style.borderColor = 'var(--success)';
            }

            if (isValid) {
                // Submit form logic here
                alert('Cảm ơn bạn đã đăng ký! Chúng tôi sẽ liên hệ với bạn sớm nhất.');
                form.reset();
            }
        });
    });

    // ===================================
    // Real-time Input Validation
    // ===================================
    document.querySelectorAll('input[type="email"]').forEach(input => {
        input.addEventListener('input', (e) => {
            if (e.target.value && !validateEmail(e.target.value)) {
                e.target.style.borderColor = 'var(--danger)';
            } else if (e.target.value) {
                e.target.style.borderColor = 'var(--success)';
            } else {
                e.target.style.borderColor = '';
            }
        });
    });

    document.querySelectorAll('input[type="tel"]').forEach(input => {
        input.addEventListener('input', (e) => {
            if (e.target.value && !validatePhone(e.target.value)) {
                e.target.style.borderColor = 'var(--danger)';
            } else if (e.target.value) {
                e.target.style.borderColor = 'var(--success)';
            } else {
                e.target.style.borderColor = '';
            }
        });
    });

    // ===================================
    // Table Responsive Scroll Indicator
    // ===================================
    const tableWrapper = document.querySelector('.career-table-wrapper');
    if (tableWrapper) {
        tableWrapper.addEventListener('scroll', () => {
            if (tableWrapper.scrollLeft > 0) {
                tableWrapper.style.boxShadow = 'inset 10px 0 10px -10px rgba(0,0,0,0.2)';
            } else {
                tableWrapper.style.boxShadow = 'var(--shadow-md)';
            }
        });
    }

    // ===================================
    // CTA Button Handlers
    // ===================================
    const ctaPrimaryBtn = document.querySelector('.btn-cta-primary');
    const ctaSecondaryBtn = document.querySelector('.btn-cta-secondary');

    if (ctaPrimaryBtn) {
        ctaPrimaryBtn.addEventListener('click', () => {
            // Add your chat integration here
            console.log('Opening chat...');
            alert('Chức năng chat đang được phát triển. Vui lòng liên hệ: 0901 100 100');
        });
    }

    if (ctaSecondaryBtn) {
        ctaSecondaryBtn.addEventListener('click', () => {
            // Add your phone call integration here
            window.location.href = 'tel:0901100100';
        });
    }

    // ===================================
    // Lazy Loading Images (Optional)
    // ===================================
    const lazyImages = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.getAttribute('data-src');
                img.removeAttribute('data-src');
                imageObserver.unobserve(img);
            }
        });
    });

    lazyImages.forEach(img => imageObserver.observe(img));

    // ===================================
    // Keyboard Navigation Accessibility
    // ===================================
    document.addEventListener('keydown', (e) => {
        // ESC key closes mobile menu
        if (e.key === 'Escape') {
            if (hamburger && navMenu) {
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
                document.body.style.overflow = '';
            }

            // Close all open FAQ items
            faqItems.forEach(item => item.classList.remove('active'));
        }

        // Tab key for better focus visibility
        if (e.key === 'Tab') {
            document.body.classList.add('keyboard-nav');
        }
    });

    document.addEventListener('mousedown', () => {
        document.body.classList.remove('keyboard-nav');
    });

    // ===================================
    // Page Load Animation
    // ===================================
    window.addEventListener('load', () => {
        // Fade in body
        document.body.style.opacity = '0';
        document.body.style.transition = 'opacity 0.5s ease';

        setTimeout(() => {
            document.body.style.opacity = '1';
        }, 100);

        // Remove loading class if exists
        document.body.classList.remove('loading');
    });

    // ===================================
    // Prevent FOUC (Flash of Unstyled Content)
    // ===================================
    document.addEventListener('DOMContentLoaded', () => {
        document.body.style.visibility = 'visible';
    });

    // ===================================
    // Local Storage for User Preferences (Optional)
    // ===================================
    function savePreference(key, value) {
        localStorage.setItem(key, JSON.stringify(value));
    }

    function getPreference(key) {
        const value = localStorage.getItem(key);
        return value ? JSON.parse(value) : null;
    }

    // Example: Remember last selected skill tab
    const lastSkillTab = getPreference('lastSkillTab');
    if (lastSkillTab) {
        const tab = document.querySelector(`[data-skill="${lastSkillTab}"]`);
        if (tab) {
            tab.click();
        }
    }

    skillTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            savePreference('lastSkillTab', tab.getAttribute('data-skill'));
        });
    });

    // ===================================
    // Performance Monitoring (Optional)
    // ===================================
    if ('performance' in window) {
        window.addEventListener('load', () => {
            const perfData = window.performance.timing;
            const pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;
            console.log(`Page load time: ${pageLoadTime}ms`);
        });
    }

    // ===================================
    // Console Branding
    // ===================================
    console.log(
        '%c🎓 Fighter English - E.M.P.O.W.E.R® ',
        'color: #fff; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); font-size: 20px; font-weight: bold; padding: 10px 20px; border-radius: 5px;'
    );
    console.log(
        '%cPhương pháp học IELTS độc quyền - Trao quyền & Khai phóng tiềm năng',
        'color: #ff6b35; font-size: 14px; font-weight: bold;'
    );
    console.log(
        '%cWebsite developed with ❤️',
        'color: #6c757d; font-size: 12px;'
    );

    // ===================================
    // Debug Mode (Remove in production)
    // ===================================
    const DEBUG = false;

    if (DEBUG) {
        console.log('Debug mode enabled');

        // Log all click events
        document.addEventListener('click', (e) => {
            console.log('Clicked:', e.target);
        });

        // Log scroll position
        window.addEventListener('scroll', () => {
            console.log('Scroll position:', window.pageYOffset);
        });
    }

    // ===================================
    // Export functions for external use (if needed)
    // ===================================
    window.FighterEMPOWER = {
        validateEmail,
        validatePhone,
        savePreference,
        getPreference,
        animateCounter,
        typeWriter
    };

    // ===================================
    // Initialize Everything on DOM Ready
    // ===================================
    document.addEventListener('DOMContentLoaded', () => {
        console.log('Fighter E.M.P.O.W.E.R® website initialized successfully! 🚀');
    });
</script>