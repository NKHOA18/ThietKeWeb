<?php
require 'admin/php/config.php';
include_once 'admin/php/account.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $oldPassword = $_POST['customer_pass_old'];
    $newPassword1 = $_POST['customer_pass_new1'];
    $newPassword2 = $_POST['customer_pass_new2'];

    // Kiểm tra mật khẩu mới có khớp nhau không
    if ($newPassword1 !== $newPassword2) {
        echo json_encode(array("success" => false, "message" => "Mật khẩu mới không khớp. Vui lòng nhập lại."));
    } elseif (strlen($newPassword1) < 7 || strlen($newPassword1) > 32) {
        echo json_encode(array("success" => false, "message" => "Mật khẩu phải chứa ít nhất 8 ký tự và nhiều nhất 32 ký tự. Vui lòng nhập lại."));
        exit();
    }

    // Kiểm tra mật khẩu cũ có đúng không
    // Lấy thông tin từ cookie
    $account = $_COOKIE['account'];
    $password = $_COOKIE['password'];

    $accountClass = new Account($conn);
    $userInfo = $accountClass->getUser($account, $account);

    if (!$userInfo || password_verify($oldPassword, $userInfo[0]['mat_khau']) === false) {
        echo json_encode(array("success" => false, "message" => "Mật khẩu hiện tại không đúng."));
        exit();
    }

    // Mật khẩu hợp lệ, thực hiện cập nhật mật khẩu mới
    $hashedNewPassword = password_hash($newPassword1, PASSWORD_DEFAULT);
    $email = $userInfo[0]['email'];
    $result = $accountClass->forgetpass($hashedNewPassword, $email);

    if ($result) {
        echo json_encode(array("success" => true, "message" => "Cập nhật mật khẩu thành công."));
        exit();
    } else {
        echo json_encode(array("success" => false, "message" => "Đã xảy ra lỗi khi cập nhật mật khẩu. Vui lòng thử lại sau."));
        exit();
    }
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request method."));
    exit();
}
?>
