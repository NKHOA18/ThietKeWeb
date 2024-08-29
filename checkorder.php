<?php
include_once('admin/php/config.php'); // Ensure the correct path

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Kết nối thất bại: " . $conn->connect_error]));
}
$orderId = isset($_GET['orderId']) ? intval($_GET['orderId']) : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['but_order_find'])) {
    $orderId = $_POST['order_invoice_no'];
    $phone = $_POST['shipping_phone'];

    $sql = "SELECT ct.ma_don_hang, dh.ngay_tao, dh.trang_thai_don_hang, sp.ten_san_pham, ct.gia, ct.so_luong
            FROM chi_tiet_don_hang ct
            LEFT JOIN don_hang dh ON dh.ma_so = ct.ma_don_hang
            LEFT JOIN san_pham sp ON sp.ma_so = ct.ma_san_pham
            LEFT JOIN nguoi_dung nd ON nd.ma_so = dh.ma_nguoi_dung
            WHERE ct.ma_don_hang = ? AND dh.so_dien_thoai = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $orderId, $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    $list_order = [];
    while ($row = $result->fetch_assoc()) {
        // Translate status code to readable label using statusOrder function
        $row['trang_thai_don_hang'] = statusOrder($row['trang_thai_don_hang']);
        $list_order[] = $row;
    }

    $stmt->close();
}

function statusOrder($status){
    switch($status){
        case '1' :
            return 'Đang xử lý';
        case '2' :
            return 'Chờ giao vận';
        case '3':
            return 'Đã nhận hàng';
        case '4' :
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
<?php include 'header.php'; ?>

<!-------------------------------- forgotpass ---------------------------------->
<section class="login">
    <div class="container">
        <style>
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
            input[type=number] {
                -moz-appearance: textfield;
            }
            .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                border-color: inherit;
            }
        </style>
        <form enctype="application/x-www-form-urlencoded" method="post" action="">
            <div class="row">
                <div class="container">
                    <div class="breadcrumb-products">
                        <ol class="breadcrumb__list">
                            <li class="breadcrumb__item"><a class="breadcrumb__link" href="index.php">Trang chủ</a></li>
                            <li class="breadcrumb__item"><a href="checkorder.php" class="breadcrumb__link" title="Tra cứu đơn hàng">Tra cứu đơn hàng</a></li>
                        </ol>
                    </div>
                </div>
                <div class="col-md-3 col-xs-12"></div>
                <div class="col-md-6 col-xs-12 py-1">
                    <div class="order-block__title justify-content-center pb-3">
                        <h3>Tra cứu đơn hàng</h3>
                    </div>
                    <div class="row form-group align-items-center">
                        <label class="col-5 form-label">Mã đơn <span style="color: red">*</span></label>
                        <div class="col-7">
                            <input type="text" name="order_invoice_no" class="form-control" required="" placeholder="NK123456" value="<?php echo $orderId; ?>">
                        </div>
                    </div>
                    <div class="row form-group align-items-center">
                        <label class="col-5 form-label">Số điện thoại <span style="color: red">*</span></label>
                        <div class="col-7">
                            <input type="text" name="shipping_phone" class="form-control" required="" placeholder="02432052222">
                        </div>
                    </div>
                    <div class="form-group justify-content-center pt-2">
                        <button type="submit" class="btn btn--large m-auto but-common-black" name="but_order_find">Tra cứu</button>
                    </div>
                </div>
                <div class="col-md-3"></div>
                <div class="col-lg-12 col-xl">
                    <?php if (!empty($list_order)): ?>
                    <div class="order-block__title">
                        <h2>THEO DÕI ĐƠN HÀNG</h2>
                    </div>
                    <div class="order-block" style="padding: 0 80px">
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
                                <?php foreach ($list_order as $order): ?>
                                <tr>
                                    <td><a href="/nkstore/orderdetail.php?orderId=<?php echo $order['ma_don_hang']; ?>">NK<?php echo $order['ma_don_hang']; ?></a></td>
                                    <td><?php echo $order['ngay_tao']; ?></td>
                                    <td><?php echo $order['trang_thai_don_hang']; ?></td>
                                    <td><?php echo $order['so_luong']; ?>x <?php echo $order['ten_san_pham']; ?></td>
                                    <td><span class="price ng-binding"><?php echo number_format($order['gia']); ?> ₫</span></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="order-block__title">
                        <h2>Không tìm thấy đơn hàng</h2>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </form>
        <div class="clearfix" style="padding-top: 10px"></div>
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