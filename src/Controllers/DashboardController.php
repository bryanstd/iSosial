<?php

namespace App\Controllers;

use App\Models\UserModel;

class DashboardController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new UserModel();
    }

    private function loadKegiatanDemo(): array
    {
        $path = __DIR__ . '/../Data/kegiatan_demo.php';
        if (!is_readable($path)) {
            return [];
        }
        $data = require $path;
        return is_array($data) ? $data : [];
    }

    public function index()
    {
        $totalUsers = $this->userModel->countAll();
        $volunteerCount = $this->userModel->countByRole('user');
        $kegiatan = $this->loadKegiatanDemo();
        $totalKegiatan = count($kegiatan);
        $totalRelawanDibutuhkan = 0;
        foreach ($kegiatan as $row) {
            $totalRelawanDibutuhkan += (int) ($row['relawan_dibutuhkan'] ?? 0);
        }
        $riwayatSiswa = 164 + $totalUsers;
        $kegiatanTerbaru = array_slice($kegiatan, 0, 5);

        $this->render('/dashboard/index', [
            'user' => $this->user,
            'total_users' => $totalUsers,
            'volunteer_count' => $volunteerCount,
            'stat_total_kegiatan' => $totalKegiatan,
            'stat_relawan_dibutuhkan' => $totalRelawanDibutuhkan,
            'stat_riwayat_siswa' => $riwayatSiswa,
            'kegiatan_terbaru' => $kegiatanTerbaru,
        ]);
    }

    public function kegiatanIndex()
    {
        $kegiatan = $this->loadKegiatanDemo();
        $this->render('/dashboard/kegiatan', [
            'user' => $this->user,
            'kegiatan' => $kegiatan,
        ]);
    }

    public function riwayatIndex()
    {
        $kegiatan = $this->loadKegiatanDemo();
        $selesai = array_values(array_filter($kegiatan, function ($r) {
            return ($r['status'] ?? '') === 'Selesai';
        }));
        $this->render('/dashboard/riwayat', [
            'user' => $this->user,
            'kegiatan_selesai' => $selesai,
        ]);
    }

    public function profile()
    {
        $this->render('/dashboard/profile', ['user' => $this->user]);
    }

    public function settings()
    {
        $this->render('/dashboard/settings', ['user' => $this->user]);
    }

    public function adminPanel()
    {
        $this->redirect('/dashboard/admin/users');
    }

    public function adminUsers()
    {
        $this->requireAdmin();
        $message = $_SESSION['flash_ok'] ?? null;
        $error = $_SESSION['flash_err'] ?? null;
        unset($_SESSION['flash_ok'], $_SESSION['flash_err']);

        $this->render('/dashboard/admin_users', [
            'user' => $this->user,
            'users' => $this->userModel->findAll(),
            'message' => $message,
            'error' => $error,
        ]);
    }

    public function adminUserSave()
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/dashboard/admin/users');
            return;
        }

        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        $fullName = trim($_POST['full_name'] ?? '');
        $phone = trim($_POST['phone_number'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $role = trim($_POST['role'] ?? 'user');
        $password = $_POST['password'] ?? '';

        if (!in_array($role, ['user', 'admin'], true)) {
            $role = 'user';
        }

        if ($fullName === '' || $phone === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash_err'] = 'Nama, telepon, dan email valid wajib diisi.';
            $this->redirect('/dashboard/admin/users');
            return;
        }

        if ($id > 0) {
            if ($this->userModel->emailExistsForOtherUser($email, $id)) {
                $_SESSION['flash_err'] = 'Email sudah dipakai pengguna lain.';
                $this->redirect('/dashboard/admin/users');
                return;
            }
            if ($this->userModel->phoneExistsForOtherUser($phone, $id)) {
                $_SESSION['flash_err'] = 'Nomor telepon sudah dipakai pengguna lain.';
                $this->redirect('/dashboard/admin/users');
                return;
            }
            $hash = $password !== '' ? md5($password) : null;
            if ($this->userModel->updateUser($id, $fullName, $phone, $email, $role, $hash)) {
                $_SESSION['flash_ok'] = 'Data pengguna diperbarui.';
            } else {
                $_SESSION['flash_err'] = 'Gagal memperbarui pengguna.';
            }
        } else {
            if ($password === '') {
                $_SESSION['flash_err'] = 'Password wajib untuk pengguna baru.';
                $this->redirect('/dashboard/admin/users');
                return;
            }
            $res = $this->userModel->register($fullName, $phone, $email, md5($password), $role);
            if (is_array($res) && !empty($res['success'])) {
                $_SESSION['flash_ok'] = 'Pengguna baru ditambahkan.';
            } else {
                $_SESSION['flash_err'] = is_array($res) && isset($res['error']) ? $res['error'] : 'Gagal menambah pengguna.';
            }
        }

        $this->redirect('/dashboard/admin/users');
    }

    public function adminUserDelete()
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/dashboard/admin/users');
            return;
        }

        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        if ($id <= 0 || $id === (int) $this->user['id']) {
            $_SESSION['flash_err'] = 'Tidak dapat menghapus akun ini.';
            $this->redirect('/dashboard/admin/users');
            return;
        }

        if ($this->userModel->deleteById($id)) {
            $_SESSION['flash_ok'] = 'Pengguna dihapus.';
        } else {
            $_SESSION['flash_err'] = 'Gagal menghapus pengguna.';
        }
        $this->redirect('/dashboard/admin/users');
    }

    public function relawanIndex()
    {
        $message = $_SESSION['flash_ok'] ?? null;
        $error = $_SESSION['flash_err'] ?? null;
        unset($_SESSION['flash_ok'], $_SESSION['flash_err']);

        $this->render('/dashboard/relawan', [
            'user' => $this->user,
            'volunteers' => $this->userModel->findAllByRole('user'),
            'can_manage' => $this->isAdmin(),
            'message' => $message,
            'error' => $error,
        ]);
    }

    /**
     * Relawan = baris isosial_users dengan role "user". Hanya admin yang boleh ubah/tambah lewat halaman ini.
     */
    public function relawanSave()
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/dashboard/relawan');
            return;
        }

        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        $fullName = trim($_POST['full_name'] ?? '');
        $phone = trim($_POST['phone_number'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $roleUser = 'user';

        if ($fullName === '' || $phone === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash_err'] = 'Nama, telepon, dan email valid wajib diisi.';
            $this->redirect('/dashboard/relawan');
            return;
        }

        if ($id > 0) {
            $existing = $this->userModel->findById($id);
            if (!$existing || ($existing['role'] ?? '') !== 'user') {
                $_SESSION['flash_err'] = 'Data relawan tidak ditemukan atau bukan akun relawan (role user).';
                $this->redirect('/dashboard/relawan');
                return;
            }
            if ($this->userModel->emailExistsForOtherUser($email, $id)) {
                $_SESSION['flash_err'] = 'Email sudah dipakai pengguna lain.';
                $this->redirect('/dashboard/relawan');
                return;
            }
            if ($this->userModel->phoneExistsForOtherUser($phone, $id)) {
                $_SESSION['flash_err'] = 'Nomor telepon sudah dipakai pengguna lain.';
                $this->redirect('/dashboard/relawan');
                return;
            }
            $hash = $password !== '' ? md5($password) : null;
            if ($this->userModel->updateUser($id, $fullName, $phone, $email, $roleUser, $hash)) {
                $_SESSION['flash_ok'] = 'Data relawan diperbarui.';
            } else {
                $_SESSION['flash_err'] = 'Gagal memperbarui relawan.';
            }
        } else {
            if ($password === '') {
                $_SESSION['flash_err'] = 'Password wajib untuk relawan baru.';
                $this->redirect('/dashboard/relawan');
                return;
            }
            $res = $this->userModel->register($fullName, $phone, $email, md5($password), $roleUser);
            if (is_array($res) && !empty($res['success'])) {
                $_SESSION['flash_ok'] = 'Relawan (akun user) ditambahkan.';
            } else {
                $_SESSION['flash_err'] = is_array($res) && isset($res['error']) ? $res['error'] : 'Gagal menambah relawan.';
            }
        }

        $this->redirect('/dashboard/relawan');
    }

    public function relawanDelete()
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/dashboard/relawan');
            return;
        }

        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        if ($id <= 0 || $id === (int) $this->user['id']) {
            $_SESSION['flash_err'] = 'Tidak dapat menghapus akun ini.';
            $this->redirect('/dashboard/relawan');
            return;
        }

        $existing = $this->userModel->findById($id);
        if (!$existing || ($existing['role'] ?? '') !== 'user') {
            $_SESSION['flash_err'] = 'Hanya akun dengan role user (relawan) yang dapat dihapus di sini.';
            $this->redirect('/dashboard/relawan');
            return;
        }

        if ($this->userModel->deleteById($id)) {
            $_SESSION['flash_ok'] = 'Relawan dihapus.';
        } else {
            $_SESSION['flash_err'] = 'Gagal menghapus relawan.';
        }
        $this->redirect('/dashboard/relawan');
    }
}
