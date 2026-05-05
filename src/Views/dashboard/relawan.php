<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Relawan - iSosial</title>
  <link rel="stylesheet" href="/css/dashboard.css">
</head>
<body>

<div class="container">
  <?php $active = 'relawan'; include __DIR__ . '/partials/sidebar.php'; ?>

  <main class="main-content">
    <header class="topbar dash-topbar">
      <h1 class="dash-title">Pendaftaran Relawan</h1>
      <div class="user-info dash-user">
        <span class="dash-user-label"><?= ($user['role'] ?? '') === 'admin' ? 'Admin' : htmlspecialchars($user['name'] ?? 'User', ENT_QUOTES, 'UTF-8') ?></span>
        <span class="dash-avatar" aria-hidden="true"><?= strtoupper(substr(($user['name'] ?? 'U'), 0, 1)) ?></span>
      </div>
    </header>

    <?php if (!empty($message)): ?>
      <div class="alert alert-success"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
      <div class="alert alert-error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <?php if (!empty($can_manage)): ?>
    <div class="table-section form-section" style="margin-top: 24px;">
      <h2 id="form-title">Tambah relawan (akun baru, role user)</h2>
      <form method="post" action="/dashboard/relawan/save" class="stack-form" id="relawan-form" autocomplete="off">
        <input type="hidden" name="id" id="relawan_id" value="0">
        <div class="form-row">
          <div class="form-group">
            <label for="full_name">Nama lengkap</label>
            <input id="full_name" name="full_name" required>
          </div>
          <div class="form-group">
            <label for="phone_number">Telepon</label>
            <input id="phone_number" name="phone_number" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" required>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" autocomplete="new-password">
            <small class="form-hint" id="password-hint">Wajib untuk akun baru.</small>
          </div>
        </div>
        <button type="submit" class="btn-primary" id="submit-btn">Simpan</button>
        <button type="button" class="btn-secondary" id="reset-form" style="display: none;">Batal edit</button>
      </form>
    </div>
    <?php endif; ?>

    <div class="table-section" style="margin-top: 24px;">
      <h2>Pengguna dengan role user (relawan)</h2>
      <?php if (empty($volunteers)): ?>
        <p class="lead">Belum ada akun dengan role user.</p>
      <?php else: ?>
        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th>Nama</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Role</th>
                <?php if (!empty($can_manage)): ?>
                <th>Aksi</th>
                <?php endif; ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($volunteers as $v): ?>
                <tr>
                  <td><?= htmlspecialchars($v['full_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                  <td><?= htmlspecialchars($v['phone_number'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                  <td><?= htmlspecialchars($v['email'] ?? '—', ENT_QUOTES, 'UTF-8') ?></td>
                  <td><span class="status aktif"><?= htmlspecialchars($v['role'] ?? 'user', ENT_QUOTES, 'UTF-8') ?></span></td>
                  <?php if (!empty($can_manage)): ?>
                  <td>
                    <div class="aksi">
                      <button type="button" class="btn-text btn-edit-relawan"
                        data-id="<?= (int) $v['id'] ?>"
                        data-name="<?= htmlspecialchars($v['full_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        data-phone="<?= htmlspecialchars($v['phone_number'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        data-email="<?= htmlspecialchars($v['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">Edit</button>
                      <form method="post" action="/dashboard/relawan/delete" class="inline-form" onsubmit="return confirm('Hapus akun relawan ini?');">
                        <input type="hidden" name="id" value="<?= (int) $v['id'] ?>">
                        <button type="submit" class="btn-text btn-danger-text">Hapus</button>
                      </form>
                    </div>
                  </td>
                  <?php endif; ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </main>
</div>

<?php if (!empty($can_manage)): ?>
<script>
(function () {
  var form = document.getElementById('relawan-form');
  var title = document.getElementById('form-title');
  var submitBtn = document.getElementById('submit-btn');
  var resetBtn = document.getElementById('reset-form');
  var passInput = document.getElementById('password');
  var passHint = document.getElementById('password-hint');

  function setEditMode(on) {
    title.textContent = on ? 'Edit relawan (tetap role user)' : 'Tambah relawan (akun baru, role user)';
    submitBtn.textContent = on ? 'Perbarui' : 'Simpan';
    resetBtn.style.display = on ? 'inline-block' : 'none';
    passInput.required = !on;
    passHint.textContent = on
      ? 'Kosongkan jika password tidak diubah.'
      : 'Wajib untuk akun baru.';
  }

  document.querySelectorAll('.btn-edit-relawan').forEach(function (btn) {
    btn.addEventListener('click', function () {
      document.getElementById('relawan_id').value = btn.getAttribute('data-id');
      document.getElementById('full_name').value = btn.getAttribute('data-name') || '';
      document.getElementById('phone_number').value = btn.getAttribute('data-phone') || '';
      document.getElementById('email').value = btn.getAttribute('data-email') || '';
      passInput.value = '';
      setEditMode(true);
      form.scrollIntoView({ behavior: 'smooth' });
    });
  });

  resetBtn.addEventListener('click', function () {
    form.reset();
    document.getElementById('relawan_id').value = '0';
    passInput.required = true;
    setEditMode(false);
  });
})();
</script>
<?php endif; ?>
</body>
</html>
