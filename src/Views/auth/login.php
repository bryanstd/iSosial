<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login | iSosial</title>
  <link rel="stylesheet" href="/css/authentication.css">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body class="auth-bg">
  <?php
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    $flashMessage = $_SESSION['flash_message'] ?? null;
    unset($_SESSION['flash_message']);
  ?>

  <div class="auth-container">
    <div class="auth-left">
      <div class="image-wrapper">
        <img src="/images/login-img.png" alt="Relawan Sosial" class="login-image">
        <div class="image-overlay">
          <h1>iSosial</h1>
          <p class="tagline">Sistem Manajemen Relawan Sekolah</p>
        </div>
      </div>
    </div>

    <div class="auth-card">
      <h2>Login ke iSosial</h2>
      <p class="subtitle">Masukkan kredensial Anda untuk mengakses dashboard</p>
      
      <?php if (!empty($error)): ?>
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            swal("Error", "<?php echo addslashes($error); ?>", "error");
          });
        </script>
      <?php endif; ?>

      <?php if (!empty($flashMessage)): ?>
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            swal("Berhasil", "<?php echo addslashes($flashMessage); ?>", "success");
          });
        </script>
      <?php endif; ?>
      
      <form id="loginForm" method="POST" action="/login">
        <div class="input-group">
          <label for="email">Email</label>
          <input type="text" id="email" name="email" placeholder="Contoh: bryan@gmail.com" required>
        </div>
        
        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Masukkan password" required>
        </div>
        
        <button type="submit" class="login-btn">Masuk</button>
        
        <div class="divider">
          <span>atau</span>
        </div>
      
        <p class="register-link">
          Belum punya akun? <a href="/register">Daftar Sekarang</a>
        </p>
      </form>
    </div>
  </div>
</body>
</html>