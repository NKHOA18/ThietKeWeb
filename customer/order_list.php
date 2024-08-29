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
                                <li class="active">
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
                <div class="col-lg-8 col-xl col-account-content" style="left: -120px;">
                <?php
                    $user_id = $userInfo[0]['ma_so'];
                    $sql = "SELECT ct.ma_don_hang, dh.ngay_tao, dh.trang_thai_don_hang, sp.ten_san_pham, ct.gia, ct.so_luong
                            FROM chi_tiet_don_hang ct
                            LEFT JOIN don_hang dh ON dh.ma_so = ct.ma_don_hang
                            LEFT JOIN san_pham sp ON sp.ma_so = ct.ma_san_pham
                            LEFT JOIN nguoi_dung nd ON nd.ma_so = dh.ma_nguoi_dung
                            WHERE nd.ma_so = ?";
        
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('i', $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    $list_order = [];
                    while ($row = $result->fetch_assoc()) {
                        // Translate status code to readable label using statusOrder function
                        $row['trang_thai_don_hang'] = statusOrder($row['trang_thai_don_hang']);
                        $list_order[] = $row;
                    }

                    function statusOrder($status){
                        switch($status){
                            case '1' :
                                return 'Đang xử lý';
                            case '2' :
                                return 'Chờ giao vận';
                            case '4':
                                return 'Đã nhận hàng';
                            case '3' :
                                return 'Đã gửi';
                            case '5' :
                                return 'Đã hủy';
                            case '6':
                                return 'Trả hàng';
                            default:
                                return $status; // Handle any other cases not listed above
                        }
                    }
                    ?>

                    <div class="order-block__title">
                        <h2>QUẢN LÝ ĐƠN HÀNG</h2>
                        <div class="form-group" style="margin-left: 300px;">
                            <label> Trạng thái đơn hàng:</label>
                            <select class="form-control rounded ng-pristine ng-untouched ng-valid ng-empty" ng-model="status" ng-change="list()">
                                <option value="" selected="selected">Tất cả</option>
                                <option value="0">Đặt hàng thành công</option>
                                <option value="1">Đang xử lý</option>
                                <option value="2">Chờ giao vận</option>
                                <option value="3">Đã gửi</option>
                                <option value="4">Đã nhận hàng</option>
                                <option value="5">Đã hủy</option>
                                <option value="6">Trả hàng</option>
                            </select>
                        </div>
                    </div>

                    <div class="order-block">
                        <table class="order-block__table">
                            <thead>
                                <tr>
                                    <th>MÃ ĐƠN HÀNG</th>
                                    <th>NGÀY</th>
                                    <th style="width: 210px">TRẠNG THÁI</th>
                                    <th>SẢN PHẨM</th>
                                    <th>TỔNG TIỀN</th>
                                </tr>
                            </thead>
                            <tbody id="orderTableBody">
                                <!-- Dynamic content will be inserted here -->
                            </tbody>
                        </table>
                    </div>

                    <div class="product-rating__list-pagination">
                        <ul class="list-inline-pagination" id="pagination">
                            <!-- Pagination links will be dynamically added here -->
                        </ul>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                        var listOrders = <?php echo json_encode($list_order); ?>;
                        var itemsPerPage = 9;
                        var currentPage = 1;
                        
                        function displayOrders(pageNumber) {
                            currentPage = pageNumber;
                            var startIndex = (pageNumber - 1) * itemsPerPage;
                            var endIndex = startIndex + itemsPerPage;
                            var pageOrders = listOrders.slice(startIndex, endIndex);

                            var tableBody = document.getElementById('orderTableBody');
                            var listHtml = '';
                            pageOrders.forEach(function(order) {
                                listHtml += '<tr>' +
                                                '<td><a href="/nkstore/orderdetail.php?orderId=' + order.ma_don_hang + '">NK' + order.ma_don_hang + '</a></td>' +
                                                '<td>' + order.ngay_tao + '</td>' +
                                                '<td>' + order.trang_thai_don_hang + '</td>' +
                                                '<td>' + order.so_luong + 'x ' + order.ten_san_pham + '</td>' +
                                                '<td><span class="price ng-binding">' + new Intl.NumberFormat().format(order.gia) + ' ₫</span></td>' +
                                            '</tr>';
                            });

                            tableBody.innerHTML = listHtml;
                            updatePagination();
                        }

                        function updatePagination() {
                            var totalPages = Math.ceil(listOrders.length / itemsPerPage);
                            var paginationHtml = '';
                            for (var i = 1; i <= totalPages; i++) {
                                paginationHtml += '<li><a href="/nkstore/customer/order_list.php?page=' + i + '" onclick="displayOrders(' + i + '); return false;">' + i + '</a></li>';
                            }
                            document.getElementById('pagination').innerHTML = paginationHtml;
                        }

                        displayOrders(currentPage);
                    });

                    </script>

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

<script src="../js/sub-action.js"></script>
<script src="../js/menu.js"></script>
<!-- <script src="../js/cart.js"></script> -->
</body>
</html>
<?php
// Đóng kết nối và giải phóng biến
$stmt->close();
$conn->close();
?>