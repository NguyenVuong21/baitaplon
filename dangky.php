<?php
include 'db_connect.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Lấy danh sách sinh viên và lớp học
$sinhvienList = $conn->query("SELECT * FROM sinhvien ORDER BY masv ASC");
$lopList = $conn->query("SELECT l.malop, l.tenlop, k.tenkhoa 
                         FROM lop l 
                         JOIN khoa k ON l.makhoa = k.makhoa 
                         ORDER BY l.malop ASC");

// Xử lý thêm đăng ký
if (isset($_POST['add'])) {
    $masv = $_POST['masv'];
    $malop = $_POST['malop'];
    $trangthai = $_POST['trangthai'];

    $stmt = $conn->prepare("INSERT INTO dangky (masv, malop, trangthai) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $masv, $malop, $trangthai);
    $stmt->execute();
    $stmt->close();

    header("Location: dangky.php");
    exit();
}

// Xử lý sửa đăng ký
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $masv = $_POST['masv'];
    $malop = $_POST['malop'];
    $trangthai = $_POST['trangthai'];

    $stmt = $conn->prepare("UPDATE dangky SET masv=?, malop=?, trangthai=? WHERE id=?");
    $stmt->bind_param("iisi", $masv, $malop, $trangthai, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: dangky.php");
    exit();
}

// Xử lý xóa đăng ký
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM dangky WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: dangky.php");
    exit();
}

// Lấy danh sách đăng ký (JOIN để hiển thị đầy đủ)
$result = $conn->query("
    SELECT d.id, s.masv, s.hoten, l.malop, l.tenlop, k.tenkhoa, d.trangthai
    FROM dangky d
    JOIN sinhvien s ON d.masv = s.masv
    JOIN lop l ON d.malop = l.malop
    JOIN khoa k ON l.makhoa = k.makhoa
    ORDER BY d.id DESC
");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản lý Đăng ký lớp học - Hồ sơ sinh viên</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f0f2f5;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .container {
      max-width: 1100px;
      background-color: #ffffff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      margin-top: 30px;
    }
    h3 {
      color: #1a73e8;
      border-bottom: 3px solid #e0ecff;
      padding-bottom: 15px;
      margin-bottom: 30px;
      font-weight: 600;
    }
    .form-area {
      padding: 20px;
      border-radius: 8px;
      background-color: #f7f9fc;
      border: 1px solid #e1e4e8;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
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
    .table th {
      background-color: #1a73e8;
      color: white;
      font-weight: 500;
      text-align: center;
    }
    .table td {
      vertical-align: middle;
      text-align: center;
    }
    .table td:nth-child(3), .table td:nth-child(4) {
        text-align: left;
    }
    .table-striped > tbody > tr:nth-of-type(odd) > * {
      background-color: #fbfdff;
    }
    .modal-header.bg-warning {
        background-color: #fbbc05 !important;
        color: #3c4043 !important;
    }
    form.form-area {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;  
  align-items: end;         
  gap: 15px;                 
}

form.form-area .col-md-3,
form.form-area .col-md-2 {
  flex: 1 1 220px;
  min-width: 200px;
}

form.form-area .col-md-2 {
  text-align: center;
}

form.form-area button.btn {
  width: auto;
  padding: 6px 18px;
  font-size: 14px;
  border-radius: 6px;
  font-weight: 600;
}
  </style>
</head>

<body>
  <?php include 'navbar.php'; ?>

  <div class="container">
    <a href="home.php" class="btn btn-secondary mb-3">← Quay lại Trang chủ</a>
    <h3>📝 Quản lý Đăng ký Lớp học</h3>

    <!-- Form thêm -->
    <form method="post" class="row g-2 mb-4 form-area">
      <div class="col-md-3">
        <select name="masv" class="form-select" required>
          <option value="" disabled selected>-- Chọn sinh viên --</option>
          <?php 
          $sinhvienList->data_seek(0);
          while ($sv = $sinhvienList->fetch_assoc()) { ?>
            <option value="<?= $sv['masv'] ?>"><?= $sv['masv'] ?> - <?= $sv['hoten'] ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md-3">
        <select name="malop" class="form-select" required>
          <option value="" disabled selected>-- Chọn lớp học --</option>
          <?php 
          $lopList->data_seek(0);
          while ($lop = $lopList->fetch_assoc()) { ?>
            <option value="<?= $lop['malop'] ?>"><?= $lop['tenlop'] ?> (<?= $lop['tenkhoa'] ?>)</option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md-3">
  <select name="trangthai" class="form-select" required>
    <option value="" disabled selected>-- Chọn trạng thái học --</option>
    <option value="Đang học">Đang học</option>
    <option value="Hoàn thành">Hoàn thành</option>
    <option value="Hủy">Hủy</option>
  </select>
</div>

      <div class="col-md-2">
        <button type="submit" name="add" class="btn btn-primary w-100">➕ Thêm</button>
      </div>
    </form>

    <!-- Bảng dữ liệu -->
    <table class="table table-bordered table-striped align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Mã SV</th>
          <th>Họ tên</th>
          <th>Lớp học</th>
          <th>Khoa</th>
          <th>Trạng thái</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $i = 1;
        while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= $row['masv'] ?></td>
            <td class="text-start"><?= $row['hoten'] ?></td>
            <td><?= $row['tenlop'] ?></td>
            <td><?= $row['tenkhoa'] ?></td>
            <td><?= $row['trangthai'] ?></td>
            <td>
              <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">Sửa</button>
              <a href="dangky.php?delete=<?= $row['id'] ?>" 
                 onclick="return confirm('Xóa đăng ký của sinh viên <?= $row['hoten'] ?>?')" 
                 class="btn btn-danger btn-sm">Xóa</a>
            </td>
          </tr>

          <!-- Modal Sửa -->
          <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <form method="post">
                  <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Sửa Đăng ký</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">

                    <div class="mb-3">
                      <label class="form-label">Sinh viên:</label>
                      <select name="masv" class="form-select" required>
                        <?php 
                        $sinhvienList->data_seek(0);
                        while ($sv = $sinhvienList->fetch_assoc()) {
                          $selected = $sv['masv'] == $row['masv'] ? 'selected' : '';
                          echo "<option value='{$sv['masv']}' $selected>{$sv['masv']} - {$sv['hoten']}</option>";
                        } ?>
                      </select>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Lớp học:</label>
                      <select name="malop" class="form-select" required>
                        <?php 
                        $lopList->data_seek(0);
                        while ($lop = $lopList->fetch_assoc()) {
                          $selected = $lop['malop'] == $row['malop'] ? 'selected' : '';
                          echo "<option value='{$lop['malop']}' $selected>{$lop['tenlop']} ({$lop['tenkhoa']})</option>";
                        } ?>
                      </select>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Trạng thái:</label>
                      <select name="trangthai" class="form-select" required>
                        <option value="Đang học" <?= $row['trangthai']=='Đang học'?'selected':'' ?>>Đang học</option>
                        <option value="Hoàn thành" <?= $row['trangthai']=='Hoàn thành'?'selected':'' ?>>Hoàn thành</option>
                        <option value="Hủy" <?= $row['trangthai']=='Hủy'?'selected':'' ?>>Hủy</option>
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