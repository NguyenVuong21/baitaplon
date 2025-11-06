<?php
include 'db_connect.php';
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}

// === Xử lý thêm ===
if (isset($_POST['add'])) {
  $tenkhoa = $_POST['tenkhoa'];
  $conn->query("INSERT INTO khoa(tenkhoa) VALUES ('$tenkhoa')");
  header("Location: khoa.php");
  exit();
}

// === Xử lý xóa ===
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $conn->query("DELETE FROM khoa WHERE makhoa=$id");
  header("Location: khoa.php");
  exit();
}

// === Xử lý sửa ===
if (isset($_POST['edit'])) {
  $id = $_POST['makhoa'];
  $tenkhoa = $_POST['tenkhoa'];
  $conn->query("UPDATE khoa SET tenkhoa='$tenkhoa' WHERE makhoa=$id");
  header("Location: khoa.php");
  exit();
}

// === Lấy danh sách khoa ===
$result = $conn->query("SELECT * FROM khoa ORDER BY makhoa ASC");
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Quản lý Khoa - Hồ sơ sinh viên</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* ===== Toàn trang ===== */
    body {
      background: linear-gradient(135deg, #e9f1ff 0%, #f7f9fc 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
    }

    /* ===== Container chính ===== */
    .container {
      max-width: 900px;
      background-color: #ffffff;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
      margin-top: 40px;
      animation: fadeIn 0.6s ease;
    }

    /* ===== Tiêu đề ===== */
    h3 {
      color: #1a73e8;
      border-bottom: 3px solid #e0ecff;
      padding-bottom: 12px;
      margin-bottom: 30px;
      font-weight: 700;
      letter-spacing: 0.3px;
    }

    /* ===== Form thêm khoa ===== */
    .form-area {
      padding: 25px;
      border-radius: 12px;
      background-color: #f7faff;
      border: 1px solid #e3e6ea;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
      margin-bottom: 30px;
    }

    .form-control {
      border-radius: 8px 0 0 8px;
      border: 1px solid #ced4da;
      transition: border-color 0.3s, box-shadow 0.3s;
    }

    .form-control:focus {
      border-color: #4d90fe;
      box-shadow: 0 0 0 0.25rem rgba(26, 115, 232, 0.25);
    }

    .btn-primary {
      background-color: #1a73e8;
      border-color: #1a73e8;
      font-weight: 600;
      font-size: 14px;
      border-radius: 0 8px 8px 0;
      padding: 8px 18px;
      transition: 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #0b4eaf;
    }

    /* ===== Bảng dữ liệu ===== */
    .table {
      border: 1px solid #dee2e6;
      border-radius: 10px;
      overflow: hidden;
      font-size: 15px;
    }

    .table th {
      background-color: #1a73e8;
      color: white;
      font-weight: 600;
      text-align: center;
      vertical-align: middle;
      padding: 12px;
      border-right: 1px solid #e0e0e0;
    }

    .table td {
      vertical-align: middle;
      text-align: center;
      border-right: 1px solid #e9ecef;
      border-bottom: 1px solid #e9ecef;
      padding: 10px;
    }

    .table td:nth-child(2) {
      text-align: left;
    }

    .table-striped>tbody>tr:nth-of-type(odd)>* {
      background-color: #f9fbff;
    }

    .table tbody tr:hover {
      background-color: #eef5ff;
      transition: 0.25s ease;
    }

    /* ===== Nút hành động ===== */
    .btn-warning {
      background-color: #fbbc05;
      border-color: #fbbc05;
      color: #3c4043;
    }

    .btn-danger {
      background-color: #ea4335;
      border-color: #ea4335;
    }

    /* ===== Modal ===== */
    .modal-header.bg-warning {
      background-color: #fbbc05 !important;
      color: #3c4043 !important;
    }

    .modal-title {
      font-weight: 600;
      letter-spacing: 0.3px;
    }

    .modal-content {
      border-radius: 12px;
      border: none;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    /* Hiệu ứng fade-in */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(15px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>

<body>
  <?php include 'navbar.php'; ?>
  <div class="container">
    <a href="home.php" class="btn btn-secondary mb-3">← Quay lại Trang chủ</a>
    <h3>🏫 Quản lý Khoa</h3>

    <!-- Form thêm khoa -->
    <form method="post" class="input-group form-area">
      <input type="text" name="tenkhoa" class="form-control" placeholder="Nhập tên khoa mới..." required>
      <button type="submit" name="add" class="btn btn-primary">➕ Thêm</button>
    </form>

    <!-- Bảng hiển thị khoa -->
    <div class="table-container">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th style="width: 15%;">Mã Khoa</th>
            <th class="text-start">Tên Khoa</th>
            <th style="width: 25%;">Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
              <td><?= $row['makhoa'] ?></td>
              <td class="text-start"><?= $row['tenkhoa'] ?></td>
              <td>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['makhoa'] ?>">Sửa</button>
                <a href="khoa.php?delete=<?= $row['makhoa'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa khoa [<?= $row['tenkhoa'] ?>]? Hành động này có thể ảnh hưởng đến các lớp học!')">Xóa</a>
              </td>
            </tr>

            <!-- Modal sửa khoa -->
            <div class="modal fade" id="editModal<?= $row['makhoa'] ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="post">
                    <div class="modal-header bg-warning text-white">
                      <h5 class="modal-title">Sửa Khoa</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" name="makhoa" value="<?= $row['makhoa'] ?>">
                      <div class="mb-3">
                        <label class="form-label">Tên Khoa:</label>
                        <input type="text" name="tenkhoa" class="form-control" value="<?= $row['tenkhoa'] ?>" required>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" name="edit" class="btn btn-success">Lưu</button>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>