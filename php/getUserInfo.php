<?php
session_start();
include_once '../admin/php/account.php';

$response = array('status' => 'error', 'message' => 'Unknown error');

// Kiểm tra cookie và lấy thông tin người dùng
if (isset($_COOKIE['account']) && isset($_COOKIE['password'])) {
    $account = $_COOKIE['account'];
    $password = $_COOKIE['password'];

    // Kết nối cơ sở dữ liệu từ file config.php
    require '../admin/php/config.php';

    $accountClass = new Account($conn);
    $userInfo = $accountClass->getUser($account, $password); // Bạn nên kiểm tra cả tài khoản và mật khẩu

    // Kiểm tra thông tin người dùng
    if ($userInfo && is_array($userInfo) && count($userInfo) > 0) {
        $response['status'] = 'success';
        $response['data'] = array(
            'user_id' => $userInfo[0]['ma_so'],
            'user_firstname' => $userInfo[0]['ho_nguoi_dung'],
            'user_name' => $userInfo[0]['ten_nguoi_dung'],
            'user_phone' => $userInfo[0]['so_dien_thoai'],
            'user_address' => $userInfo[0]['dia_chi']
        );
    } else {
        $response['message'] = 'Thông tin người dùng không hợp lệ hoặc không tồn tại.';
    }
} else {
    $response['message'] = 'Cookie không tồn tại hoặc không hợp lệ.';
}

echo json_encode($response);
exit();
?>
