<?php

include_once '../admin/php/account.php';

$userInfo = null;

if (isset($_COOKIE['account']) && isset($_COOKIE['password'])) {
    $account = $_COOKIE['account'];
    $password = $_COOKIE['password'];

    require '../admin/php/config.php';

    $accountClass = new Account($conn);
    $userInfo = $accountClass->getUser($account, $account);

    if (!$userInfo) {
        echo "Thông tin đăng nhập không hợp lệ hoặc không tồn tại.";
        exit();
    } 

    // Kiểm tra mật khẩu nếu cần
    // ...

    // $conn->close();
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
    <script src="../css/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="../css/style.css">
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
<?php
session_start();

$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<header id="header" class="site-header" role="banner" itemscope="" itemtype="http://schema.org/WPHeader">
    <div class="container d-flex">
        <!-- <div class="toggle"><i class="fas fa-bars"></i></div>
        <div class="logo">
            <img src="assets/images/logomain.png" alt="logo">
        </div> -->
        <div class="main-menu">
            <ul class="menu d-flex">
                <li><a href="../index.php">Trang chủ</a></li>
                <li class="category-nu">
                    <a href="../cartegory.php">NỮ</a>
                    <ul class="sub-menu">
                        <li>
                            <h4><a href="">NEW ARRIVAL</a></h4>
                        </li>
                        <div class="list-sub-menu d-flex">
                            <div class="item-sub-menu">
                                <h3><a href="">ÁO</a></h3>
                                <ul></ul>
                            </div>
                        
                        
                            <div class="item-sub-menu">
                                <h3><a href="">ÁO KHOÁC</a></h3>
                                <ul></ul>
                            </div>
                        
                        
                            <div class="item-sub-menu">
                                <h3><a href="">SET BỘ</a></h3>
                                <ul></ul>
                            </div>
                        
                            <div class="item-sub-menu">
                                <h3><a href="">CHÂN VÁY</a></h3>
                                <ul></ul>
                            </div>
                        
                            <div class="item-sub-menu">
                                <h3><a href="">ĐẦM/ÁO DÀI</a></h3>
                                <ul></ul>
                            </div>
                        
                            <div class="item-sub-menu">
                                <h3><a href="">SENORA</a></h3>
                                <ul></ul>
                            </div>
                        
                            <div class="item-sub-menu">
                                <h3><a href="">PHỤ KIỆN</a></h3>
                                <ul></ul>
                            </div>
                        </div>
                    </ul>
                </li>

                <li class="category-nam">
                    <a href="../cartegory.php">NAM</a>
                    <ul class="sub-menu">
                        <li>
                            <h4><a href="">NEW ARRIVAL</a></h4>
                        </li>
                        <div class="list-sub-menu d-flex">
                                                                
                            <div class="item-sub-menu">
                                <h3><a href="">ÁO</a></h3>
                                <ul></ul>
                            </div>
                            
                            <div class="item-sub-menu">
                                <h3><a href="">QUẦN NAM</a></h3>
                                <ul></ul>
                            </div>
                            
                            <div class="item-sub-menu">
                                <h3><a href="">PHỤ KIỆN</a></h3>
                                <ul></ul>
                            </div>
                        </div>
                        
                    </ul>
                </li>
                <li class="category-treem">
                    <a href="../cartegory.php">TRẺ EM</a>
                    <ul class="sub-menu">
                        <li>
                            <h4><a href="">NEW ARRIVAL</a></h4>
                        </li>
                        <div class="list-sub-menu d-flex">                               
                            <div class="item-sub-menu">
                                <h3><a href="">ÁO KHOÁC</a></h3>
                                <ul></ul>
                            </div>
                            
                            <div class="item-sub-menu">
                                <h3><a href="">BÉ TRAI</a></h3>
                                <ul></ul>
                            </div>
                            
                            <div class="item-sub-menu">
                                <h3><a href="">BÉ GÁI</a></h3>
                                <ul></ul>
                            </div>
                        </div>
                    </ul>
                </li>
                <li><a href="">Bộ sưu tập</a>
                    <ul class="sub-menu">
                        <li><a href="">OCEAN JEWELS</a></li>
                        <li><a href="">URBAN CHIC</a></li>
                        <li><a href="">THE FLOW</a></li>
                        <li><a href="">MOMENT OF BLISS</a></li>
                        <li><a href="">BLOSSOMS DELIGHT</a></li>
                        <li><a href="">THE WHISPER OF CLASSY</a></li>
                    </ul>
                </li>
                <li><a href="">Thông tin</a>
                    <ul class="sub-menu">
                        <li><a href="">Giới thiệu</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="site-brand">
            <a href="../index.php"><img src="../assets/images/NKlogo.png" alt="Đăng nhập | IVY moda"></a>
        </div>
        <div class="others ml-1">
        <form class="search-form" enctype="application/x-www-form-urlencoded" method="get" action="/nkstore/tim-kiem.php" name="frm_search">
                <button class="submit" name="btn_search_header_tmp"><i class="fa fa-search"></i></button>
                <input style="padding-left: 40px; font-size: 12px"id="search-quick" type="text" name="q" placeholder="TÌM KIẾM SẢN PHẨM" autocomplete="off" minlength="1">
                <div class="quick-search">
                    <div class="item-searchs">
                        <h4>Tìm kiếm nhiều nhất</h4>
                        <div class="item-side-size">
                            <label class="item-sub-list po-relative mb-2">
                                <a href="/nkstore/tim-kiem.php?q=Đầm" class="item-sub-title">Đầm</a>
                            </label>
                            <label class="item-sub-list po-relative mb-2">
                                <a href="/nkstore/tim-kiem.php?q=trễ vai" class="item-sub-title">trễ vai</a>
                            </label>
                            <label class="item-sub-list po-relative mb-2">
                                <a href="/nkstore/tim-kiem.php?q=Áo khoác" class="item-sub-title">Áo khoác</a>
                            </label>
                            <label class="item-sub-list po-relative mb-2">
                                <a href="/nkstore/tim-kiem.php?q=Quần" class="item-sub-title">Quần</a>
                            </label>
                            <label class="item-sub-list po-relative mb-2">
                                <a href="/nkstore/tim-kiem.php?q=Áo sơ mi" class="item-sub-title">Áo sơ mi</a>
                            </label>
                            <label class="item-sub-list po-relative mb-2">
                                <a href="/nkstore/tim-kiem.php?q=Vest" class="item-sub-title">Vest</a>
                            </label>
                            <label class="item-sub-list po-relative mb-2">
                                <a href="/nkstore/tim-kiem.php?q=parka" class="item-sub-title">parka</a>
                            </label>
                            <label class="item-sub-list po-relative mb-2">
                                <a href="/nkstore/tim-kiem.php?q=tweed" class="item-sub-title">tweed</a>
                            </label>
                            <label class="item-sub-list po-relative mb-2">
                                <a href="/nkstore/tim-kiem.php?q=croptop" class="item-sub-title">croptop</a>
                            </label>
                            <label class="item-sub-list po-relative mb-2">
                                <a href="/nkstore/tim-kiem.php?q=Chân váy" class="item-sub-title">Chân váy</a>
                            </label>
                            <label class="item-sub-list po-relative mb-2">
                                <a href="/nkstore/tim-kiem.php?q=lông cừu" class="item-sub-title">polo</a>
                            </label>
                        </div>
                    </div>
                </div>
            </form>        
            <li> <a class="fas fa-headset" href="../checkorder.php"></a></li>
            <div class="item-wallet"> 
                <li> <a id="user-icon" class="fas fa-user" href="../login.html"></a></li>
                <div class="sub-action" id="sub-action-menu">
                    <div class="top-action">
                        <a class="icon" href="../login.html"><h3>Tài khoản của tôi</h3></a>
                    </div>
                    <ul>
                        <li><a href="../infouser.php"><i class="fas fa-user"></i>Thông tin tài khoản</a></li>
                        <li><a href="../customer/order_list.php"><i class="fa fa-tasks"></i>Quản lý đơn hàng</a></li>
                        <li><a href="../customer/address_list.php"><i class="fa fa-location-arrow"></i>Sổ địa chỉ</a></li>                   
                        <li><a href="../customer/san-pham-yeu-thich.php"><i class="fa fa-heart-o"></i>Sản phẩm yêu thích</a></li>  
                        <li><a href="../customer/question.php"><i class="fas fa-headset"></i>Hỏi đáp sản phẩm</a></li>                       
                        <li><a href="ivy-support/danh-sach"><i class="fa fa-hand-o-right"></i>Hỗ trợ - NKstore</a></li>
                        <li><a href="#"><i class="fa fa-sign-out"></i>Đăng xuất</a></li>
                    </ul>
                </div>
            </div>
            <li> <a class="icon" href="../cart.php"><i class="fas fa-shopping-cart"></i>
                    <span class="number-cart"><?php echo $cart_count; ?></span>
                </a>
            </li>
        </div>
    </div>
</header>

<!-- header -->


<!-------------------------------- address_list ---------------------------------->
<section class="login">
    <div class="container">
        
        <div class="breadcrumb-products">
            <ol class="breadcrumb__list">
                <li class="breadcrumb__item"><a class="breadcrumb__link" href="../index.php">Trang chủ</a></li>
                <li class="breadcrumb__item"><a href="../infouser.php" class="breadcrumb__link" title="Tài khoản của tôi">Tài khoản của tôi</a></li>
            </ol>
        </div>
    
        <div class="order-wrapper mt-40 my-account">
            <div class="row">
                <div class="col-lg-4 col-xl-auto">
                    <div class="order-sidemenu block-border">
                        <div class="order-sidemenu__user">
                            <div class="order-sidemenu__user-avatar">
                                <img src="../assets/images/user-avatar.png" alt="">
                            </div>
                            <div class="order-sidemenu__user-name">
                                <p><?php echo $userInfo[0]['ho_nguoi_dung']." ".$userInfo[0]['ten_nguoi_dung']; ?></p>
                            </div>
                        </div>
                        <div class="order-sidemenu__menu">
                            <ul>
                                <li class="">
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
                                <li class="active">
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
                <div class="col-lg-8 col-xl col-product-view-like" style="left : -120px">
                    <div class="order-block__title wallet-address__title">
                        <h3>Sản phẩm yêu thích</h3>
                    </div>
                    <div class="sub-main-prod" id="products">
                        <div class="list-products list-products-cat d-flex">
                        <?php
                            $user_id = $userInfo[0]['ma_so'];; // Thay thế bằng ID người dùng tương ứng
                            $sql = "SELECT yt.`ma_nguoi_dung`, yt.`ma_san_pham`, sp.ma_so, sp.ten_san_pham, sp.hinh_anh, sp.gia, sp.muc_giam, tt.ma_mau_sac, tt.ma_kich_co
                                    FROM `yeu_thich` yt
                                    LEFT JOIN san_pham sp ON sp.ma_so = yt.ma_san_pham
                                    LEFT JOIN thuoc_tinh_san_pham tt ON tt.ma_san_pham = yt.ma_san_pham
                                    WHERE yt.ma_nguoi_dung = ?
                                    ORDER BY yt.ma_san_pham ASC";

                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param('i', $user_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            $list_product = [];
                            while ($row = $result->fetch_assoc()) {
                                $ma_san_pham = $row['ma_san_pham'];
                                if (!isset($list_product[$ma_san_pham])) {
                                    $list_product[$ma_san_pham] = [
                                        'ma_so' => $row['ma_so'],
                                        'ma_san_pham' => $row['ma_san_pham'],
                                        'ten_san_pham' => $row['ten_san_pham'],
                                        'hinh_anh' => $row['hinh_anh'],
                                        'gia' => $row['gia'],
                                        'muc_giam' => $row['muc_giam'],
                                        'mau_sac' => [],
                                        'kich_co' => [],
                                    ];
                                }
                                // Kiểm tra và thêm màu sắc không trùng lặp
                                if (!in_array($row['ma_mau_sac'], $list_product[$ma_san_pham]['mau_sac'])) {
                                    $list_product[$ma_san_pham]['mau_sac'][] = $row['ma_mau_sac'];
                                }
                                // Kiểm tra và thêm kích cỡ không trùng lặp
                                if (!in_array($row['ma_kich_co'], $list_product[$ma_san_pham]['kich_co'])) {
                                    $list_product[$ma_san_pham]['kich_co'][] = $row['ma_kich_co'];
                                }
                            }
                            
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
                            <?php foreach ($list_product as $product) : ?>
                            <div class="item-cat-product">
                                
                                <div class="product">
                                    <span class="badget badget_0<?= maDiscount($product['muc_giam']) ?>">-<?= $product['muc_giam'] ?><span>%</span></span>
                                    <div class="thumb-product">
                                        <a href="/nkstore/productdetails.php?product_id=<?= $product['ma_so'] ?>">
                                            <img src="/nkstore/<?= $product['hinh_anh'] ?>" alt="<?= $product['ten_san_pham'] ?>" class="lazy">
                                        </a>
                                    </div>
                                    <div class="info-product">
                                        <div class="list-color">
                                            <ul>
                                                <?php foreach ($product['mau_sac'] as $ma_mau_sac): ?>
                                                <li class="">
                                                    <a href="javascript:void(0)" class="color-picker" data-id="<?= $product['ma_so'] ?>">
                                                        <img src="/nkstore/assets/images/icon/0<?= maColor($ma_mau_sac) ?>.png" alt="<?= maColor($ma_mau_sac) ?>" class="lazy">
                                                    </a>
                                                </li>
                                                <?php endforeach; ?>
                                            </ul>
                                            <div class="favourite" data-id="<?= $product['ma_san_pham'] ?>">
                                                <i class="fa fa-heart"></i>
                                            </div>
                                        </div>
                                        <h3 class="title-product">
                                            <a href="/nkstore/productdetails.php?product_id=<?= $product['ma_so'] ?>"><?= $product['ten_san_pham'] ?></a>
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
                                            <?php foreach ($product['kich_co'] as $ma_kich_co): ?>
                                            <li data-product-sub-id="<?= $product['ma_so'] ?>"><button class="btn bt-large"><?= maSize($ma_kich_co) ?></button></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                               

                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
          
<!-------------------------------- address_list ---------------------------------->
<!-- footer -->
<footer class="footer p-4">
<div class="container-ft">
<div class="row main-footer">
<div class="left-footer col-md-6">
    <div class="top-left">
        <div class="logo-ft"><img src="../assets/images/logoNK.png" alt="logons"></div>
        <div class="logo-ft"><img src="../assets/images/dmca.png" alt="dmca"></div>
        <div class="logo-ft"><img src="../assets/images/img-congthuong.png" alt="congthuong"></div>
    </div>
    <div class="info-left-ft">
        <p>Công ty Cổ Phần ... với số đăng ký kinh doanh:...</p>
        <p><strong>Địa chỉ đăng ký: </strong>P. Hiệp Bình Phước, TP. Thủ Đức, TP. Hồ Chí Minh</p>
        <p><strong>Số điện thoại: </strong>0432 324 242/ 090 124 1241</p>
        <p><strong>Email: </strong>cskh@NKstore.index.php</p>
    </div>
    <div class="socials-ft">
        <ul class="list-social">
            <li><a href=""><img src="../assets/images/ic_fb.svg" style="height: 30px;" alt=""></a></li>
            <li><a href=""><img src="../assets/images/ic_gg.svg" style="height: 30px;" alt=""></a></li>
            <li><a href=""><img src="../assets/images/ic_instagram.svg" style="height: 30px;" alt=""></a></li>
            <li><a href=""><img src="../assets/images/ic_pinterest.svg" style="height: 30px;" alt=""></a></li>
            <li><a href=""><img src="../assets/images/ic_ytb.svg" style="height: 30px;" alt=""></a></li>

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
            <li><a href=""><img src="../assets/images/appstore.png" width="180" alt="" style="padding-right: 20px;"></a></li>
            <li><a href=""><img src="../assets/images/googleplay.png" width="160" alt=""></a></li>
        </ul>
    </div>
</div>




</div>
</div>
</footer>
<!-- footer -->
<script>
    $(document).ready(function() {
        // Toggle class 'open' for .list-size
        $('.add-to-cart a').click(function() {
            $(this).closest('.product').find('.list-size').toggleClass('open');
        });

        // Handle favourite click
        $('.favourite').click(function(event) {
            event.preventDefault();

            var favourite = $(this);
            var productId = favourite.data('id');
            var action = favourite.find('.fa').hasClass('fa-heart') ? 'remove' : 'add';

            $.ajax({
                type: 'POST',
                url: '/nkstore/php/addToFavorites.php',
                data: { productId: productId, action: action },
                success: function(response) {
                    console.log('Success:', response);
                    if (!response.status) {
                        if (action === 'add') {
                            favourite.find('.fa').removeClass('fa-heart-o').addClass('fa-heart');
                            console.log(response.message);
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

<script src="../js/sub-action.js"></script>
<script src="../js/menu.js"></script>
<!-- <script src="../js/cart.js"></script> -->
</body>
</html>
