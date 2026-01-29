<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login | iSosial</title>
  <link rel="stylesheet" href="css/authentication.css">
</head>
<body class="auth-bg">

  <div class="auth-container">
    <div class="auth-left">
      <div class="image-wrapper">
        <img src="./images/login-img.png" alt="Relawan Sosial" class="login-image">
        <div class="image-overlay">
          <h1>iSosial</h1>
          <p class="tagline">Sistem Manajemen Relawan Sekolah</p>
        </div>
      </div>
    </div>

    <div class="auth-card">
      <h2>Login ke iSosial</h2>
      <p class="subtitle">Masukkan kredensial Anda untuk mengakses dashboard</p>
      
      <form id="loginForm">
        <div class="input-group">
          <label for="username">Email</label>
          <input type="text" id="username" placeholder="Contoh: bryan@gmail.com" required>
        </div>
        
        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" placeholder="Masukkan password" required>
        </div>
        
        <button type="submit" class="login-btn">Masuk</button>
        
        <div class="divider">
          <span>atau</span>
        </div>
      
        <p class="register-link">
          Belum punya akun? <a href="#">Daftar Sekarang</a>
        </p>
      </form>
    </div>
  </div>
</body>
</html>