<?php
include_once('admin/php/config.php'); // Đảm bảo đường dẫn hợp lý

// Kiểm tra kết nối
if ($conn->connect_error) {
    die(json_encode(["error" => "Kết nối thất bại: " . $conn->connect_error]));
}

function getProductsByGroup($groupId, $conn) {
    $sql = "SELECT sp.ma_so, sp.ten_san_pham, sp.hinh_anh, sp.gia, sp.muc_giam, sp.ngay_tao, tl.nhom,
                   GROUP_CONCAT(DISTINCT tt.ma_mau_sac) AS ma_mau_sac,
                   GROUP_CONCAT(DISTINCT tt.ma_kich_co) AS ma_kich_co
            FROM san_pham sp
            LEFT JOIN the_loai tl ON sp.ma_the_loai = tl.ma_so
            LEFT JOIN thuoc_tinh_san_pham tt ON tt.ma_san_pham = sp.ma_so
            WHERE tl.nhom = ? AND sp.trang_thai = 0
            GROUP BY sp.ma_so
            ORDER BY sp.ngay_tao DESC LIMIT 10";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $groupId);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        // Chuyển đổi chuỗi thành mảng
        $row['ma_mau_sac'] = explode(',', $row['ma_mau_sac']);
        $row['ma_kich_co'] = explode(',', $row['ma_kich_co']);

        // Thêm sản phẩm vào mảng products
        $products[] = $row;
    }

    return $products;
}

$productGroups = [
    "women" => getProductsByGroup(1, $conn),
    "men" => getProductsByGroup(2, $conn),
    "kids" => array_merge(getProductsByGroup(3, $conn), getProductsByGroup(4, $conn))
];
// header('Content-Type: application/json');
// echo json_encode($productGroups);


function maColor($ma_mau_sac) {
    return $ma_mau_sac < 10 ? '0' . $ma_mau_sac : $ma_mau_sac;
}

function maSize($ma_kich_co) {
    switch($ma_kich_co) {
        case "1":
            return "S";
        case "2":
            return "M";
        case "3":
            return "L";
        case "4":
            return "XL";
        case "5":
            return "XXL";
        default:
            return "S";
    }
}

function maDiscount($muc_giam) {
    if ($muc_giam < 30) {
        return 1; 
    } else if ($muc_giam >= 30 && $muc_giam < 50) {
        return 2; 
    } else if ($muc_giam >= 50 && $muc_giam < 70) {
        return 3; 
    } else if ($muc_giam >= 70) {
        return 4; 
    } else if ($muc_giam === 299) {
        return 5; 
    } else {
        return 0; 
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
    <link rel="stylesheet" href="css/toast.css">
    <title>NKstore</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
    <style>
        .slick-prev, .slick-next {
            display: none; /* Hide default arrows */
        }
        .owl-nav {
            position: absolute;
            top: 30%;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }
        .owl-prev, .owl-next {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- header -->
<!-- <header class="d-flex" > -->
<?php include 'header.php'; ?>

<!-- header -->
<!-- main -->
<main class="site-main">
<div class="item-banner mt-1">
<div class="slider">
    <div class="slides">

        <input type="radio" name="radio-btn" id="radio1">
        <input type="radio" name="radio-btn" id="radio2">
        <input type="radio" name="radio-btn" id="radio3">
        <input type="radio" name="radio-btn" id="radio4">
        <div class="slide first">
            <img src="assets/images/slider_main5.webp" alt="">
        </div>
        <div class="slide">
            <img src="assets/images/slider_main2.webp" alt="">
        </div>
        <div class="slide">
            <img src="assets/images/slider_main3.webp" alt="">
        </div>
        <div class="slide">
            <img src="assets/images/slider_main4.webp" alt="">
        </div>

        <!-- <div class="nav-auto">
            <div class="auto-bnt1"></div>
            <div class="auto-bnt2"></div>
            <div class="auto-bnt3"></div>
        </div> -->
        <div class="nav-manual">
            <label for="radio1" class="manual-btn"></label>
            <label for="radio2" class="manual-btn"></label>
            <label for="radio3" class="manual-btn"></label>
            <label for="radio4" class="manual-btn"></label>
        </div>
    </div>

    <div class="nav-manual">
        <label for="radio1" class="manual-btn"></label>
        <label for="radio2" class="manual-btn"></label>
        <label for="radio3" class="manual-btn"></label>
        <label for="radio4" class="manual-btn"></label>
    </div>

</div>
</div>

<section class="home-banner-all">
    <div class="title-section">BẠN ĐANG TÌM</div>
        <div class="tabs">
            <div class="exclusive-head">
                <ul>
                    <li class="exclusive-tab active" data-tab="tab-women">NK women</li>
                    <li class="exclusive-tab" data-tab="tab-men">NK men</li>
                    <li class="exclusive-tab" data-tab="tab-kids">NK kids</li>
                </ul>
            </div>
            <div class="exclusive-content">
                <div class="exclusive-inner active" id="tab-women">
                    <div class="list-products new-prod-slider sliders owl-slide owl-loaded ">
                    <?php foreach ($productGroups['women'] as $product) : ?>
                        <div class="owl-item" style="width: 293.333px; margin: 0 20px;">
                            <div class="item-new-product">                               
                                <div class="product">
                                    <div class="info-ticket ticket-news">NEW</div>
                                    <span class="badget badget_0<?= maDiscount($product['muc_giam']) ?>">-<?= $product['muc_giam'] ?><span>%</span></span>
                                    <div class="thumb-product">
                                        <a href="productdetails.php?product_id=<?= $product['ma_so'] ?>">
                                            <img src="<?= $product['hinh_anh'] ?>" alt="<?= $product['ten_san_pham'] ?>">
                                        </a>
                                    </div>
                                    <div class="info-product">
                                        <div class="list-color">
                                            <ul>
                                            <?php foreach ($product['ma_mau_sac'] as $color): ?>
                                                <li class="bg-light">
                                                    <a href="javascript:void(0)" class="color-picker" data-id="<?= $product['ma_so'] ?>">
                                                        <img src="assets/images/icon/0<?= maColor($color) ?>.png" alt="<?= maColor($color) ?>" >
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                            </ul>
                                            <div class="favourite" data-id="<?= $product['ma_so'] ?>">
                                                <i class="fa fa-heart-o"></i>
                                            </div>
                                        </div>
                                        <h3 class="title-product">
                                            <a href="productdetails.php?product_id=<?= $product['ma_so'] ?>"><?= $product['ten_san_pham'] ?></a>
                                        </h3>
                                        <div class="price-product">
                                            <ins>
                                                <span><?= number_format($product['gia'] * (1 - $product['muc_giam'] / 100), 0, ',', '.') ?>đ</span>
                                            </ins>
                                            <del>
                                                <span><?= number_format($product['gia'], 0, ',', '.') ?>đ</span>
                                            </del>
                                        </div>
                                    </div>
                                    <div class="add-to-cart">
                                        <a href="javascript:void(0)"><i class="fa fa-shopping-bag"></i></a>
                                    </div>
                                    <div class="list-size">
                                        <ul>
                                            <?php foreach ($product['ma_kich_co'] as $size): ?>
                                                <li data-product-sub-id="<?= $product['ma_so'] ?>">
                                                    <button class="btn btn-large"><?= maSize($size) ?></button>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>        
                    <?php endforeach; ?>           
                    </div>
                        
                    <div class="owl-nav">
                        <div class="owl-prev disabled">
                            <i class="fa fa-chevron-circle-left"></i>
                        </div>
                        <div class="owl-next">
                            <i class="fa fa-chevron-circle-right"></i>
                        </div>
                    </div>
                    <div class="owl-dots disabled"></div>
                    <div class="link-product">
                        <a href="cartegory.php" class="all-product">Xem tất cả</a>
                    </div>                            
                </div>
                <div class="exclusive-inner" id="tab-men">
                    <div class="list-products new-prod-slider sliders owl-slide owl-loaded owl-hidden">
                    <?php foreach ($productGroups['men'] as $product) : ?>
                        <div class="owl-item" style="width: 293.333px !impo; margin: 0 20px;">
                            <div class="item-new-product">                               
                                <div class="product">
                                    <div class="info-ticket ticket-news">NEW</div>
                                    <span class="badget badget_0<?= maDiscount($product['muc_giam']) ?>">-<?= $product['muc_giam'] ?><span>%</span></span>
                                    <div class="thumb-product">
                                        <a href="productdetails.php?product_id=<?= $product['ma_so'] ?>">
                                            <img src="<?= $product['hinh_anh'] ?>" alt="<?= $product['ten_san_pham'] ?>" >
                                        </a>
                                    </div>
                                    <div class="info-product">
                                        <div class="list-color">
                                            <ul>
                                            <?php foreach ($product['ma_mau_sac'] as $color): ?>
                                                <li class="bg-light">
                                                    <a href="javascript:void(0)" class="color-picker" data-id="<?= $product['ma_so'] ?>">
                                                        <img src="assets/images/icon/0<?= maColor($color) ?>.png" alt="<?= maColor($color) ?>" >
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                            </ul>
                                            <div class="favourite" data-id="<?= $product['ma_so'] ?>">
                                                <i class="fa fa-heart-o"></i>
                                            </div>
                                        </div>
                                        <h3 class="title-product">
                                            <a href="productdetails.php?product_id=<?= $product['ma_so'] ?>"><?= $product['ten_san_pham'] ?></a>
                                        </h3>
                                        <div class="price-product">
                                            <ins>
                                                <span><?= number_format($product['gia'] * (1 - $product['muc_giam'] / 100), 0, ',', '.') ?>đ</span>
                                            </ins>
                                            <del>
                                                <span><?= number_format($product['gia'], 0, ',', '.') ?>đ</span>
                                            </del>
                                        </div>
                                    </div>
                                    <div class="add-to-cart">
                                        <a href="javascript:void(0)"><i class="fa fa-shopping-bag"></i></a>
                                    </div>
                                    <div class="list-size">
                                        <ul>
                                            <?php foreach ($product['ma_kich_co'] as $size): ?>
                                                <li data-product-sub-id="<?= $product['ma_so'] ?>">
                                                    <button class="btn btn-large"><?= maSize($size) ?></button>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>        
                    <?php endforeach; ?>           
                    </div>
                        
                    <div class="owl-nav">
                        <div class="owl-prev disabled">
                            <i class="fa fa-chevron-circle-left"></i>
                        </div>
                        <div class="owl-next">
                            <i class="fa fa-chevron-circle-right"></i>
                        </div>
                    </div>
                    <div class="owl-dots disabled"></div>
                    <div class="link-product">
                        <a href="cartegory.php" class="all-product">Xem tất cả</a>
                    </div>                            
                </div>
                <div class="exclusive-inner" id="tab-kids">
                    <div class="list-products new-prod-slider sliders owl-slide owl-loaded owl-hidden">
                    <?php foreach ($productGroups['kids'] as $product) : ?>
                        <div class="owl-item" style="width: 293.333px; margin: 0 20px;">
                            <div class="item-new-product">                               
                                <div class="product">
                                    <div class="info-ticket ticket-news">NEW</div>
                                    <span class="badget badget_0<?= maDiscount($product['muc_giam']) ?>">-<?= $product['muc_giam'] ?><span>%</span></span>
                                    <div class="thumb-product">
                                        <a href="productdetails.php?product_id=<?= $product['ma_so'] ?>">
                                            <img src="<?= $product['hinh_anh'] ?>" alt="<?= $product['ten_san_pham'] ?>" >
                                        </a>
                                    </div>
                                    <div class="info-product">
                                        <div class="list-color">
                                            <ul>
                                            <?php foreach ($product['ma_mau_sac'] as $color): ?>
                                                <li class="bg-light">
                                                    <a href="javascript:void(0)" class="color-picker" data-id="<?= $product['ma_so'] ?>">
                                                        <img src="assets/images/icon/0<?= maColor($color) ?>.png" alt="<?= maColor($color) ?>" >
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                            </ul>
                                            <div class="favourite" data-id="<?= $product['ma_so'] ?>">
                                                <i class="fa fa-heart-o"></i>
                                            </div>
                                        </div>
                                        <h3 class="title-product">
                                            <a href="productdetails.php?product_id=<?= $product['ma_so'] ?>"><?= $product['ten_san_pham'] ?></a>
                                        </h3>
                                        <div class="price-product">
                                            <ins>
                                                <span><?= number_format($product['gia'] * (1 - $product['muc_giam'] / 100), 0, ',', '.') ?>đ</span>
                                            </ins>
                                            <del>
                                                <span><?= number_format($product['gia'], 0, ',', '.') ?>đ</span>
                                            </del>
                                        </div>
                                    </div>
                                    <div class="add-to-cart">
                                        <a href="javascript:void(0)"><i class="fa fa-shopping-bag"></i></a>
                                    </div>
                                    <div class="list-size">
                                        <ul>
                                            <?php foreach ($product['ma_kich_co'] as $size): ?>
                                                <li data-product-sub-id="<?= $product['ma_so'] ?>">
                                                    <button class="btn btn-large"><?= maSize($size) ?></button>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>        
                    <?php endforeach; ?>           
                    </div>
                        
                    <div class="owl-nav">
                        <div class="owl-prev disabled">
                            <i class="fa fa-chevron-circle-left"></i>
                        </div>
                        <div class="owl-next">
                            <i class="fa fa-chevron-circle-right"></i>
                        </div>
                    </div>
                    <div class="owl-dots disabled"></div>
                    <div class="link-product">
                        <a href="cartegory.php" class="all-product">Xem tất cả</a>
                    </div>                            
                </div>
                
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('.exclusive-tab').click(function() {
                    $('.exclusive-tab').removeClass('active');
                    $(this).addClass('active');

                    $('.exclusive-inner').removeClass('active');
                    var tabId = $(this).data('tab');
                    $('#' + tabId).addClass('active');

                    $('.list-products').addClass('owl-hidden');
                    if ($('#' + tabId).hasClass('active')) {
                        $('#' + tabId + ' .list-products').removeClass('owl-hidden');
                    }
                });
            });
            </script>                              

    </div>

    <div class="row">
        <div class="col-xs-5 col-sm-4 item">
            <a href="cartegory.php?category=2" title="Áo thun">
                <img class="dt-width-100 ls-is-cached" width="423" height="148" src="assets/images/pexels-photo-1.webp" alt="Áo thun">
                <h2 class="caption-title2">Áo thun<i class="fa fa-angle-double-right"></i></h2>
            </a>
        </div>
        <div class="col-xs-5 col-sm-4 item">
            <a href="cartegory.php?category=12" title="áo khoác">
                <img class="dt-width-100 ls-is-cached" width="423" height="148" src="assets/images/pexels-photo-3.jpeg" alt="Ao khoac">
                <h2 class="caption-title2">Áo khoác<i class="fa fa-angle-double-right"></i></h2>
            </a>
        </div>
        <div class="col-xs-5 col-sm-4 item">
            <a href="cartegory.php?category=3" title="áo croptop">
                <img class="dt-width-100 ls-is-cached" width="423" height="148" src="assets/images/pexels-photo-2.jpeg" alt="Ao croptop">
                <h2 class="caption-title2">Cáo croptop<i class="fa fa-angle-double-right"></i></h2>
            </a>
        </div>
        <div class="col-xs-5 col-sm-4 item">
            <a href="cartegory.php?category=5" title="gáo thun nam">
                <img class="dt-width-100 ls-is-cached" width="423" height="148" src="assets/images/pexels-photo-4.webp" alt="Ao thun nam">
                <h2 class="caption-title2">Áo thun nam<i class="fa fa-angle-double-right"></i></h2>
            </a>
        </div>
        <div class="col-xs-5 col-sm-4 item">
            <a href="cartegory.php?category=1" title="áo sơ mi">
                <img class="dt-width-100 ls-is-cached" width="423" height="148" src="assets/images/pexels-photo-6.webp" alt="Ao so mi">
                <h2 class="caption-title2">Áo sơ mi<i class="fa fa-angle-double-right"></i></h2>
            </a>
        </div>
        <div class="col-xs-5 col-sm-4 item">
            <a href="cartegory.php?category=23" title="set bộ thun len">
                <img class="dt-width-100 ls-is-cached" width="423" height="148" src="assets/images/pexels-photo-5.jpeg" alt="set bo thun len">
                <h2 class="caption-title2">Set bộ thun len<i class="fa fa-angle-double-right"></i></h2>
            </a>
        </div>
        <div class="col-xs-5 col-sm-4 item">
            <a href="cartegory.php?category=6" title="áo polo">
                <img class="dt-width-100 ls-is-cached" width="423" height="148" src="assets/images/pexels-photo-7.webp" alt="Áo polo">
                <h2 class="caption-title2">Áo polo<i class="fa fa-angle-double-right"> </i></h2>
            </a>
        </div>
        <div class="col-xs-5 col-sm-4 item">
            <a href="cartegory.php?category=21" title="set bộ công sở">
                <img class="dt-width-100 ls-is-cached" width="423" height="148" src="assets/images/pexels-photo-8.webp" alt="Set bo cong so">
                <h2 class="caption-title2">Set bộ công sở<i class="fa fa-angle-double-right"></i></h2>
            </a>
        </div>
        <div class="col-xs-5 col-sm-4 item">
            <a href="cartegory.php?category=4" title="Áo peplum">
                <img class="dt-width-100 ls-is-cached" width="423" height="148" src="assets/images/pexels-photo-10.webp" alt="qAo peplum">
                <h2 class="caption-title2">Áo peplum<i class="fa fa-angle-double-right"></i></h2>
            </a>
        </div>
    </div>
</section>
</main>
<!-- main -->
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
<div id="toast-container" class="toast-bottom-right">
            <div class="toast toast-info" aria-live="polite" style="display: none;">
                <div class="toast-message">Bạn chưa chọn size!</div>
            </div>
            <div class="toast toast-info" aria-live="polite" style="display: none;">
                <div class="toast-message">Sản phẩm đã hết hàng Online. Bạn có thể "Tìm tại cửa hàng" !</div>
            </div>
        </div>
<script>
    $(document).ready(function() {
            function getCookie(name) {
            let cookieArr = document.cookie.split(";");
            for (let i = 0; i < cookieArr.length; i++) {
                let cookiePair = cookieArr[i].split("=");
                if (name === cookiePair[0].trim()) {
                    return decodeURIComponent(cookiePair[1]);
                }
            }
            return null;
        }

        function showToast(message) {
            const toastContainer = $('#toast-container');
            const toastMessage = `<div class="toast toast-info" aria-live="polite" style="display: block;">
                                    <div class="toast-message">${message}</div>
                                </div>`;

            toastContainer.html(toastMessage);
            toastContainer.show();

            // Tự động ẩn toast sau 3 giây
            setTimeout(function() {
                toastContainer.fadeOut();
            }, 3000);
        }

        var accountCookie = getCookie('account');
        // Toggle class 'open' for .list-size
        $('.add-to-cart a').click(function() {
            $(this).closest('.product').find('.list-size').toggleClass('open');
        });

        // Handle favourite click
        $('.favourite').click(function(event) {
            event.preventDefault();
            if (!accountCookie) {
                showToast('Bạn cần đăng nhập để thực hiện chức năng này!');
                return;
            }
            var favourite = $(this);
            var productId = favourite.data('id');
            var action = favourite.find('.fa').hasClass('fa-heart') ? 'remove' : 'add';

            $.ajax({
                type: 'POST',
                url: 'php/addToFavorites.php',
                data: { productId: productId, action: action },
                success: function(response) {
                    console.log('Success:', response);
                    if (!response.status) {
                        if (action === 'add') {
                            favourite.find('.fa').removeClass('fa-heart-o').addClass('fa-heart');
                            showToast('Bạn đã thêm thành công vào danh sách yêu thích!');
                        } else {
                            favourite.find('.fa').removeClass('fa-heart').addClass('fa-heart-o');
                            console.log(response.message);
                        }
                    } else {
                        console.log(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
<script src="js/sub-action.js"></script>
<script src="js/slider.js"></script>
<script src="js/menu.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script>
  $(document).ready(function() {
    var $slider = $('.new-prod-slider').slick({
        infinite: true,
        speed: 200,
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        arrows: false, // Disable default arrows
        responsive: [
            {
                breakpoint: 768, // Mobile breakpoint
                settings: {
                    slidesToShow: 2, // Show 2 slides on mobile
                    slidesToScroll: 1
                }
            }
        ]
    });

    // Custom navigation
    $('.owl-prev').on('click', function() {
        $slider.slick('slickPrev');
    });

    $('.owl-next').on('click', function() {
        $slider.slick('slickNext');
    });
});


</script>


</body>
</html>
<?php


$conn->close();
?>