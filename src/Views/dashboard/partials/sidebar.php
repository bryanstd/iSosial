<?php
/** @var array $user */
/** @var string $active */
$active = $active ?? '';
$isAdmin = ($user['role'] ?? '') === 'admin';
?>
<aside class="sidebar">
  <h2 class="logo">iSosial</h2>
  <ul class="menu">
    <li class="<?= $active === 'dashboard' ? 'active' : '' ?>">
      <a href="/dashboard">Dashboard</a>
    </li>
    <li class="<?= $active === 'kegiatan' ? 'active' : '' ?>">
      <a href="/dashboard/kegiatan">Manajemen Kegiatan</a>
    </li>
    <li class="<?= $active === 'relawan' ? 'active' : '' ?>">
      <a href="/dashboard/relawan">Pendaftaran Relawan</a>
    </li>
    <li class="<?= $active === 'riwayat' ? 'active' : '' ?>">
      <a href="/dashboard/riwayat">Riwayat Kegiatan</a>
    </li>
    <?php if ($isAdmin): ?>
    <li class="<?= $active === 'admin' ? 'active' : '' ?>">
      <a href="/dashboard/admin/users">Kelola pengguna</a>
    </li>
    <?php endif; ?>
    <li class="<?= $active === 'profile' ? 'active' : '' ?>">
      <a href="/dashboard/profile">Profil</a>
    </li>
    <li class="<?= $active === 'settings' ? 'active' : '' ?>">
      <a href="/dashboard/settings">Pengaturan</a>
    </li>
    <li class="menu-logout">
      <a href="/logout">Logout</a>
    </li>
  </ul>
</aside>
