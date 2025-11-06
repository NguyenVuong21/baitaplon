<style>
  .navbar {
  background-color: #1a73e8; /* Màu xanh dương chủ đạo */
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Logo / Tên hệ thống */
.navbar-brand {
  color: white !important;
  font-weight: 600;
  font-size: 1.25rem;
  letter-spacing: 0.3px;
  padding: 10px 15px;
  transition: 0.3s;
}

.navbar-brand:hover {
  color: #e0ecff !important;
}

/* Liên kết Menu */
.nav-link {
  color: white !important;
  font-weight: 500;
  padding: 10px 15px;
  border-radius: 4px;
  transition: all 0.3s ease;
}

.nav-link:hover {
  color: #e0ecff !important;
  background-color: rgba(255, 255, 255, 0.1);
}

/* Khoảng cách giữa các item */
.navbar-nav .nav-item {
  margin-left: 5px;
}

/* Nút đăng xuất */
.btn-outline-light {
  border: 1px solid white;
  transition: background-color 0.3s, color 0.3s;
}

.btn-outline-light:hover {
  background-color: white;
  color: #1a73e8 !important;
}
</style>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="home.php">🎓 Quản lý hồ sơ sinh viên</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="home.php">🏠 Trang chủ</a></li>
          <li class="nav-item"><a class="nav-link" href="sinhvien.php">📘 Sinh viên</a></li>
          <li class="nav-item"><a class="nav-link" href="khoa.php">🏫 Khoa</a></li>
          <li class="nav-item"><a class="nav-link" href="lop.php">🧑‍🏫 Lớp học</a></li>
          <li class="nav-item"><a class="nav-link" href="dangky.php">📝 Đăng ký HP</a></li>
          <li class="nav-item"><a class="btn btn-outline-light ms-3" href="logout.php">Đăng xuất</a></li>
        </ul>
      </div>
    </div>
  </nav>