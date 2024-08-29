<?php
// Kết nối cơ sở dữ liệu từ file config.php
require 'admin/php/config.php';

// Kiểm tra xem yêu cầu là POST và có các trường thông tin cần thiết không
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['gioi_tinh']) && isset($_POST['email'])) {
    // Lấy giá trị mới từ yêu cầu POST
    $gioi_tinh = $_POST['gioi_tinh'];
    $email = $_POST['email'];

    // Lấy thông tin người dùng từ cookie hoặc session
    $userInfo = null;
    if (isset($_COOKIE['account'])) {
        $account = $_COOKIE['account'];
        // Lấy thông tin người dùng từ cơ sở dữ liệu
        $stmt = $conn->prepare("SELECT * FROM nguoi_dung WHERE email = ? OR so_dien_thoai = ?");
        $stmt->bind_param('ss', $account, $account);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $userInfo = $result->fetch_assoc();
        }
    }

    // Kiểm tra nếu có thông tin người dùng và có thể cập nhật giới tính và email
    if ($userInfo) {
        // Cập nhật giới tính và email cho người dùng
        $stmt = $conn->prepare("UPDATE nguoi_dung SET gioi_tinh = ?, email = ? WHERE email = ? OR so_dien_thoai = ?");
        $stmt->bind_param('isss', $gioi_tinh, $email, $account, $account);
        if ($stmt->execute()) {
            // Trả về phản hồi JSON với thông báo thành công
            $response = array(
                'success' => true,
                'message' => 'Cập nhật thông tin hồ sơ thành công.'
            );
            echo json_encode($response);
        } else {
            // Trả về phản hồi JSON với thông báo lỗi
            $response = array(
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi cập nhật thông tin hồ sơ.'
            );
            echo json_encode($response);
        }
    } else {
        // Trả về phản hồi JSON nếu không tìm thấy thông tin người dùng
        $response = array(
            'success' => false,
            'message' => 'Không tìm thấy thông tin người dùng.'
        );
        echo json_encode($response);
    }
} else {
    // Trả về phản hồi JSON nếu yêu cầu không hợp lệ
    $response = array(
        'success' => false,
        'message' => 'Yêu cầu không hợp lệ.'
    );
    echo json_encode($response);
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
