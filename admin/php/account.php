<?php
require 'config.php';

class Account {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getUser($email, $phone) {
        $stmt = $this->db->prepare("SELECT * FROM nguoi_dung WHERE email = ? OR so_dien_thoai = ?");
        $stmt->bind_param('ss', $email, $phone);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }

    public function getEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM nguoi_dung WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    public function forgetPass($pass, $email) {
        $stmt = $this->db->prepare("UPDATE nguoi_dung SET mat_khau = ? WHERE email = ?");
        $stmt->bind_param('ss', $pass, $email);
        return $stmt->execute();
    }

    public function updateAddress($name, $phone, $address, $email) {
        $stmt = $this->db->prepare("UPDATE nguoi_dung SET ten_nguoi_dung = ?, so_dien_thoai = ?, dia_chi = ? WHERE email = ?");
        $stmt->bind_param('ssss', $name, $phone, $address, $email);
        return $stmt->execute();
    }
}
?>
