<?php
// Kết nối đến cơ sở dữ liệu
require '../admin/php/config.php'; // Đảm bảo rằng file này chứa thông tin kết nối

// Lấy dữ liệu từ request GET (hoặc POST tùy theo phương thức gửi dữ liệu)
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $ma_mau_sac = $_GET['ma_mau_sac']; // Thay đổi tên biến tùy vào tên trường trong form
    $ma_kich_co = $_GET['ma_kich_co']; // Thay đổi tên biến tùy vào tên trường trong form

    // Câu truy vấn SQL để kiểm tra sự tồn tại của mã số thuộc tính và lấy mã số thuộc tính nếu tồn tại
    $sql = "SELECT ma_so
            FROM thuoc_tinh_san_pham
            WHERE ma_mau_sac = ? AND ma_kich_co = ?";
    
    // Chuẩn bị và thực thi câu truy vấn sử dụng prepared statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $ma_mau_sac, $ma_kich_co); // 'ii' cho hai integer (ma_mau_sac và ma_kich_co)
    $stmt->execute();
    $result = $stmt->get_result();

    // Lấy kết quả từ câu truy vấn
    $row = $result->fetch_assoc();

    if ($row) {
        // Nếu tồn tại, trả về mã số thuộc tính
        $ma_so = $row['ma_so'];
        $response = [
            'exists' => true,
            'ma_so' => $ma_so
        ];
    } else {
        // Nếu không tồn tại, trả về exists = false
        $response = [
            'exists' => false
        ];
    }

    // Trả về kết quả dưới dạng JSON
    header('Content-Type: application/json');
    echo json_encode($response);

    // Đóng kết nối
    $stmt->close();
    $conn->close();
} else {
    // Phương thức yêu cầu không hợp lệ
    header("HTTP/1.1 405 Method Not Allowed");
    echo "Phương thức yêu cầu không hợp lệ";
}
?>
