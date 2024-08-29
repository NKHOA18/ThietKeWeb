<?php
require 'admin/php/config.php';

// Lấy tất cả các email từ cơ sở dữ liệu
$query = "SELECT email, so_dien_thoai FROM nguoi_dung";
$result = $conn->query($query);

$data = ['emails' => [], 'phones' => []]; // Khởi tạo mảng chứa email và số điện thoại

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data['emails'][] = $row['email'];
        $data['phones'][] = $row['so_dien_thoai']; // Thêm số điện thoại vào mảng
    }
}

echo json_encode($data);
?>
