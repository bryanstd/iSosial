<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Akses ditolak</title>
  <link rel="stylesheet" href="/css/dashboard.css">
</head>
<body>
  <div class="container" style="justify-content: center; align-items: center;">
    <main class="main-content" style="max-width: 480px; text-align: center;">
      <h1 style="color: #b71c1c;">403</h1>
      <p><?= htmlspecialchars($message ?? 'Anda tidak memiliki akses ke halaman ini.', ENT_QUOTES, 'UTF-8') ?></p>
      <p style="margin-top: 1rem;"><a href="/dashboard" class="btn-primary" style="display: inline-block; text-decoration: none;">Kembali ke dashboard</a></p>
    </main>
  </div>
</body>
</html>
