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
        $sql = "INSERT INTO isosial_users (full_name, phone_number, email, password, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sssss", 
            $fullname,
            $phonenum,
            $email,
            $password,
            $role
        );
        
        return $stmt->execute();
    }
}