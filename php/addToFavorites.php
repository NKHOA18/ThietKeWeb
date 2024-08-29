<?php
include_once '../admin/php/account.php';

$userInfo = null;
$response = array('status' => 'error', 'message' => '');

// Kiểm tra cookie và lấy thông tin người dùng
if (isset($_COOKIE['account']) && isset($_COOKIE['password'])) {
    $account = $_COOKIE['account'];
    $password = $_COOKIE['password'];

    // Kết nối cơ sở dữ liệu từ file config.php
    require '../admin/php/config.php';

    $accountClass = new Account($conn);
    $userInfo = $accountClass->getUser($account, $account);

    // Kiểm tra thông tin người dùng
    if (!$userInfo || !is_array($userInfo) || count($userInfo) === 0) {
        $response['message'] = "Thông tin đăng nhập không hợp lệ hoặc không tồn tại.";
        echo json_encode($response);
        exit();
    } 

    // Lấy user_id từ thông tin người dùng
    $user_id = $userInfo[0]['ma_so'];
}

// Kiểm tra dữ liệu được gửi từ phía client
if (isset($_POST['productId']) && isset($_POST['action'])) {
    $product_id = $_POST['productId'];
    $action = $_POST['action'];

    // Kiểm tra và xử lý dữ liệu
    if (!$user_id) {
        $response['message'] = 'Bạn cần đăng nhập để thực hiện chức năng này!';
    } else {
        if ($action === 'add') {
            // Chuẩn bị và thực thi truy vấn SQL để thêm vào bảng yeu_thich
            $query = $conn->prepare("INSERT INTO yeu_thich (ma_nguoi_dung, ma_san_pham) VALUES (?, ?)");
            $query->bind_param("ii", $user_id, $product_id);
        } else if ($action === 'remove') {
            // Chuẩn bị và thực thi truy vấn SQL để xóa khỏi bảng yeu_thich
            $query = $conn->prepare("DELETE FROM yeu_thich WHERE ma_nguoi_dung = ? AND ma_san_pham = ?");
            $query->bind_param("ii", $user_id, $product_id);
        } else {
            $response['message'] = 'Hành động không hợp lệ.';
            echo json_encode($response);
            exit();
        }

        if ($query->execute()) {
            $response['status'] = 'success';
        } else {
            $response['message'] = 'Đã có lỗi xảy ra khi xử lý yêu cầu.';
        }

        $query->close(); // Đóng truy vấn
    }

    $conn->close(); // Đóng kết nối CSDL

    // Trả về phản hồi JSON
    echo json_encode($response);
} else {
    // Nếu không có dữ liệu productId hoặc action được gửi đến từ phía client
    $response['message'] = 'Không tìm thấy mã sản phẩm hoặc hành động.';
    echo json_encode($response);
}
?>
