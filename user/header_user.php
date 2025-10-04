<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>headerDK</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    :root {
      --brand: #0db33b;
      --brand-2: #298f29;
      --bg: #f3f7f8;
      --text: #333;
      --muted: #666;
      --divider: #60d02f;
    }

    * {
      box-sizing: border-box
    }
    /* ===== Header ===== */
    .header-top {
      font-family: 'Times New Roman', Times, serif !important;

      position: relative;
      padding: 5px 16px;
      background: var(--bg);
      border-bottom: 2px solid var(--divider);
      z-index: 1000;
    }

    .header-inner {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
    }

    /* Logo */
    .logo {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none
    }

    .logo img {
      height: 50px;
      width: auto;
      display: block;
      border-radius: 6px;
      object-fit: cover
    }

    .logo-text .logo-item {
      font-size: 20px;
      color: var(--brand);
      font-weight: 800;
      line-height: 1.1
    }

    .logo-text .logo-row {
      font-size: 13px;
      color: var(--muted)
    }

    /* Nav right (desktop) */
    .right {
      display: flex;
      align-items: center;
      gap: 14px;
      font-weight: 600;
      flex-wrap: wrap;
    }

    .right a {
      text-decoration: none;
      font-size: 15px;
      color: var(--brand-2);
      position: relative
    }

    /* vertical divider only on wide screens */
    @media (min-width: 768px) {
      .right a+a {
        padding-left: 14px
      }

      .right a+a::before {
        content: "|";
        color: var(--brand-2);
        position: absolute;
        left: 4px;
        top: 50%;
        translate: 0 -50%;
        font-weight: 900
      }
    }

    .right a:hover {
      text-decoration: underline
    }

    /* ===== Hamburger (no JS) ===== */
    .nav-toggle {
      display: none
    }

    .burger {
      display: none;
      cursor: pointer;
      border: 1px solid #cfd8dc;
      border-radius: 8px;
      padding: 8px 10px;
      background: #fff;
      box-shadow: 0 1px 3px rgba(0, 0, 0, .06);
    }

    .burger i {
      font-size: 18px;
      color: #455a64
    }

    /* ===== Mobile layout ===== */
    @media (max-width: 767.98px) {
      .logo img {
        height: 44px
      }

      .logo-text .logo-item {
        font-size: 18px
      }

      .logo-text .logo-row {
        font-size: 12px
      }

      .burger {
        display: flex;
        align-items: center;
        justify-content: center
      }

      /* Collapse menu */
      .right {
        position: absolute;
        left: 0;
        right: 0;
        top: 100%;
        background: #fff;
        border-bottom: 2px solid var(--divider);
        box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
        display: none;
        flex-direction: column;
        align-items: stretch;
        gap: 0;
        padding: 6px 12px;
      }

      .right a {
        padding: 12px 6px;
        font-size: 16px;
        color: var(--text);
      }

      .right a+a::before {
        content: none
      }

      /* bỏ dấu | trên mobile */

      /* Show when checked */
      .nav-toggle:checked~.right {
        display: flex
      }
    }

    /* ===== Floating quick actions ===== */
    .floating-icons {
      position: fixed;
      right: 18px;
      bottom: 18px;
      display: flex;
      flex-direction: column;
      gap: 10px;
      z-index: 999;
    }

    .floating-icons a {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      text-decoration: none;
      box-shadow: 0 4px 8px rgba(0, 0, 0, .2);
    }

    .floating-icons a:hover {
      box-shadow: 0 6px 14px rgba(0, 0, 0, .28)
    }

    .messenger-icon {
      background: #f7b4f1;
      font-size: 22px
    }

    .phone-icon {
      background: #2bfc5f;
      font-size: 22px
    }

    /* tránh che nội dung trên màn rất nhỏ */
    @media (max-width: 360px) {
      .floating-icons {
        right: 12px;
        bottom: 12px
      }

      .floating-icons a {
        width: 44px;
        height: 44px
      }
    }
  </style>
</head>

<body>
  <header class="header-top">
    <div class="header-inner">
      <!-- Logo -->
      <a class="logo" href="../index.php" aria-label="Trang chủ">
        <img src="../images/logo2.jpg" alt="Tiếng Anh Fighter! logo">
        <span class="logo-text">
          <div class="logo-item">Tiếng Anh Fighter!</div>
          <div class="logo-row">Learning is an adventure!!!</div>
        </span>
      </a>

      <!-- Hamburger (checkbox hack) -->
      <input id="nav-toggle" class="nav-toggle" type="checkbox" aria-label="Mở menu">
      <label for="nav-toggle" class="burger" aria-hidden="true">
        <i class="fa-solid fa-bars"></i>
      </label>

      <!-- Nav links -->
      <nav class="right" aria-label="Tài khoản">
        <a href="dashboard.php"><?php echo $_SESSION['user']; ?></a>
        <a href="dashboard.php">Tài khoản</a>
        <a href="../index.php">Đăng xuất</a>
      </nav>
    </div>
  </header>
  <!-- 
 
  <div class="floating-icons" aria-label="Liên hệ nhanh">
    <a
      class="messenger-icon"
      href="https://www.facebook.com/profile.php?id=100091706867917&mibextid=LQQJ4d"
      target="_blank" rel="noopener"
      title="Chat với chúng tôi qua Messenger"
      aria-label="Mở Messenger">
      <i class="fa-brands fa-facebook-messenger" style="color:#f448cf;"></i>
    </a>

    <a
      class="phone-icon"
      href="tel:+84123456789"
      title="Gọi điện cho chúng tôi"
      aria-label="Gọi điện">
      <i class="fa-solid fa-phone"></i>
    </a>
  </div> -->


</body>

</html>