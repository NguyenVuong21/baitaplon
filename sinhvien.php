<?php
include 'db_connect.php';
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}

// Lấy danh sách lớp để hiển thị trong form
$lopList = $conn->query("SELECT * FROM lop");

// Thêm sinh viên
if (isset($_POST['add'])) {
  $masv = $_POST['masv'];
  $hoten = $_POST['hoten'];
  $ngaysinh = $_POST['ngaysinh'];
  $gioitinh = $_POST['gioitinh'];
  $diachi = $_POST['diachi'];
  $malop = $_POST['malop'];

  $stmt = $conn->prepare("INSERT INTO sinhvien(masv, hoten, ngaysinh, gioitinh, diachi, malop) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssss", $masv, $hoten, $ngaysinh, $gioitinh, $diachi, $malop);
  $stmt->execute();
  $stmt->close();
  header("Location: sinhvien.php");
  exit();
}

// Xóa sinh viên
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];

  $stmt = $conn->prepare("DELETE FROM sinhvien WHERE masv=?");
  $stmt->bind_param("s", $id);
  $stmt->execute();
  $stmt->close();
  header("Location: sinhvien.php");
  exit();
}

// Sửa sinh viên
if (isset($_POST['edit'])) {
  $masv = $_POST['masv'];
  $hoten = $_POST['hoten'];
  $ngaysinh = $_POST['ngaysinh'];
  $gioitinh = $_POST['gioitinh'];
  $diachi = $_POST['diachi'];
  $malop = $_POST['malop'];

  $stmt = $conn->prepare("UPDATE sinhvien SET hoten=?, ngaysinh=?, gioitinh=?, diachi=?, malop=? WHERE masv=?");
  $stmt->bind_param("ssssss", $hoten, $ngaysinh, $gioitinh, $diachi, $malop, $masv);
  $stmt->execute();
  $stmt->close();
  header("Location: sinhvien.php");
  exit();
}

// Lấy danh sách sinh viên + tên lớp
$result = $conn->query("SELECT sinhvien.*, lop.tenlop, lop.malop AS lop_malop FROM sinhvien 
                        LEFT JOIN lop ON sinhvien.malop = lop.malop
                        ORDER BY masv ASC");
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Quản lý Sinh viên - Hồ sơ sinh viên đại học</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #eaf3ff 0%, #f8fbff 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 1150px;
      background-color: #ffffff;
      padding: 45px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
      margin-top: 50px;
      animation: fadeIn 0.6s ease;
    }

    h3 {
      color: #1a73e8;
      border-bottom: 3px solid #dce9ff;
      padding-bottom: 12px;
      margin-bottom: 30px;
      font-weight: 700;
      letter-spacing: 0.4px;
      text-align: left;
    }

    form.row.g-3.mb-4.align-items-end {
      background-color: #f8fbff;
      padding: 25px 30px;
      border-radius: 12px;
      border: 1px solid #e3e6ea;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
      align-items: end;
      transition: box-shadow 0.3s ease;
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      justify-content: space-between;
    }

    form.row.g-3.mb-4.align-items-end:hover {
      box-shadow: 0 6px 18px rgba(26, 115, 232, 0.15);
    }

    form.row.g-3.mb-4.align-items-end>div:not(:last-child) {
      flex: 1 1 calc(16% - 10px);
      min-width: 150px;
    }

    form.row.g-3.mb-4.align-items-end>.col-md-2:last-child {
      flex: 1 1 100%;
      text-align: center;
      margin-top: 10px;
    }

    form.row.g-3.mb-4.align-items-end button.btn-primary {
      width: 200px;
    }

    .form-label {
      font-weight: 500;
      color: #3c4043;
      font-size: 14px;
    }

    .form-control,
    .form-select {
      border-radius: 8px;
      border: 1px solid #ccd5e0;
      transition: border-color 0.25s, box-shadow 0.25s;
      font-size: 14px;
      background-color: #fff;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: #1a73e8;
      box-shadow: 0 0 0 0.25rem rgba(26, 115, 232, 0.25);
      outline: none;
    }

    .btn-primary {
      background-color: #1a73e8;
      border-color: #1a73e8;
      font-weight: 600;
      font-size: 13px;
      border-radius: 6px;
      padding: 6px 0px;
      max-width: 100px;
      transition: all 0.3s ease;
      display: block;
      margin: 10px auto 0;
    }

    .btn-primary:hover {
      background-color: #0b4eaf;
      transform: translateY(-1px);
      box-shadow: 0 3px 8px rgba(26, 115, 232, 0.25);
    }

    .btn-primary:active {
      transform: scale(0.97);
      box-shadow: none;
    }

    .table {
      font-size: 15px;
      border-radius: 12px;
      overflow: hidden;
      border: 1px solid #e3e6ea;
      margin-top: 15px;
    }

    .table th {
      background-color: #1a73e8;
      color: #ffffff;
      font-weight: 600;
      vertical-align: middle;
      padding: 12px;
      letter-spacing: 0.3px;
    }

    .table td {
      vertical-align: middle;
      padding: 10px;
    }

    .table-striped>tbody>tr:nth-of-type(odd)>* {
      background-color: #f7faff;
    }

    .table tbody tr:hover {
      background-color: #eef5ff;
      transition: 0.25s;
    }

    .btn-warning {
      background-color: #fbbc05;
      border-color: #fbbc05;
      color: #3c4043;
      font-weight: 500;
      transition: 0.2s;
    }

    .btn-warning:hover {
      background-color: #e6aa04;
    }

    .btn-danger {
      background-color: #ea4335;
      border-color: #ea4335;
      transition: 0.2s;
    }

    .btn-danger:hover {
      background-color: #d93025;
    }

    .modal-content {
      border-radius: 12px;
      border: none;
      box-shadow: 0 6px 22px rgba(0, 0, 0, 0.15);
    }

    .modal-header.bg-warning {
      background-color: #fbbc05 !important;
      color: #3c4043 !important;
    }

    .modal-title {
      font-weight: 600;
      letter-spacing: 0.3px;
    }

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
    <h3>🎓 Quản lý Sinh viên</h3>

    <form method="post" class="row g-3 mb-4 align-items-end">
      <div class="col-md-2">
        <label class="form-label visually-hidden">Mã SV</label>
        <input type="text" name="masv" class="form-control" placeholder="Mã SV" required>
      </div>
      <div class="col-md-3">
        <label class="form-label visually-hidden">Họ tên</label>
        <input type="text" name="hoten" class="form-control" placeholder="Họ tên" required>
      </div>
      <div class="col-md-2">
        <label class="form-label visually-hidden">Ngày sinh</label>
        <input type="date" name="ngaysinh" class="form-control" required>
      </div>
      <div class="col-md-2">
        <label class="form-label visually-hidden">Giới tính</label>
        <select name="gioitinh" class="form-select" required>
          <option value="">Giới tính</option>
          <option value="Nam">Nam</option>
          <option value="Nữ">Nữ</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label visually-hidden">Địa chỉ</label>
        <input type="text" name="diachi" class="form-control" placeholder="Địa chỉ">
      </div>
      <div class="col-md-3">
        <label class="form-label visually-hidden">Lớp</label>
        <select name="malop" class="form-select" required>
          <option value="">-- Chọn Lớp --</option>
          <?php
          if ($lopList->num_rows > 0) {
            $lopList->data_seek(0);
            while ($lop = $lopList->fetch_assoc()) { ?>
              <option value="<?= $lop['malop'] ?>"><?= $lop['tenlop'] ?></option>
          <?php }
          }
          ?>
        </select>
      </div>
      <div class="col-md-2">
        <button type="submit" name="add" class="btn btn-primary w-100">➕ Thêm SV</button>
      </div>
    </form>

    <table class="table table-bordered table-striped align-middle text-center">
      <thead>
        <tr>
          <th>Mã SV</th>
          <th>Họ tên</th>
          <th>Ngày sinh</th>
          <th>Giới tính</th>
          <th>Địa chỉ</th>
          <th>Lớp</th>
          <th>Điểm</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?= $row['masv'] ?></td>
            <td class="text-start"><?= $row['hoten'] ?></td>
            <td><?= $row['ngaysinh'] ?></td>
            <td><?= $row['gioitinh'] ?></td>
            <td class="text-start"><?= $row['diachi'] ?></td>
            <td><?= $row['tenlop'] ?></td>
            <td>
              <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['masv'] ?>">Sửa</button>
              <a href="sinhvien.php?delete=<?= $row['masv'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên [<?= $row['hoten'] ?> - <?= $row['masv'] ?>] không?')">Xóa</a>
            </td>
          </tr>

          <div class="modal fade" id="editModal<?= $row['masv'] ?>" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <form method="post">
                  <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Sửa thông tin sinh viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body text-start">
                    <input type="hidden" name="masv" value="<?= $row['masv'] ?>">
                    <p><strong>Mã SV:</strong> <?= $row['masv'] ?></p>
                    <hr>
                    <div class="mb-2">
                      <label class="form-label">Họ tên:</label>
                      <input type="text" name="hoten" value="<?= $row['hoten'] ?>" class="form-control" required>
                    </div>
                    <div class="mb-2">
                      <label class="form-label">Ngày sinh:</label>
                      <input type="date" name="ngaysinh" value="<?= $row['ngaysinh'] ?>" class="form-control" required>
                    </div>
                    <div class="mb-2">
                      <label class="form-label">Giới tính:</label>
                      <select name="gioitinh" class="form-select" required>
                        <option value="Nam" <?= $row['gioitinh'] == 'Nam' ? 'selected' : '' ?>>Nam</option>
                        <option value="Nữ" <?= $row['gioitinh'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                      </select>
                    </div>
                    <div class="mb-2">
                      <label class="form-label">Địa chỉ:</label>
                      <input type="text" name="diachi" value="<?= $row['diachi'] ?>" class="form-control">
                    </div>
                    <div class="mb-2">
                      <label class="form-label">Lớp:</label>
                      <select name="malop" class="form-select" required>
                        <?php
                        // Cần chạy lại query để lấy danh sách lớp cho modal
                        $lopAgain = $conn->query("SELECT * FROM lop");
                        while ($l = $lopAgain->fetch_assoc()) {
                          // So sánh với mã lớp (malop) của sinh viên hiện tại
                          $sel = ($l['malop'] == $row['malop']) ? 'selected' : '';
                          echo "<option value='{$l['malop']}' $sel>{$l['tenlop']}</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="edit" class="btn btn-success">Lưu thay đổi</button>
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