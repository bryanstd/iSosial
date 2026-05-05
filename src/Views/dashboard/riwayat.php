<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Kegiatan - iSosial</title>
  <link rel="stylesheet" href="/css/dashboard.css">
</head>
<body>

<div class="container">
  <?php $active = 'riwayat'; include __DIR__ . '/partials/sidebar.php'; ?>

  <main class="main-content">
    <header class="topbar dash-topbar">
      <h1 class="dash-title">Riwayat Kegiatan</h1>
      <div class="user-info dash-user">
        <span class="dash-user-label"><?= ($user['role'] ?? '') === 'admin' ? 'Admin' : htmlspecialchars($user['name'] ?? 'User', ENT_QUOTES, 'UTF-8') ?></span>
        <span class="dash-avatar" aria-hidden="true"><?= strtoupper(substr(($user['name'] ?? 'U'), 0, 1)) ?></span>
      </div>
    </header>

    <section class="table-section dash-table-block">
      <h2 class="dash-table-title">Kegiatan Selesai</h2>
      <div class="table-wrap">
        <table class="dash-table">
          <thead>
            <tr>
              <th>Nama Kegiatan</th>
              <th>Tanggal</th>
              <th>Lokasi</th>
              <th>Relawan Dibutuhkan</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($kegiatan_selesai)): ?>
              <tr><td colspan="5" class="text-center" style="padding: 24px; color: #666;">Belum ada kegiatan berstatus selesai.</td></tr>
            <?php else: ?>
              <?php foreach ($kegiatan_selesai as $row): ?>
              <tr>
                <td><?= htmlspecialchars($row['nama'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['tanggal'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['lokasi'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= (int) ($row['relawan_dibutuhkan'] ?? 0) ?></td>
                <td><span class="status selesai">Selesai</span></td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>
</div>

</body>
</html>
