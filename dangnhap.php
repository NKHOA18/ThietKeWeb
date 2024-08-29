<?php
require 'admin/php/config.php';

$response = ['success' => false, 'message' => ''];

if (isset($_POST['but_login_email'])) {
    $account = $_POST['account'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM nguoi_dung WHERE email = ? OR so_dien_thoai = ?");
    $stmt->bind_param("ss", $account, $account);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($result->num_rows > 0) {
        // So sánh mật khẩu đã nhập với mật khẩu đã lưu trong cơ sở dữ liệu
        if (password_verify($password, $row['mat_khau'])) {
            if ($row['ma_quyen'] == 1) {
                $response['success'] = true;
                $response['redirect'] = 'admin/admin.html';
            } else {
                $response['success'] = true;
                $response['redirect'] = 'infouser.php';
            }
        } else {
            $response['message'] = 'Tên đăng nhập hoặc mật khẩu không hợp lệ';
        }
    } else {
        $response['message'] = 'Tên đăng nhập hoặc mật khẩu không hợp lệ';
    }

    $stmt->close();
} else {
    $response['message'] = 'Vui lòng nhập đầy đủ thông tin đăng nhập';
}

echo json_encode($response);
?>
