<?php

include_once 'admin/php/account.php';

$userInfo = null;

if (isset($_COOKIE['account']) && isset($_COOKIE['password'])) {
    $account = $_COOKIE['account'];
    $password = $_COOKIE['password'];

    // Kết nối cơ sở dữ liệu từ file config.php
    require 'admin/php/config.php';

    $accountClass = new Account($conn);
    $userInfo = $accountClass->getUser($account, $account);

    if (!$userInfo) {
        echo "Thông tin đăng nhập không hợp lệ hoặc không tồn tại.";
        exit();
    } 

    // Kiểm tra mật khẩu nếu cần
    // ...

    $conn->close();
}

if (!$userInfo) {
    echo "Không có thông tin người dùng được tìm thấy.";
    exit();
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
    <!-- <script src="js/sub-action.js" defer></script> -->
</head>
<body>
    <!-- header -->
<!-- <header class="d-flex" > -->
<?php include 'header.php'; ?>

<!-- header -->



<!-------------------------------- infouser ---------------------------------->
<section class="login">
    <div class="container">
        
        <div class="breadcrumb-products">
            <ol class="breadcrumb__list">
                <li class="breadcrumb__item"><a class="breadcrumb__link" href="">Trang chủ</a></li>
                <li class="breadcrumb__item"><a href="customer/info" class="breadcrumb__link" title="Tài khoản của tôi">Tài khoản của tôi</a></li>
            </ol>
        </div>
    
        <div class="order-wrapper mt-40 my-account">
            <div class="row">
                <div class="col-lg-4 col-xl-auto">
                    <div class="order-sidemenu block-border">
                        <div class="order-sidemenu__user">
                            <div class="order-sidemenu__user-avatar">
                                <img src="assets/images/user-avatar.png" alt="">
                            </div>
                            <div class="order-sidemenu__user-name">
                                <p><?php echo $userInfo[0]['ho_nguoi_dung']." ".$userInfo[0]['ten_nguoi_dung']; ?></p>
                            </div>
                        </div>
                        <div class="order-sidemenu__menu">
                            <ul>
                                <li class="active">
                                    <a href="/nkstore/infouser.php"><span class="fas fa-user"></span>Thông tin tài khoản</a>
                                </li>
                                <li class="d-none">
                                    <a href="customer/login_log"><span class="icon-ic_padlock"></span>Lịch sử đăng nhập</a>
                                </li>
                                <li class="">
                                    <a href="/nkstore/customer/order_list.php"><span class="fa fa-tasks"></span>Quản lý đơn hàng</a>
                                </li>
                                <li class="">
                                    <a href="/nkstore/customer/address_list.php"><span class="fa fa-location-arrow"></span>Sổ địa chỉ</a>
                                </li>
                                <li class="d-none">
                                    <a href="customer/san-pham-da-xem"><span class="icon-ic_glasses"></span>Sản phẩm đã xem</a>
                                </li>
                                <li class="">
                                    <a href="/nkstore/customer/san-pham-yeu-thich.php"><span class="fa fa-heart-o"></span>Sản phẩm yêu thích</a>
                                </li>
                                <li class="">
                                    <a href="/nkstore/customer/question.php"><span class="fas fa-headset"></span>Hỏi đáp sản phẩm</a>
                                </li>
                                <li class="">
                                    <a href="/nkstore/customer/nk-support.php"><span class="fa fa-hand-o-right"></span>Hỗ trợ - NKstore</a>
                                </li>
                            </ul>
                        </div>

                          
                    </div>
                </div>
                <div class="col-lg-8 col-xl" style=" left : -120px;">
                    <div class="order-block__title" data-id="<?php echo $userInfo[0]['ma_so']; ?>">
                        <h2>TÀI KHOẢN CỦA TÔI</h2>
                    </div>
                    <div class="order-block my-account-wrapper">
                        <p class="alert alert-primary">"Vì chính sách an toàn thẻ, bạn không thể thay đổi SĐT, Ngày sinh, Họ tên. Vui lòng liên hệ CSKH 0235558683 để được hỗ trợ"</p>
                        <div class="col-md-12">
                            <form enctype="application/x-www-form-urlencoded" name="frm_register" method="post" action="">
                                <div class="row form-group">
                                    <div class="col col-label">
                                        <label>Họ</label>
                                    </div>
                                    <div class="col col-input">
                                        <input class="form-control" value="<?php echo $userInfo[0]['ho_nguoi_dung']; ?>" type="text" disabled="disabled">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-label">
                                        <label>Tên</label>
                                    </div>
                                    <div class="col col-input">
                                        <input class="form-control" value="<?php echo $userInfo[0]['ten_nguoi_dung']; ?>" type="text" disabled="disabled">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-label">
                                        <label>Số điện thoại</label>
                                    </div>
                                    <div class="col col-input has-button">
                                        <input value="<?php echo $userInfo[0]['so_dien_thoai']; ?>" class="form-control" type="text" id="customer_phone" disabled="disabled">
                                        <!--<a class="btn btn--large input-append" id="change_phone">
                                            Xác nhận
                                        </a>-->
                                    </div>
                                </div>
                                
                                <div class="row form-group">
                                    <div class="col col-label">
                                        <label>Email</label>
                                    </div>
                                    <div class="col col-input has-button">
                                        <input class="form-control" type="text" value="<?php echo $userInfo[0]['email']; ?>" id="customer_email" name="customer_email">
                                        <!--<a class="btn btn--large input-append" id="changeEmail">
                                            Thay đổi
                                        </a>-->
                                    </div>
                                </div>
                                <div class="row form-radio-checkbox form-group">
                                    <div class="col col-label">
                                        <label>Giới tính</label>
                                    </div>
                                    <div class="col col-input">
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <label class="form-radio">
                                                    <input class="form-radio__input" type="radio" name="customer_sex" value="1" <?php echo ($userInfo[0]['gioi_tinh'] == 1) ? 'checked' : ''; ?>><span class="form-radio__label">Nữ</span>
                                                </label>
                                                <label class="form-radio">
                                                    <input class="form-radio__input" type="radio" name="customer_sex" value="2" <?php echo ($userInfo[0]['gioi_tinh'] == 2) ? 'checked' : ''; ?>><span class="form-radio__label">Nam</span>
                                                </label>
                                                <label class="form-radio">
                                                    <input class="form-radio__input" type="radio" name="customer_sex" value="3" <?php echo ($userInfo[0]['gioi_tinh'] == 3) ? 'checked' : ''; ?>><span class="form-radio__label">Khác</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-radio-checkbox form-group">
                                    <div class="col col-label">
                                        <label>Ngày sinh</label>
                                    </div>
                                    <div class="col col-input">
                                        <div class="row">
                                            <input type="text" value="<?php echo $userInfo[0]['ngay_sinh']; ?>" class="form-control" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-radio-checkbox form-group">
                                    <div class="col col-label"></div>
                                    <div class="col-12 col-input form-buttons">
                                        <button class="btn btn--large">Cập nhật</button>
                                        <a data-fancybox="" data-src="#fancybox-popup" class="btn btn--large btn--outline">Đổi mật khẩu</a>
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var updateButton = document.querySelector('.btn.btn--large');
                                        updateButton.addEventListener('click', function(event) {
                                            event.preventDefault();
                                            var gender = document.querySelector('input[name="customer_sex"]:checked').value;
                                            var email = document.getElementById('customer_email').value;

                                            $.ajax({
                                                url: 'update_profile.php',
                                                method: 'POST',
                                                data: { 
                                                    gioi_tinh: gender,
                                                    email: email
                                                },
                                                dataType: 'json',
                                                success: function(response) {
                                                    if (response.success) {
                                                        alert(response.message);
                                                        // Xử lý thành công
                                                    } else {
                                                        alert(response.message);
                                                        // Xử lý lỗi
                                                    }
                                                },
                                                error: function(error) {
                                                    console.log('Error:', error);
                                                }
                                            });
                                        });
                                    });
                                </script>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="add-address add-change-pass" id="fancybox-popup">
                <h3>ĐỔI MẬT KHẨU</h3>
                <div class="col-md-12 form-group">
                    <label>Mật khẩu hiện tại</label>
                    <input class="form-control" type="password" name="customer_pass_old" id="customer_pass_old">
                </div>
                <div class="col-md-12 form-group">
                    <label>Mật khẩu mới</label>
                    <input class="form-control" type="password" name="customer_pass_new1" id="customer_pass_new1" value="">
                </div>
                <div class="col-md-12 form-group">
                    <label>Nhập lại Mật khẩu mới</label>
                    <input class="form-control" type="password" name="customer_pass_new2" id="customer_pass_new2" value="">
                </div>
                <div class="wallet-deposit-form-wrapper" style="width: 100%">
                    <div class="col-md-12 form-button">
                        <a style="max-width: 100%; font-weight: 600;" class="btn btn--large" id="change_pass">Cập nhật</a>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var changePasswordButton = document.querySelector('[data-src="#fancybox-popup"]');
                    var modal = document.getElementById('fancybox-popup');
                    var backdrop = document.createElement('div');
                    backdrop.className = 'modal-backdrop';

                    changePasswordButton.addEventListener('click', function(event) {
                        event.preventDefault();
                        modal.style.display = 'block';
                        backdrop.style.display = 'block';
                        document.body.appendChild(backdrop);
                    });

                    backdrop.addEventListener('click', function() {
                        modal.style.display = 'none';
                        backdrop.style.display = 'none';
                        document.body.removeChild(backdrop);
                    });

                    var updatePasswordButton = document.getElementById('change_pass');
                    updatePasswordButton.addEventListener('click', function(event) {
                        event.preventDefault();
                        var oldPassword = document.getElementById('customer_pass_old').value;
                        var newPassword1 = document.getElementById('customer_pass_new1').value;
                        var newPassword2 = document.getElementById('customer_pass_new2').value;

                        $.ajax({
                            url: 'change_password.php',
                            method: 'POST',
                            data: { 
                                customer_pass_old: oldPassword, 
                                customer_pass_new1: newPassword1, 
                                customer_pass_new2: newPassword2 
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    alert(response.message);
                                    // Đóng modal và backdrop
                                    modal.style.display = 'none';
                                    backdrop.style.display = 'none';
                                    // Xử lý thành công
                                    document.getElementById('customer_pass_old').value = '';
                                    document.getElementById('customer_pass_new1').value = '';
                                    document.getElementById('customer_pass_new2').value = '';
                                } else {
                                    alert(response.message);
                                    // Xử lý lỗi
                                }
                            },
                            error: function(error) {
                                console.log('Error:', error);
                            }
                        });
                    });
                });
            </script>

        </div>
    </div>

</section>
                      
<!-------------------------------- infouser ---------------------------------->
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

<script src="js/sub-action.js"></script>
<script src="js/menu.js"></script>
<script src="js/cart.js"></script>
</body>
</html>
