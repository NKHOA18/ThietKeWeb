<?php
session_start();

// Xóa tất cả sản phẩm trong giỏ hàng
if (isset($_SESSION['cart'])) {
    unset($_SESSION['cart']);
    $response = array(
        'status' => 'success',
        'message' => 'Giỏ hàng đã được xóa.'
    );
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Giỏ hàng đã trống.'
    );
}

// Trả về phản hồi dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
