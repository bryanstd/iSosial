<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register | iSosial</title>
  <link rel="stylesheet" href="/css/authentication.css">
</head>
<body class="auth-bg">

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
      <h2>Daftar ke iSosial</h2>
      <p class="subtitle">Ayo bergabung dengan iSosial sebagai relawan.</p>
      
      <form method="POST" action="/register">
        <div class="input-group">
          <label for="fullname">Full Name</label>
          <input type="text" id="fullname" name="fullname" placeholder="Masukan nama lengkap" required>
        </div>

        <div class="input-group">
          <label for="phonenum">Phone Number</label>
          <input type="text" id="phonenum" name="phonenum" placeholder="Masukan nomor telepon" required>
        </div>

        <div class="input-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Masukan email" required>
        </div>
        
        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Masukan password" required>
        </div>
        
        <button type="submit" class="login-btn">Daftar</button>
        
        <div class="divider">
          <span>atau</span>
        </div>
      
        <p class="register-link">
          Sudah punya akun? <a href="/login">Login Sekarang</a>
        </p>
      </form>
    </div>
  </div>
</body>
</html>