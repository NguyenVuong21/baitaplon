<style>
    /* 🌿 Footer hiện đại */
/* Đảm bảo layout trang dùng Flexbox để footer bám đáy */
html, body {
  height: 100%;
  margin: 0;
  display: flex;
  flex-direction: column;
}

/* Main content chiếm toàn bộ phần còn lại của trang */
main {
  flex: 1;
}

/* 🎓 Footer đẹp và cố định ở cuối */
footer {
  background: linear-gradient(90deg, #1a73e8 0%, #1565c0 100%);
  color: #f8f9fa;
  text-align: center;
  padding: 10px 10px;
  box-shadow: 0 -3px 8px rgba(0, 0, 0, 0.1);
  letter-spacing: 0.3px;
  font-size: 15px;
  font-weight: 500;
  margin-top: auto; /* quan trọng: đẩy footer xuống cuối */
}

/* Chữ và liên kết */
footer span {
  color: #ffeb3b;
  font-weight: 600;
}

footer .footer-links {
  margin-top: 8px;
}

footer .footer-links a {
  color: #e3f2fd;
  text-decoration: none;
  margin: 0 10px;
  transition: color 0.3s ease;
}

footer .footer-links a:hover {
  color: #fff;
  text-decoration: underline;
}


</style>
<footer>
  <div class="footer-text">
    © 2025 <span>Đại học</span> | Hệ thống Quản lý Hồ sơ Sinh viên 🎓
  </div>
  <div class="footer-links">
    <a href="#">Về chúng tôi</a> |
    <a href="#">Liên hệ</a> |
    <a href="#">Chính sách bảo mật</a>
  </div>
</footer>

