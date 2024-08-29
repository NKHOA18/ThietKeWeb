<?php
include_once('../admin/php/config.php'); // Ensure the correct path

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Fetch wishlist data
$sql_yeu_thich = "SELECT `ma_san_pham`, COUNT(*) as count FROM `yeu_thich` GROUP BY `ma_san_pham`";
$stmt_yeu_thich = $conn->prepare($sql_yeu_thich);
$stmt_yeu_thich->execute();
$result_yeu_thich = $stmt_yeu_thich->get_result();

$yeu_thich_counts = [];
while ($row = $result_yeu_thich->fetch_assoc()) {
    $yeu_thich_counts[$row['ma_san_pham']] = $row['count'];
}

// Fetch order counts
$sql_don_hang = "SELECT `ma_san_pham`, COUNT(*) as count FROM `chi_tiet_don_hang` GROUP BY `ma_san_pham`";
$stmt_don_hang = $conn->prepare($sql_don_hang);
$stmt_don_hang->execute();
$result_don_hang = $stmt_don_hang->get_result();

$order_counts = [];
while ($row = $result_don_hang->fetch_assoc()) {
    $order_counts[$row['ma_san_pham']] = $row['count'];
}

$conn->close();

header('Content-Type: application/json');
echo json_encode(['yeu_thich_counts' => $yeu_thich_counts, 'order_counts' => $order_counts]);
?>
