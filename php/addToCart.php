<?php
session_start();

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $product = [
        'productId' => $data['productId'],
        'productAttributeId' => $data['productAttributeId'],
        'productName' => $data['productName'],
        'productImage' => $data['productImage'],
        'productColor' => $data['productColor'],
        'productSize' => $data['productSize'],
        'productDiscount' => $data['productDiscount'],
        'productQuantity' => $data['productQuantity'],
        'productPrice' => $data['productPrice']
    ];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $_SESSION['cart'][] = $product;

    echo json_encode(['status' => 'success', 'message' => 'Product added to cart']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No data received']);
}
?>
