<?php
include 'db_connect.php';

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
} else {
    echo "Kết nối thành công!<br>";
}

// test thử query xem có bảng users không?
$sql = "SHOW TABLES LIKE 'users'";
$res = $conn->query($sql);

if ($res && $res->num_rows > 0) {
    echo "Tìm thấy bảng users.<br>";
} else {
    echo "Không tìm thấy bảng users!<br>";
}
?>
