<?php
session_start();

// Kiểm tra nếu giá trị productIndex và newQuantity tồn tại và là số nguyên dương
if (isset($_POST['productIndex']) && is_numeric($_POST['productIndex']) && isset($_POST['newQuantity']) && is_numeric($_POST['newQuantity']) && intval($_POST['newQuantity']) >= 0) {
    $productIndex = intval($_POST['productIndex']);
    $newQuantity = intval($_POST['newQuantity']);

    if (isset($_SESSION['cart'][$productIndex])) {
        $_SESSION['cart'][$productIndex]['productQuantity'] = $newQuantity;

        // Tính lại các thông số cần trả về
        $cartTotal = count($_SESSION['cart']); // Tổng số sản phẩm trong giỏ hàng sau khi cập nhật
        $totalOrderPrice = calculateTotalOrderPrice($_SESSION['cart']); // Tính lại tổng thành tiền sau khi cập nhật
        $totalNotDiscount = calculateTotalNotDiscount($_SESSION['cart']);

        $response = array(
            'status' => 'success',
            'message' => 'Đã cập nhật số lượng sản phẩm trong giỏ hàng.',
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

// Hàm tính lại tổng tiền chưa giảm giá của giỏ hàng
function calculateTotalNotDiscount($cart) {
    $totalNotDiscount = 0;
    foreach ($cart as $item) {
        $totalNotDiscount += $item['productPrice'] * $item['productQuantity'];
    }
    return $totalNotDiscount;
}
?>
