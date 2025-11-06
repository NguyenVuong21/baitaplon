<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Trang chủ - Quản lý hồ sơ sinh viên</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  /* 🎓 Toàn trang */
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #e9f1ff 0%, #f7f9fc 100%);
    min-height: 100vh;
    margin: 0;
    display: flex;
    flex-direction: column;
  }

  /* 🏠 Container chính */
  .container.mt-5 {
    max-width: 1100px;
    background-color: #ffffff;
    padding: 50px;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    animation: fadeIn 0.6s ease;
  }

  /* ✨ Tiêu đề */
  h3 {
    color: #1a73e8;
    font-weight: 700;
    margin-bottom: 10px;
    letter-spacing: 0.5px;
  }
  .text-muted {
    color: #5f6368 !important;
  }

  /* 🧩 Thẻ điều hướng (Card) */
  .card {
    border: none;
    border-radius: 14px;
    background: linear-gradient(135deg, #ffffff 0%, #f3f7ff 100%);
    box-shadow: 0 4px 15px rgba(26, 115, 232, 0.15);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 120px;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .card:hover {
    transform: translateY(-7px);
    box-shadow: 0 10px 25px rgba(26, 115, 232, 0.25);
  }
  .card a {
    color: #1a73e8;
    text-decoration: none;
  }
  .card h5 {
    margin: 0;
    font-weight: 600;
    font-size: 1.15rem;
  }

  /* 💫 Hiệu ứng xuất hiện */
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>

</head>
<body>

  <?php include 'navbar.php'; ?>

  <div class="container mt-5 text-center">
    <h3>Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?> 👋</h3>
    <p class="text-muted mb-5">Chào mừng bạn đến với Hệ thống Quản lý Hồ sơ Sinh viên Đại học</p>
    
    <div class="row justify-content-center g-4">
      <div class="col-md-3">
        <div class="card p-3">
          <a href="sinhvien.php" class="text-decoration-none">
            <h5>📘 Quản lý Sinh viên</h5>
          </a>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card p-3">
          <a href="khoa.php" class="text-decoration-none">
            <h5>🏫 Quản lý Khoa</h5>
          </a>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card p-3">
          <a href="lop.php" class="text-decoration-none">
            <h5>🧑‍🏫 Quản lý Lớp học</h5>
          </a>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card p-3">
          <a href="dangky.php" class="text-decoration-none">
            <h5>📝 Đăng ký Học phần</h5>
          </a>
        </div>
      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>