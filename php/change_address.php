<?php
require '../admin/php/config.php';
include_once '../admin/php/account.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namedb = $_POST['name'];
    $phonedb= $_POST['phone'];
    $addressdb = $_POST['address'];

    function validatePhone($phone) {
        return preg_match('/^(09|03|07|08|05)+([0-9]{8})\b/', $phone);
    }

    if (!validatePhone($phonedb)) {
        echo json_encode(array("success" => false, "message" => "Số điện thoại không hợp lệ!"));
        exit();
    }
    if (empty($namedb)) {
        echo json_encode(array("success" => false, "message" => "Bạn cần nhập tên mới!"));
        exit();
    }
    if (strlen($addressdb) <= 8) {
        echo json_encode(array("success" => false, "message" => "Địa chỉ bạn nhập không rõ!"));
        exit();
    }

    $account = $_COOKIE['account'];
    $accountClass = new Account($conn);
    $userInfo = $accountClass->getUser($account, $account);

    $email = $userInfo[0]['email'];
    $result = $accountClass->updateAddress($namedb, $phonedb, $addressdb, $email);

    if ($result) {
        // Trả về thông tin người dùng đã cập nhật thành công
        $updatedUserInfo = $accountClass->getUser($account, $account); // Lấy thông tin người dùng sau khi cập nhật

        echo json_encode(array(
            "success" => true,
            "message" => "Cập nhật thông tin thành công.",
            "data" => $updatedUserInfo[0]
        ));
    } else {
        echo json_encode(array("success" => false, "message" => "Đã xảy ra lỗi khi cập nhật thông tin. Vui lòng thử lại sau."));
    }
    exit();
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request method."));
    exit();
}
?>
