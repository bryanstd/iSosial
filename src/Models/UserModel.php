<?php
namespace App\Models;

class UserModel {
    private $db;

    public function __construct() {
        require_once __DIR__ . '/../Config/Database.php';
        $this->db = isosial_db_connection();
    }

    public function login($email, $password) {
        $password = md5($password);

        $sql = "SELECT * FROM isosial_users WHERE email = ? AND password = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($password == $user['password']) {
                return $user;
            }
        }
        return false;
    }

    public function register($fullname, $phonenum, $email, $password, $role) {
        $checkEmailSql = "SELECT id FROM isosial_users WHERE email = ?";
        $checkStmt = $this->db->prepare($checkEmailSql);
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        
        if ($checkResult->num_rows > 0) {
            return [
                'success' => false,
                'error' => 'Email sudah terdaftar'
            ];
        }

        $checkPhoneSql = "SELECT id FROM isosial_users WHERE phone_number = ?";
        $checkPhoneStmt = $this->db->prepare($checkPhoneSql);
        $checkPhoneStmt->bind_param("s", $phonenum);
        $checkPhoneStmt->execute();
        $checkPhoneResult = $checkPhoneStmt->get_result();
        
        if ($checkPhoneResult->num_rows > 0) {
            return [
                'success' => false,
                'error' => 'Nomor telepon sudah terdaftar'
            ];
        }
        
        $sql = "INSERT INTO isosial_users (full_name, phone_number, email, password, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sssss", 
            $fullname,
            $phonenum,
            $email,
            $password,
            $role
        );
        
        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => 'Registrasi berhasil',
                'user_id' => $stmt->insert_id
            ];
        } else {
            return [
                'success' => false,
                'error' => 'Registrasi gagal: ' . $this->db->error
            ];
        }
    }

    public function findAllByRole($role)
    {
        $sql = "SELECT id, full_name, phone_number, email, role FROM isosial_users WHERE role = ? ORDER BY id ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $role);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function countByRole($role)
    {
        $sql = "SELECT COUNT(*) AS c FROM isosial_users WHERE role = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $role);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res ? $res->fetch_assoc() : null;
        return (int) ($row['c'] ?? 0);
    }

    public function findAll()
    {
        $sql = "SELECT id, full_name, phone_number, email, role FROM isosial_users ORDER BY id ASC";
        $result = $this->db->query($sql);
        if (!$result) {
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($id)
    {
        $sql = "SELECT id, full_name, phone_number, email, role FROM isosial_users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows ? $res->fetch_assoc() : null;
    }

    public function countAll()
    {
        $res = $this->db->query("SELECT COUNT(*) AS c FROM isosial_users");
        if (!$res) {
            return 0;
        }
        $row = $res->fetch_assoc();
        return (int) ($row['c'] ?? 0);
    }

    public function updateUser($id, $fullName, $phone, $email, $role, $newPasswordHash = null)
    {
        if ($newPasswordHash !== null && $newPasswordHash !== '') {
            $sql = "UPDATE isosial_users SET full_name = ?, phone_number = ?, email = ?, role = ?, password = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("sssssi", $fullName, $phone, $email, $role, $newPasswordHash, $id);
        } else {
            $sql = "UPDATE isosial_users SET full_name = ?, phone_number = ?, email = ?, role = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ssssi", $fullName, $phone, $email, $role, $id);
        }
        return $stmt->execute();
    }

    public function deleteById($id)
    {
        $sql = "DELETE FROM isosial_users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function emailExistsForOtherUser($email, $excludeId)
    {
        $sql = "SELECT id FROM isosial_users WHERE email = ? AND id != ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("si", $email, $excludeId);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function phoneExistsForOtherUser($phone, $excludeId)
    {
        $sql = "SELECT id FROM isosial_users WHERE phone_number = ? AND id != ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("si", $phone, $excludeId);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }
}
