<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // mã hóa MD5

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['username'] = $username;
        header("Location: home.php"); // chuyển đến trang chính
        exit();
    } else {
        echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu!'); window.history.back();</script>";
    }
}
?>

