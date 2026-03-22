<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Kegiatan Sosial</title>
  <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

  <div class="container">

    <!-- Sidebar -->
    <aside class="sidebar">
      <h2 class="logo">iSosial</h2>
      <ul class="menu">
        <li class="active">Dashboard</li>
        <li>Manajemen Kegiatan</li>
        <li>Pendaftaran Relawan</li>
        <li>Riwayat Kegiatan</li>
        <li><a href="/logout">Logout</a></li>
      </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      
      <!-- Topbar -->
      <div class="topbar">
        <h1>Dashboard</h1>
        <div class="user-info">
          <span>Admin</span>
          <img src="avatar.png" alt="Avatar" class="avatar">
        </div>
      </div>

      <!-- Cards -->
      <div class="cards">
        <div class="card">
          <h3>Total Kegiatan</h3>
          <p>12</p>
        </div>

        <div class="card">
          <h3>Total Relawan</h3>
          <p>85</p>
        </div>

        <div class="card">
          <h3>Kegiatan Aktif</h3>
          <p>5</p>
        </div>

        <div class="card">
          <h3>Riwayat Siswa</h3>
          <p>150</p>
        </div>
      </div>

      <!-- Table -->
      <div class="table-section">
        <h2>Daftar Kegiatan Terbaru</h2>
        <table>
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
            <tr>
              <td>Bakti Sosial Panti Asuhan</td>
              <td>20 Feb 2026</td>
              <td>Pontianak</td>
              <td>20</td>
              <td><span class="status aktif">Aktif</span></td>
            </tr>
            <tr>
              <td>Donor Darah</td>
              <td>25 Feb 2026</td>
              <td>Aula Sekolah</td>
              <td>15</td>
              <td><span class="status aktif">Aktif</span></td>
            </tr>
            <tr>
              <td>Kerja Bakti Lingkungan</td>
              <td>10 Feb 2026</td>
              <td>Adi Sucipto</td>
              <td>30</td>
              <td><span class="status selesai">Selesai</span></td>
            </tr>
          </tbody>
        </table>
      </div>

    </main>

  </div>

</body>
</html>