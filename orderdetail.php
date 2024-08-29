<?php
include_once('admin/php/config.php'); // Đảm bảo đường dẫn hợp lý

// Kiểm tra kết nối
if ($conn->connect_error) {
    die(json_encode(["error" => "Kết nối thất bại: " . $conn->connect_error]));
}

// Kiểm tra nếu có tham số orderId trên URL
$orderId = isset($_GET['orderId']) ? intval($_GET['orderId']) : null;

$sql = "SELECT ct.`ma_don_hang`, ct.ma_san_pham, sp.hinh_anh, sp.ten_san_pham, tt.ma_mau_sac, tt.ma_kich_co, dh.dia_chi, dh.so_dien_thoai, sp.muc_giam, ct.so_luong, ct.`gia`
        FROM `chi_tiet_don_hang` ct
        LEFT JOIN don_hang dh ON dh.ma_so = ct.ma_don_hang
        LEFT JOIN san_pham sp ON sp.ma_so = ct.ma_san_pham
        LEFT JOIN thuoc_tinh_san_pham tt ON tt.ma_so = ct.ma_thuoc_tinh_sp
        WHERE ct.ma_don_hang = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $orderId);
$stmt->execute();
$result = $stmt->get_result();

$orderDetails = [];

while ($row = $result->fetch_assoc()) {
    $orderDetails[] = $row;
}

if (count($orderDetails) > 0) {
    // Lấy thông tin đơn hàng từ bản ghi đầu tiên
    $dia_chi = $orderDetails[0]['dia_chi'];
    $so_dien_thoai = $orderDetails[0]['so_dien_thoai'];
    $ma_don_hang = $orderDetails[0]['ma_don_hang'];

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

    function maColor($ma_mau_sac){
            switch($ma_mau_sac) {
                case "1":
                    return "Trắng";
                case "4":
                    return "Be";
                case "11":
                    return "Cam";
                case "15":
                    return "Hồng";
                case "31":
                    return "Đỏ";
                case "33":
                    return "Tím";
                case "35":
                    return "Xanh lá";
                case "38":
                    return "Xanh dương";
                case "49":
                    return "Đen";
                case "52":
                    return "Xám";
                case "54":
                    return "Vàng";
                case "64":
                    return "Nâu";
                default:
                    return "Trắng"; // Mặc định trả về mã cho màu Trắng nếu không tìm thấy
            }
        
    }

?>
    <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            
            <!--  -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
            <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>

            <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
            <script src="css/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="css/bootstrap-5.3.3-dist/css/bootstrap.min.css">
            
            <link rel="stylesheet" href="css/style.css">
            <link rel="stylesheet" href="css/toast.css">
            <title>TsportNS</title>
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
        <!-- header -->
    <!-------------------------------- orderdetail ---------------------------------->
    <section class="delivery">
        <div class="container-ct">
            <div class="cart pt-40 checkout">
                <form action="" method="post" enctype="application/x-www-form-urlencoded">
                    <div class="row">
                        <div class="col-lg-12 col-2xl-9" style="border-right: 2px solid #e7e8e9; margin-bottom: 20px;">
                            <div class="col-lg-8 checkout-process-bar block-border">
                                <ul>
                                    <li class="active"><span>Giỏ hàng </span></li>
                                    <li class="active"><span>Đặt hàng</span></li>
                                    <li class="active"><span>Thanh toán</span></li>
                                    <li class="active"><span>Hoàn thành đơn</span></li>
                                </ul>
                                <p class="checkout-process-bar__title">Giỏ hàng</p>
                            </div>
                            
                            <div class="checkout-my-cart" style="display: block; margin-top: 20px;">
                                <div class="cart__list">
                                    <h2 class="cart-title" data-orderid="<?php echo $ma_don_hang; ?>">Chi tiết đơn hàng của bạn</h2>
                                    <table class="cart__table">
                                        <thead>
                                        <tr>
                                            <th>Tên Sản phẩm</th>
                                            <th>Số lượng</th>
                                            <th>Địa chỉ</th>
                                            <th>Số điện thoại</th>
                                            <th>Chiết khấu</th>
                                            <th>Giá tiền</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $tongTienHang = 0;
                                        $soLuongSanPham = 0;
                                        $tongChietKhau = 0;

                                        foreach ($orderDetails as $item):
                                            $giaKhuyenMai = $item['gia'] / $item['so_luong'];
                                            $tongTienHang += $item['gia'] + $giaKhuyenMai * $item['so_luong'];
                                            $soLuongSanPham += $item['so_luong'];
                                            $tongChietKhau +=  $giaKhuyenMai * $item['so_luong'];
                                        ?>
                                            <tr>
                                                <td>
                                                    <div class="cart__product-item">
                                                        <div class="cart__product-item__img">
                                                            <a href="productdetails.php?product_id=<?php echo $item['ma_san_pham']; ?>">
                                                                <img src="<?php echo $item['hinh_anh']; ?>" alt="<?php echo $item['ten_san_pham']; ?>">
                                                            </a>
                                                        </div>
                                                        <div class="cart__product-item__content">
                                                            <a href="">
                                                                <h3 class="cart__product-item__title">
                                                                    <?php echo $item['ten_san_pham']; ?>
                                                                </h3>
                                                            </a>
                                                            <div class="cart__product-item__properties">
                                                                <p>Màu sắc: <span><?php echo maColor($item['ma_mau_sac']); ?></span></p>
                                                                <p>Size: <span><?php echo maSize($item['ma_kich_co']); ?></span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="order-detail-quantity" style="text-align: center;">
                                                        <?php echo $item['so_luong']; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="order-detail-address"><?php echo $dia_chi; ?></div>
                                                </td>
                                                <td>
                                                    <div class="order-detail-phone"><?php echo $so_dien_thoai; ?></div>
                                                </td>
                                                <td class="cart-sale-price">
                                                    <p><?php echo number_format($giaKhuyenMai, 0, ',', '.'); ?>đ</p>
                                                    <p class="cart-sale_item">
                                                        (-<?php echo $item['muc_giam']; ?>%)
                                                    </p>
                                                </td>
                                                <td>
                                                    <div class="cart__product-item__price"><?php echo number_format($item['gia'], 0, ',', '.'); ?>đ</div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-2xl-3 cart-page__col-summary" style="border-style: solid; border-radius: 20px 0px;">
                            <div class="cart-summary">
                                <div id="box_product_total"><div class="cart-summary__overview">
                                    <h3>Thông tin hóa đơn</h3>
                                    <div class="cart-summary__overview__item">
                                        <p>Tổng tiền hàng</p>
                                        <p><?php echo number_format($tongTienHang, 0, ',', '.'); ?>đ</p>
                                    </div>
                                    <div class="cart-summary__overview__item">
                                        <p>Số lượng sản phẩm</p>
                                        <p><?php echo $soLuongSanPham; ?></p>
                                    </div>
                                    <div class="cart-summary__overview__item">
                                        <p>Tổng chiết khấu</p>
                                        <p><?php echo number_format($tongChietKhau, 0, ',', '.'); ?>đ</p>
                                    </div>
                                    <div class="cart-summary__overview__item">
                                        <p>Tạm tính</p>
                                        <p><?php echo number_format($tongTienHang - $tongChietKhau, 0, ',', '.'); ?>đ</p>
                                    </div>
                                    <div class="cart-summary__overview__item">
                                        <p>Phí vận chuyển</p>
                                        <p>50.000đ</p>
                                    </div>
                                    <div class="cart-summary__overview__item">
                                        <p>Tiền thanh toán</p>
                                        <p><b><?php echo number_format($tongTienHang + 50000, 0, ',', '.'); ?>đ</b></p>
                                    </div>
                
                                <!-- Google tag manager -->
                                        <div class="d-none">
                                            <div id="list-item-info">
                                                <p id="item-id">187699</p>
                                                <p id="item-name">Áo thun trơn Slim fit MS 57E3464</p>
                                                <p id="item-price">690000</p>
                                                <p id="item-discount">517500</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cart-summary__button">
                                <button type="button" name="btn_end" class="btn btn--large btn--outline" value="Quản lý đơn hàng">Đơn hàng của bạn</button>
                            </div>
                        </div>
                    </div>
                    <div class="check-otp-order"></div>
                </form>
            </div>
        </div>
    </section>
    <!-------------------------------- orderdetail ---------------------------------->
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
    <div id="notification" class="notification">
        <span>
            <i class="fa fa-shopping-bag" aria-hidden="true"></i>
        </span>
        <h2>Đã thêm vào giỏ hàng thành công!</h2>
    </div>                
    <script src="js/sub-action.js"></script>
    <script src="js/menu.js"></script>
    <script src="js/orderdetail.js"></script>
    <!-- <script src="js/cart.js"></script> -->
    </body>
    </html>
    <?php
} else {
    // Hiển thị thông báo nếu không tìm thấy sản phẩm
    echo "Không tìm thấy đơn hàng.";
}

// Đóng kết nối và giải phóng biến
$stmt->close();
$conn->close();
?>