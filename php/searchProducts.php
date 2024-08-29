<?php
include_once('../admin/php/config.php'); // Ensure the correct path

// Check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search query from the URL parameters
$searchQuery = isset($_GET['q']) ? $_GET['q'] : '';

// SQL query to fetch products
$sql = "SELECT sp.ma_so, sp.ten_san_pham, sp.hinh_anh, sp.gia, sp.muc_giam, sp.ngay_tao, tt.ma_mau_sac, tt.ma_kich_co
        FROM san_pham sp
        LEFT JOIN the_loai tl ON sp.ma_the_loai = tl.ma_so
        LEFT JOIN thuoc_tinh_san_pham tt ON tt.ma_san_pham = sp.ma_so";

if ($searchQuery) {
    $sql .= " WHERE sp.ten_san_pham LIKE ?";
}

$stmt = $conn->prepare($sql);
if ($searchQuery) {
    $searchParam = "%" . $searchQuery . "%";
    $stmt->bind_param("s", $searchParam);
}

$stmt->execute();
$result = $stmt->get_result();

$products = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($products);

$stmt->close();
$conn->close();
?>

