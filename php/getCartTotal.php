// getCartTotal.php
<?php
// Tính lại tổng tiền hàng (chưa áp dụng giảm giá)
$totalNotDiscount = 0;
foreach ($cart as $item) {
    $totalNotDiscount += $item['productPrice'] * $item['productQuantity'];
}

// Tính lại tổng thành tiền (sau khi áp dụng giảm giá nếu có)
$totalOrderPrice = 0;
foreach ($cart as $item) {
    $totalOrderPrice += ($item['productPrice'] - ($item['productDiscount'] * $item['productPrice'] / 100)) * $item['productQuantity'];
}

// Trả về dữ liệu JSON cho Ajax
header('Content-Type: application/json');
echo json_encode([
    'totalNotDiscount' => number_format($totalNotDiscount, 0, ',', '.') . 'đ',
    'totalOrderPrice' => number_format($totalOrderPrice, 0, ',', '.') . 'đ'
]);
?>