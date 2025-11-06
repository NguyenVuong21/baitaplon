<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập - Quản lý hồ sơ sinh viên</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* --- CÀI ĐẶT CHUNG --- */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=1920&q=80') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    /* --- LỚP LỌC NỀN (Overlay) --- */
    body::before {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(rgba(26, 115, 232, 0.5), rgba(0, 0, 0, 0.6));
      backdrop-filter: blur(3px);
      z-index: 0;
    }

    /* --- FORM ĐĂNG NHẬP --- */
    .login-box {
      position: relative;
      z-index: 1;
      background: rgba(255, 255, 255, 0.85);
      border-radius: 20px;
      padding: 55px 45px;
      width: 440px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
      backdrop-filter: blur(10px);
      text-align: center;
      border: 1px solid rgba(255, 255, 255, 0.4);
      animation: fadeIn 1s ease-out;
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

    /* --- TIÊU ĐỀ --- */
    .login-box h2 {
      color: #0b4eaf;
      margin-bottom: 10px;
      font-weight: 800;
      font-size: 26px; /* Tăng kích thước */
      line-height: 1.4;
      text-transform: uppercase;
    }

    .login-box p {
      color: #444;
      font-size: 15px;
      margin-bottom: 35px;
    }

    /* --- INPUT --- */
    input[type=text], input[type=password] {
      width: 100%;
      padding: 14px 16px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 10px;
      transition: all 0.3s ease;
      background-color: #fff;
    }

    input[type=text]:focus, input[type=password]:focus {
      border-color: #1a73e8;
      box-shadow: 0 0 0 0.25rem rgba(26, 115, 232, 0.25);
      outline: none;
      background-color: #fff;
    }

    /* --- NÚT ĐĂNG NHẬP --- */
    button[type=submit] {
      background-color: #1a73e8;
      color: white;
      border: none;
      padding: 13px;
      width: 100%;
      border-radius: 10px;
      cursor: pointer;
      font-weight: 600;
      font-size: 16px;
      margin-top: 25px;
      transition: all 0.3s ease;
    }

    button[type=submit]:hover {
      background-color: #0b4eaf;
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(26, 115, 232, 0.3);
    }

    /* --- THÔNG BÁO LỖI --- */
    .error-message {
      color: #ea4335;
      font-weight: 500;
      margin-bottom: 15px;
      animation: shake 0.3s ease-in-out;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      25% { transform: translateX(-5px); }
      50% { transform: translateX(5px); }
      75% { transform: translateX(-5px); }
    }

    /* --- FOOTER --- */
    .footer {
      margin-top: 35px;
      font-size: 12px;
      color: #5f6368;
    }

    /* Responsive */
    @media (max-width: 480px) {
      .login-box {
        width: 90%;
        padding: 40px 25px;
      }
      .login-box h2 {
        font-size: 22px;
      }
    }
  </style>
</head>

<body>
  <?php
    if (isset($_SESSION['error_message'])) {
        echo '<div class="login-box error-message">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
        unset($_SESSION['error_message']); 
    }
  ?>

  <form class="login-box" action="login.php" method="post">
    <h2>🎓 HỆ THỐNG QUẢN LÝ<br>HỒ SƠ SINH VIÊN ĐẠI HỌC</h2>
    <p>Vui lòng đăng nhập để bắt đầu phiên làm việc.</p>

    <?php
      if (isset($_SESSION['login_error'])) {
          echo '<div class="error-message">' . htmlspecialchars($_SESSION['login_error']) . '</div>';
          unset($_SESSION['login_error']); 
      }
    ?>
    
    <input type="text" name="username" placeholder="Tên đăng nhập" required>
    <input type="password" name="password" placeholder="Mật khẩu" required>

    <button type="submit">Đăng nhập</button>

    <div class="footer">
      © 2025 Đại học | Quản lý Hồ sơ Sinh viên 🌿
    </div>
  </form>
</body>
</html>
