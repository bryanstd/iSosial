<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola pengguna - iSosial</title>
  <link rel="stylesheet" href="/css/dashboard.css">
</head>
<body>

<div class="container">
  <?php $active = 'admin'; include __DIR__ . '/partials/sidebar.php'; ?>

  <main class="main-content">
    <header class="topbar dash-topbar">
      <h1 class="dash-title">Kelola pengguna</h1>
      <div class="user-info dash-user">
        <span class="dash-user-label">Admin</span>
        <span class="dash-avatar" aria-hidden="true"><?= strtoupper(substr(($user['name'] ?? 'A'), 0, 1)) ?></span>
      </div>
    </header>

    <?php if (!empty($message)): ?>
      <div class="alert alert-success"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
      <div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="table-section form-section">
      <h2>Tambah pengguna baru</h2>
      <form method="post" action="/dashboard/admin/users/save" class="stack-form">
        <input type="hidden" name="id" value="0">
        <div class="form-row">
          <div class="form-group">
            <label for="new_full_name">Nama lengkap</label>
            <input id="new_full_name" name="full_name" required>
          </div>
          <div class="form-group">
            <label for="new_phone">Telepon</label>
            <input id="new_phone" name="phone_number" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="new_email">Email</label>
            <input id="new_email" name="email" type="email" required>
          </div>
          <div class="form-group">
            <label for="new_role">Peran</label>
            <select id="new_role" name="role">
              <option value="user">user</option>
              <option value="admin">admin</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="new_password">Password</label>
          <input id="new_password" name="password" type="password" required>
        </div>
        <button type="submit" class="btn-primary">Simpan pengguna</button>
      </form>
    </div>

    <div class="table-section" style="margin-top: 24px;">
      <h2>Daftar pengguna</h2>
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Telepon</th>
              <th>Peran</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users ?? [] as $row): ?>
              <tr>
                <td><?= (int) $row['id'] ?></td>
                <td><?= htmlspecialchars($row['full_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['email'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['phone_number'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><span class="status <?= ($row['role'] ?? '') === 'admin' ? 'selesai' : 'aktif' ?>"><?= htmlspecialchars($row['role'] ?? '', ENT_QUOTES, 'UTF-8') ?></span></td>
                <td>
                  <div class="aksi">
                    <button type="button" class="btn-text btn-edit-user" data-id="<?= (int) $row['id'] ?>"
                      data-name="<?= htmlspecialchars($row['full_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                      data-phone="<?= htmlspecialchars($row['phone_number'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                      data-email="<?= htmlspecialchars($row['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                      data-role="<?= htmlspecialchars($row['role'] ?? 'user', ENT_QUOTES, 'UTF-8') ?>">Edit</button>
                    <?php if ((int) $row['id'] !== (int) ($user['id'] ?? 0)): ?>
                      <form method="post" action="/dashboard/admin/users/delete" class="inline-form" onsubmit="return confirm('Hapus pengguna ini?');">
                        <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
                        <button type="submit" class="btn-text btn-danger-text">Hapus</button>
                      </form>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div id="edit-panel" class="table-section form-section" style="margin-top: 24px; display: none;">
      <h2>Edit pengguna</h2>
      <form method="post" action="/dashboard/admin/users/save" class="stack-form" id="edit-user-form">
        <input type="hidden" name="id" id="edit_id" value="">
        <div class="form-row">
          <div class="form-group">
            <label for="edit_full_name">Nama lengkap</label>
            <input id="edit_full_name" name="full_name" required>
          </div>
          <div class="form-group">
            <label for="edit_phone">Telepon</label>
            <input id="edit_phone" name="phone_number" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="edit_email">Email</label>
            <input id="edit_email" name="email" type="email" required>
          </div>
          <div class="form-group">
            <label for="edit_role">Peran</label>
            <select id="edit_role" name="role">
              <option value="user">user</option>
              <option value="admin">admin</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="edit_password">Password baru (kosongkan jika tidak diubah)</label>
          <input id="edit_password" name="password" type="password" autocomplete="new-password">
        </div>
        <button type="submit" class="btn-primary">Perbarui</button>
        <button type="button" class="btn-secondary" id="cancel-edit">Batal</button>
      </form>
    </div>
  </main>
</div>

<script>
(function () {
  var panel = document.getElementById('edit-panel');
  var form = document.getElementById('edit-user-form');
  document.querySelectorAll('.btn-edit-user').forEach(function (btn) {
    btn.addEventListener('click', function () {
      document.getElementById('edit_id').value = btn.getAttribute('data-id');
      document.getElementById('edit_full_name').value = btn.getAttribute('data-name') || '';
      document.getElementById('edit_phone').value = btn.getAttribute('data-phone') || '';
      document.getElementById('edit_email').value = btn.getAttribute('data-email') || '';
      document.getElementById('edit_role').value = btn.getAttribute('data-role') === 'admin' ? 'admin' : 'user';
      document.getElementById('edit_password').value = '';
      panel.style.display = 'block';
      panel.scrollIntoView({ behavior: 'smooth' });
    });
  });
  document.getElementById('cancel-edit').addEventListener('click', function () {
    panel.style.display = 'none';
  });
})();
</script>
</body>
</html>
