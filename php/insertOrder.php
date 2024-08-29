<?php
session_start();
require '../admin/php/config.php';

$cart = $_SESSION['cart'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    if (
        isset($_POST['userId']) &&
        isset($_POST['customer_display_name']) &&
        isset($_POST['customer_phone']) &&
        isset($_POST['customer_address']) &&
        isset($_POST['statusPayment'])
    ) {
        // Sanitize inputs
        $userId = intval($_POST['userId']);
        $displayName = mysqli_real_escape_string($conn, $_POST['customer_display_name']);
        $phone = mysqli_real_escape_string($conn, $_POST['customer_phone']);
        $address = mysqli_real_escape_string($conn, $_POST['customer_address']);
        $statusPayment = intval($_POST['statusPayment']);

        // Insert main order
        $sqlInsertOrder = "INSERT INTO don_hang (`ma_nguoi_dung`, `ten_nguoi_dung`, `so_dien_thoai`, `dia_chi`, `trang_thai_thanh_toan`, `trang_thai_don_hang`)
                           VALUES (?, ?, ?, ?, ?, '1')"; // Assuming `trang_thai_don_hang` default to 1
        $stmtInsertOrder = $conn->prepare($sqlInsertOrder);
        $stmtInsertOrder->bind_param('isssi', $userId, $displayName, $phone, $address, $statusPayment);

        if ($stmtInsertOrder->execute()) {
            $lastOrderId = $stmtInsertOrder->insert_id; // Get newly inserted order ID

            // Loop through each item in the cart and insert into chi_tiet_don_hang table
            foreach ($cart as $item) {
                $productId = $item['productId'];
                $productAttributeId = $item['productAttributeId']; // Assuming this is the attribute ID
                $gia = ($item['productPrice'] - $item['productPrice'] * ($item['productDiscount'] / 100)) * $item['productQuantity']; // Assuming this is the price
                $soLuong = $item['productQuantity']; // Assuming this is the quantity
                
                // Insert chi tiet don hang
                $sqlInsertChiTiet = "INSERT INTO chi_tiet_don_hang (`ma_don_hang`, `ma_san_pham`, `ma_thuoc_tinh_sp`, `gia`, `so_luong`) 
                                     VALUES (?, ?, ?, ?, ?)";
                $stmtInsertChiTiet = $conn->prepare($sqlInsertChiTiet);
                $stmtInsertChiTiet->bind_param('iiidi', $lastOrderId, $productId, $productAttributeId, $gia, $soLuong);
                
                if (!$stmtInsertChiTiet->execute()) {
                    $response = [
                        'status' => 'error',
                        'message' => 'Lỗi khi thêm chi tiết đơn hàng: ' . $stmtInsertChiTiet->error
                    ];
                    break;
                }
                
                $stmtInsertChiTiet->close();
            }
            
            if (!isset($response)) {
                // Success inserting chi tiet don hang
                $response = [
                    'status' => 'success',
                    'message' => 'Đã thêm đơn hàng và chi tiết đơn hàng thành công.',
                    'orderId' => $lastOrderId
                ];
            }
        } else {
            // Error inserting main order
            $response = [
                'status' => 'error',
                'message' => 'Lỗi khi thêm đơn hàng chính: ' . $stmtInsertOrder->error
            ];
        }

        // Close connections
        $stmtInsertOrder->close();
        $conn->close();
    } else {
        // Missing or invalid parameters
        $response = ['error' => 'Missing or invalid parameters'];
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Invalid request method
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(['error' => 'Invalid request method']);
}
?>
