<?php
session_start();

// Kiểm tra nếu giá trị productIndex tồn tại và là số nguyên
if (isset($_POST['productIndex']) && is_numeric($_POST['productIndex'])) {
    $productIndex = intval($_POST['productIndex']);

    if (isset($_SESSION['cart'][$productIndex])) {
        unset($_SESSION['cart'][$productIndex]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Đảm bảo chỉ số mảng là liên tục

        // Tính lại các thông số cần trả về
        $cartTotal = count($_SESSION['cart']); // Tổng số sản phẩm trong giỏ hàng sau khi xóa
        $totalOrderPrice = calculateTotalOrderPrice($_SESSION['cart']); // Tính lại tổng thành tiền sau khi xóa
        $totalNotDiscount = calculateTotalNotDiscount($_SESSION['cart']);

        $response = array(
            'status' => 'success',
            'message' => 'Đã xóa sản phẩm khỏi giỏ hàng.',
            'cartTotal' => $cartTotal,
            'totalNotDiscount' => number_format($totalNotDiscount, 0, ',', '.'),
            'totalOrderPrice' => number_format($totalOrderPrice, 0, ',', '.'),
            'cartItems' => $_SESSION['cart'] // Danh sách sản phẩm còn lại trong giỏ hàng
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Không tìm thấy sản phẩm trong giỏ hàng.'
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Dữ liệu không hợp lệ.'
    );
}

// Trả về phản hồi dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($response);

// Hàm tính lại tổng thành tiền của giỏ hàng
function calculateTotalOrderPrice($cart) {
    $totalOrderPrice = 0;
    foreach ($cart as $item) {
        $totalOrderPrice += ($item['productPrice'] - ($item['productDiscount'] * $item['productPrice'] / 100)) * $item['productQuantity'];
    }
    return $totalOrderPrice;
}
function calculateTotalNotDiscount($cart) {
    $totalNotDiscount = 0;
    foreach ($cart as $item) {
        $totalNotDiscount += $item['productPrice'] * $item['productQuantity'];
    }
    return $totalNotDiscount;
}
?>
