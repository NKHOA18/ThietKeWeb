<?php
// getCartData.php
session_start();

if (!isset($_SESSION['cart'])) {
    echo json_encode(['status' => 'error', 'message' => 'Giỏ hàng trống']);
    exit;
}

$cart = $_SESSION['cart'];
$totalOrderPrice = 0;
$totalNotDiscount = 0;

foreach ($cart as $item) {
    $totalOrderPrice += ($item['productPrice'] - $item['productPrice'] * ($item['productDiscount'] / 100)) * $item['productQuantity'];
    $totalNotDiscount += $item['productPrice'] * $item['productQuantity'];
}

$response = [
    'status' => 'success',
    'cartItems' => $cart,
    'totalOrderPrice' => $totalOrderPrice,
    'totalNotDiscount' => $totalNotDiscount,
];

echo json_encode($response);
?>