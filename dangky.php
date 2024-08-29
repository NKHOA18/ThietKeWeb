<?php
require 'admin/php/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $firstname = $_POST['firstname'];
    $displayname = $_POST['displayname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];
    $password1 = $_POST['pass1'];
    $password2 = $_POST['pass2'];
    $address = $_POST['address'];

    // Kiểm tra xem tất cả các trường có được nhập đầy đủ không
    if(!empty($firstname) && !empty($displayname) && !empty($email) && !empty($phone) &&
       !empty($birthday) && !empty($gender) && !empty($password1) && !empty($password2) && !empty($address)) {
        
        // Xác nhận lại mật khẩu
        if($password1 !== $password2) {
            echo "Mật khẩu không khớp.";
            exit; // Dừng việc xử lý ngay tại đây nếu mật khẩu không khớp
        }

        // Mã hóa mật khẩu bằng hàm password_hash()
        $hashed_password = password_hash($password1, PASSWORD_DEFAULT);

        // Sử dụng Prepared Statements để chèn dữ liệu vào cơ sở dữ liệu
        $stmt = $conn->prepare("INSERT INTO `nguoi_dung`(`ho_nguoi_dung`, `ten_nguoi_dung`, `email`, `so_dien_thoai`, `mat_khau`, `dia_chi`, `gioi_tinh`, `ngay_sinh`, `ma_quyen`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, '0')");
        $stmt->bind_param("ssssssss", $firstname, $displayname, $email, $phone, $hashed_password, $address, $gender, $birthday);

        if($stmt->execute()) {
            echo "Lưu dữ liệu thành công.";
            header('Location: login.html'); // Chuyển hướng sau khi lưu dữ liệu thành công
            exit; // Dừng việc xử lý tiếp theo
        } else {
            echo "Có lỗi xảy ra: " . $stmt->error;
        }

        $stmt->close(); // Đóng Prepared Statement

    } else {
        echo "Bạn cần nhập đầy đủ thông tin.";
    }
}

?>
