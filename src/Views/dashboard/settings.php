<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pengaturan - iSosial</title>
  <link rel="stylesheet" href="/css/dashboard.css">
</head>
<body>

<div class="container">
  <?php $active = 'settings'; include __DIR__ . '/partials/sidebar.php'; ?>

  <main class="main-content">
    <header class="topbar dash-topbar">
      <h1 class="dash-title">Pengaturan</h1>
      <div class="user-info dash-user">
        <span class="dash-user-label"><?= htmlspecialchars($user['name'] ?? 'User', ENT_QUOTES, 'UTF-8') ?></span>
        <span class="dash-avatar" aria-hidden="true"><?= strtoupper(substr(($user['name'] ?? 'U'), 0, 1)) ?></span>
      </div>
    </header>

    <div class="table-section">
      <p class="lead">Pengaturan akun lanjutan dapat ditambahkan di sini (notifikasi, preferensi, dll.).</p>
      <p style="margin-top: 12px;"><a href="/dashboard" class="link-inline">Kembali ke dashboard</a></p>
    </div>
  </main>
</div>

</body>
</html>
