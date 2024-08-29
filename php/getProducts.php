<?php
include_once('../admin/php/config.php'); // Đảm bảo đường dẫn hợp lý

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$page = isset($_GET['page']) ? intval($_GET['page']) : 1; 
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 30; 
$category_id = isset($_GET['category']) ? intval($_GET['category']) : null; // Mã thể loại sản phẩm

// Tính toán OFFSET
$offset = ($page - 1) * $limit;

// Câu truy vấn SQL
$sql = "SELECT sp.ma_so, sp.ten_san_pham, sp.hinh_anh, sp.gia, sp.muc_giam, sp.ngay_tao, sp.trang_thai, tt.ma_mau_sac, tt.ma_kich_co
        FROM san_pham sp
        LEFT JOIN the_loai tl ON sp.ma_the_loai = tl.ma_so
        LEFT JOIN thuoc_tinh_san_pham tt ON tt.ma_san_pham = sp.ma_so";

// Áp dụng điều kiện thể loại nếu có
if ($category_id) {
    $sql .= " WHERE tl.ma_so = $category_id";
}

// Thêm LIMIT và OFFSET vào câu truy vấn
$sql .= " LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);

$products = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Trả về kết quả dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($products);

$conn->close();
?>

