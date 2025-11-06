<?php
include 'db_connect.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Lấy danh sách Khoa để hiển thị trong form
$khoaList = $conn->query("SELECT * FROM khoa");

// Thêm Lớp
if (isset($_POST['add'])) {
    $tenlop = $_POST['tenlop'];
    $makhoa = $_POST['makhoa'];
    $conn->query("INSERT INTO lop(tenlop, makhoa) VALUES ('$tenlop','$makhoa')");
    header("Location: lop.php");
    exit();
}

// Xóa Lớp
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM lop WHERE malop=$id");
    header("Location: lop.php");
    exit();
}

// Sửa Lớp
if (isset($_POST['edit'])) {
    $malop = $_POST['malop'];
    $tenlop = $_POST['tenlop'];
    $makhoa = $_POST['makhoa'];
    $conn->query("UPDATE lop SET tenlop='$tenlop', makhoa='$makhoa' WHERE malop=$malop");
    header("Location: lop.php");
    exit();
}

$result = $conn->query("SELECT lop.*, khoa.tenkhoa FROM lop LEFT JOIN khoa ON lop.makhoa = khoa.makhoa ORDER BY malop ASC");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản lý Lớp học - Hồ sơ sinh viên</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Cài đặt chung cho Body */
    body {
      background-color: #f0f2f5; /* Nền xám nhạt, hiện đại */
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    /* Container chính */
    .container {
      max-width: 900px; 
      background-color: #ffffff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); /* Đổ bóng nhẹ */
      margin-top: 30px;
    }
    
    /* Tiêu đề */
    h3 {
      color: #1a73e8; /* Màu xanh dương chủ đạo */
      border-bottom: 3px solid #e0ecff;
      padding-bottom: 15px;
      margin-bottom: 30px;
      font-weight: 600;
    }

    /* Form Thêm Lớp (Dùng g-3 và căn chỉnh lại để đẹp hơn) */
    .row.g-2.mb-4 {
      /* Chuyển sang g-3 và thêm align-items-end để căn chỉnh */
      padding: 20px;
      border-radius: 8px;
      background-color: #f7f9fc;
      border: 1px solid #e1e4e8;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .form-control, .form-select {
      border-radius: 6px;
      border: 1px solid #ced4da;
      transition: border-color 0.3s, box-shadow 0.3s;
    }

    .form-control:focus, .form-select:focus {
      border-color: #4d90fe;
      box-shadow: 0 0 0 0.25rem rgba(26, 115, 232, 0.25);
    }
    
    /* Bảng dữ liệu */
    .table-bordered {
      border: 1px solid #dee2e6;
      border-radius: 8px;
      overflow: hidden; 
      text-align: center; /* Căn giữa nội dung mặc định */
    }

    .table-striped > tbody > tr:nth-of-type(odd) > * {
        background-color: #fbfdff; /* Màu sọc nhẹ */
    }
    
    .table th {
      background-color: #1a73e8; /* Header màu xanh dương chủ đạo */
      color: white;
      font-weight: 500;
      vertical-align: middle;
      padding: 12px 8px;
      text-align: center;
    }

    .table td {
      vertical-align: middle;
      padding: 10px 8px;
    }

    /* Nút bấm */
    .btn-primary {
      background-color: #1a73e8;
      border-color: #1a73e8;
      font-weight: 500;
    }

    .btn-warning {
        background-color: #fbbc05;
        border-color: #fbbc05;
        color: #3c4043;
    }
    
    .btn-danger {
        background-color: #ea4335;
        border-color: #ea4335;
    }

    /* Modal */
    .modal-header.bg-warning {
        background-color: #fbbc05 !important;
        color: #3c4043 !important;
    }
    .modal-title {
        font-weight: 600;
    }
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?>
  <div class="container">
    <a href="home.php" class="btn btn-secondary mb-3">← Quay lại Trang chủ</a>
    <h3>🧑‍🏫 Quản lý Lớp học</h3>

    <form method="post" class="row g-2 mb-4 align-items-end">
      <div class="col-md-5">
        <label class="form-label visually-hidden">Tên lớp</label>
        <input type="text" name="tenlop" class="form-control" placeholder="Tên lớp..." required>
      </div>
      <div class="col-md-5">
        <label class="form-label visually-hidden">Chọn Khoa</label>
        <select name="makhoa" class="form-select" required>
          <option value="">-- Chọn Khoa --</option>
          <?php 
          // Cần reset con trỏ kết quả vì đã dùng ở trên
          if ($khoaList->num_rows > 0) {
              $khoaList->data_seek(0);
              while ($khoa = $khoaList->fetch_assoc()) { ?>
                <option value="<?= $khoa['makhoa'] ?>"><?= $khoa['tenkhoa'] ?></option>
              <?php }
          }
          ?>
        </select>
      </div>
      <div class="col-md-2">
        <button type="submit" name="add" class="btn btn-primary w-100">➕ Thêm</button>
      </div>
    </form>

    <table class="table table-bordered table-striped align-middle">
      <thead>
        <tr>
          <th>Mã lớp</th>
          <th>Tên lớp</th>
          <th>Khoa</th>
          <th>Trạng thái</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?= $row['malop'] ?></td>
            <td class="text-start"><?= $row['tenlop'] ?></td>
            <td class="text-start"><?= $row['tenkhoa'] ?></td>
            <td>
              <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['malop'] ?>">Sửa</button>
              <a href="lop.php?delete=<?= $row['malop'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa lớp [<?= $row['tenlop'] ?>] này?')">Xóa</a>
            </td>
          </tr>

          <div class="modal fade" id="editModal<?= $row['malop'] ?>" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <form method="post">
                  <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Sửa lớp học</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body text-start">
                    <input type="hidden" name="malop" value="<?= $row['malop'] ?>">
                    <p><strong>Mã lớp:</strong> <?= $row['malop'] ?></p>
                    <hr>
                    <div class="mb-3">
                      <label class="form-label">Tên lớp:</label>
                      <input type="text" name="tenlop" value="<?= $row['tenlop'] ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Khoa:</label>
                      <select name="makhoa" class="form-select" required>
                        <?php
                        // Cần chạy lại query để lấy danh sách khoa cho modal
                        $khoaAgain = $conn->query("SELECT * FROM khoa");
                        while ($k = $khoaAgain->fetch_assoc()) {
                          $selected = ($k['makhoa'] == $row['makhoa']) ? 'selected' : '';
                          echo "<option value='{$k['makhoa']}' $selected>{$k['tenkhoa']}</option>";
                        }
                        ?>
                      </select>
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
<?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>