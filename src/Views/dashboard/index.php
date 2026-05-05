<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - iSosial</title>
  <link rel="stylesheet" href="/css/dashboard.css">
</head>
<body>

<div class="container">
  <?php $active = 'dashboard'; include __DIR__ . '/partials/sidebar.php'; ?>

  <main class="main-content">
    <header class="topbar dash-topbar">
      <h1 class="dash-title">Dashboard</h1>
      <div class="user-info dash-user">
        <span class="dash-user-label"><?= ($user['role'] ?? '') === 'admin' ? 'Admin' : htmlspecialchars($user['name'] ?? 'User', ENT_QUOTES, 'UTF-8') ?></span>
        <span class="dash-avatar" aria-hidden="true"><?= strtoupper(substr(($user['name'] ?? 'U'), 0, 1)) ?></span>
      </div>
    </header>

    <div class="cards dash-cards">
      <div class="card dash-card">
        <h3>Total Kegiatan</h3>
        <p><?= (int) ($stat_total_kegiatan ?? 0) ?></p>
      </div>
      <div class="card dash-card">
        <h3>Total Relawan Dibutuhkan</h3>
        <p><?= (int) ($stat_relawan_dibutuhkan ?? 0) ?></p>
      </div>
      <div class="card dash-card">
        <h3>Riwayat Siswa</h3>
        <p><?= (int) ($stat_riwayat_siswa ?? 0) ?></p>
      </div>
    </div>

    <section class="table-section dash-table-block" id="kegiatan">
      <h2 class="dash-table-title">Daftar Kegiatan Terbaru</h2>
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
            <?php foreach ($kegiatan_terbaru ?? [] as $row): ?>
              <tr>
                <td><?= htmlspecialchars($row['nama'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['tanggal'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['lokasi'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= (int) ($row['relawan_dibutuhkan'] ?? 0) ?></td>
                <td>
                  <?php $st = $row['status'] ?? 'Aktif'; ?>
                  <span class="status <?= $st === 'Aktif' ? 'aktif' : 'selesai' ?>"><?= htmlspecialchars($st, ENT_QUOTES, 'UTF-8') ?></span>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>
</div>

</body>
</html>
