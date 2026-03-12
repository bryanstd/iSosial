<?php
namespace App\Models;

class UserModel {
    private $db;

    public function __construct() {
        require_once '../src/Config/Database.php';
        $this->db = $connection;
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
}
