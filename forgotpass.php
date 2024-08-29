<?php
session_start();
ob_start();

include_once 'PHPMailer/index.php';
include_once 'admin/php/account.php';

$mail = new Mailer();
$user = new Account($conn); // Sử dụng kết nối từ config.php

$error = array(); // Khởi tạo mảng lỗi ở ngoài để sử dụng trong form

if (isset($_POST['pwdrst'])) {
    $email = $_POST['email'];
    if ($email == '') {
        $error['email'] = "Không được để trống";
    }
    if (empty($error)) {
        $result = $user->getemail($email);
        if ($result) {
            $code = substr(rand(0, 999999), 0, 6);
            $title = "Quên mật khẩu";
            $content = "Mã xác thực của bạn là: <span style='color:green'>" . $code . "</span>";
            $sendResult = $mail->sendMail($title, $content, $email);

            if ($sendResult === true) {
                $_SESSION['mail'] = $email;
                $_SESSION['code'] = $code;
                $_SESSION['code_expiry'] = time() + 300; // Mã xác thực hết hạn sau 5 phút
                header('location: verification.php');
                exit(); // Đảm bảo không tiếp tục thực hiện mã sau header
            } else {
                echo $sendResult; // Hiển thị thông báo lỗi nếu email không gửi được
            }
        } else {
            $error['email'] = "Tài khoản email không hợp lệ";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="css/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="css/style.css">
    <title>NKstore</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Slick Slider JS -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    
</head>
<body>
    <!-- header -->
<!-- <header class="d-flex" > -->
<?php include 'header.php'; ?>

<!-- header -->



<!-------------------------------- forgotpass ---------------------------------->
<section class="login">
    <div class="container">
        <div class="auth auth-forgotpass">
    <div class="auth-container">
        <div class="auth-forgotpass">
            <div class="auth__login auth__block">
                <h3 class="auth__title">Bạn muốn tìm lại mật khẩu?</h3>
                <div class="auth__login__content">
                    <p class="auth__description">
                        Vui lòng nhập lại số điện thoại đã đăng ký, hệ thống của chúng tôi sẽ gửi cho bạn 1 đường dẫn để thay đổi mật khẩu.
                    </p>
                    <?php
        if (!empty($error)) {
            echo '<div class="alert alert-danger alert-dismissable fade show" style="margin-bottom: 10px; margin-top: 10px; color: red">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <strong>Lỗi!</strong> ';
            foreach ($error as $err) {
                echo $err . '<br>';
            }
            echo '</div>';
        }
        ?>
                    <form class="auth__form" role="login" enctype="application/x-www-form-urlencoded" name="frm_register" method="post" action="">
                        <div class="form-group">
                            <input class="form-control" type="text" name="email" placeholder="Email ..." required="">
                        </div>
                        
                        <div class="auth__form__buttons">
                            <button type="submit" class="btn btn--large" name="pwdrst">Gửi đi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
</section>
<!-------------------------------- forgotpass ---------------------------------->
<!-- footer -->
<footer class="footer p-4">
    <div class="container-ft">
        <div class="row main-footer">
            <div class="left-footer col-md-6">
                <div class="top-left">
                    <div class="logo-ft"><img src="assets/images/logoNK.png" alt="logons"></div>
                    <div class="logo-ft"><img src="assets/images/dmca.png" alt="dmca"></div>
                    <div class="logo-ft"><img src="assets/images/img-congthuong.png" alt="congthuong"></div>
                </div>
                <div class="info-left-ft">
                    <p>Công ty Cổ Phần ... với số đăng ký kinh doanh:...</p>
                    <p><strong>Địa chỉ đăng ký: </strong>P. Hiệp Bình Phước, TP. Thủ Đức, TP. Hồ Chí Minh</p>
                    <p><strong>Số điện thoại: </strong>0432 324 242/ 090 124 1241</p>
                    <p><strong>Email: </strong>cskh@NKstore.index.php</p>
                </div>
                <div class="socials-ft">
                    <ul class="list-social">
                        <li><a href=""><img src="assets/images/ic_fb.svg" style="height: 30px;" alt=""></a></li>
                        <li><a href=""><img src="assets/images/ic_gg.svg" style="height: 30px;" alt=""></a></li>
                        <li><a href=""><img src="assets/images/ic_instagram.svg" style="height: 30px;" alt=""></a></li>
                        <li><a href=""><img src="assets/images/ic_pinterest.svg" style="height: 30px;" alt=""></a></li>
                        <li><a href=""><img src="assets/images/ic_ytb.svg" style="height: 30px;" alt=""></a></li>
    
                    </ul>
                    <div class="hotline">
                        <a href="">Hot online : 0423 002 020</a>
                    </div>
                </div>
                
            </div>
            
            <div class="right-footer col-md-6">
                <div class="register-form">
                    <p class="title-footer">Nhận thông tin các chương trình của NKstore</p>
                    <form action="">
                        <input type="text" name="email" placeholder="Nhập địa chỉ email của bạn" required="required">
                        <div class="btn-submit">
                            <input type="submit" class="form-submit" value="Đăng ký">
                        </div>
                    </form>
                </div>
                <div class="info-right-ft row">
                    <p class="title-footer">Download App</p>
                    <ul class="d-flex">
                        <li><a href=""><img src="assets/images/appstore.png" width="180" alt="" style="padding-right: 20px;"></a></li>
                        <li><a href=""><img src="assets/images/googleplay.png" width="160" alt=""></a></li>
                    </ul>
                </div>
            </div>
            
            
            
            
        </div>
    </div>
</footer>
<!-- footer -->


<!-- <script src="js/slider.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script src="js/menu.js"></script>
    <script src="js/cart.js"></script>
</body>
</html>

   

