<?php
session_start();
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> -->
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
<!-------------------------------- cart ---------------------------------->
<section class="cart">
    <div class="container-ct">
        <form name="frm_cart" id="frm_cart" method="post" action="" enctype="application/x-www-form-urlencoded">
            <input type="hidden" name="is_cart_page" value="1">
            <div class="pt-40 cart-page">
                <div class="row">
                <!--<h3>Giỏ hàng của bạn</h3>-->
                        <div class="col-lg-8">
                    <div class="checkout-process-bar block-border">
            <ul>
                <li class="active"><span>Giỏ hàng </span></li>
                <li class=""><span>Đặt hàng</span></li>
                <li class=""><span>Thanh toán</span></li>
                <li><span>Hoàn thành đơn</span></li>
            </ul>
            <p class="checkout-process-bar__title">Giỏ hàng</p>
        </div>
                    <div id="box_product_total_cart"><div class="cart__list">
            <h2 class="cart-title">Giỏ hàng của bạn <b><span id="cart-total" class="cart-total"><?php echo count($cart); ?></span> Sản Phẩm</b></h2>
                    <table class="cart__table">
                    <thead>
                    <tr>
                        <th>Tên Sản phẩm</th>
                        <th>Chiết khấu</th>
                        <th>Số lượng</th>
                        <th>Tổng tiền</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="cart-items-container">
                        <?php if (!empty($cart)): ?>
                            <?php foreach ($cart as $index => $item): ?>
                                <tr>
                                    <td>
                                        <div class="cart__product-item">
                                            <div class="cart__product-item__img">
                                                <a href="productdetails.php?product_id=<?php echo $item['productId']; ?>">
                                                    <img src="<?php echo $item['productImage']; ?>" alt="<?php echo $item['productName']; ?>">
                                                </a>
                                            </div>
                                            <div class="cart__product-item__content">
                                                <a href="">
                                                    <h3 class="cart__product-item__title"><?php echo $item['productName']; ?></h3>
                                                </a>
                                                <div class="cart__product-item__properties">
                                                    <p>Màu sắc: <span><?php echo $item['productColor']; ?></span></p>
                                                    <p>Size: <span class="text-uppercase"><?php echo $item['productSize']; ?></span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cart-sale-price">
                                        <p>-<?php echo number_format($item['productDiscount'] * $item['productPrice'] / 100, 0, ',', '.'); ?>đ</p>
                                        <p class="cart-sale_item">( -<?php echo $item['productDiscount']; ?>%)</p>
                                    </td>
                                    <td>
                                        <div class="product-detail__quantity-input" data-product-sub-id="<?php echo $item['productId']; ?>">
                                            <input type="number" value="<?php echo $item['productQuantity']; ?>" min="0" data-product-index="<?php echo $index; ?>">
                                            <div class="product-detail__quantity--increase">+</div>
                                            <div class="product-detail__quantity--decrease">-</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="cart__product-item__price"><?php echo number_format(($item['productPrice'] - ($item['productDiscount'] * $item['productPrice'] / 100)) * $item['productQuantity'], 0, ',', '.'); ?>đ</div>
                                    </td>
                                    <td>
                                        <a href="" class="remove-item-cart" data-product-index="<?php echo $index; ?>">
                                            <span class="fa fa-trash" aria-hidden="true"></span>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">Giỏ hàng trống</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <div class="cart__list--attach">
            </div></div>
                    <a href="cartegory.php" class="btn btn--large btn--outline btn-cart-continue mb-3">
                        <span class="fa fa-chevron-circle-left"></span>
                        Tiếp tục mua hàng
                    </a>
                </div>
                <div class="col-lg-4 cart-page__col-summary">
                    <div class="cart-summary" id="cart-page-summary">
                        <div class="cart-summary__overview">
                        <h3>Tổng tiền giỏ hàng</h3>
                        <?php
                            // Tính tổng số sản phẩm trong giỏ hàng
                            $totalProducts = count($cart);

                            // Tính tổng tiền hàng (chưa áp dụng giảm giá)
                            $totalNotDiscount = 0;
                            foreach ($cart as $item) {
                                $totalNotDiscount += $item['productPrice'] * $item['productQuantity'];
                            }

                            // Tính tổng thành tiền (sau khi áp dụng giảm giá nếu có)
                            $totalOrderPrice = 0;
                            foreach ($cart as $item) {
                                $totalOrderPrice += ($item['productPrice'] - ($item['productDiscount'] * $item['productPrice'] / 100)) * $item['productQuantity'];
                            }
                            ?>

                            <div class="cart-summary__overview__item">
                                <p>Tổng sản phẩm</p>
                                <p class="total-product"><?php echo $totalProducts; ?></p>
                            </div>
                            <div class="cart-summary__overview__item">
                                <p>Tổng tiền hàng</p>
                                <p class="total-not-discount"><?php echo number_format($totalNotDiscount, 0, ',', '.') . 'đ'; ?></p>
                            </div>
                            <div class="cart-summary__overview__item">
                                <p>Thành tiền</p>
                                <p><b class="order-price-total"><?php echo number_format($totalOrderPrice, 0, ',', '.') . 'đ'; ?></b></p>
                            </div>
                            <div class="cart-summary__overview__item">
                                <p>Tạm tính</p>
                                <p><b class="order-price-total"><?php echo number_format($totalOrderPrice, 0, ',', '.') . 'đ'; ?></b></p>
                            </div>
                        </div>
                        <div class="cart-summary__note">
                            <div class="inner-note d-flex">
                                <div class="left-inner-note">
                                    <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                                </div>
                                <div class="content-inner-note">
                                    <p>Miễn <b>đổi trả</b> đối với sản phẩm đồng giá / sale trên 50%</p>
                                </div>
                                <div class="left-inner-note left-inner-note-shipping d-none">
                                                    <span class="icon-ic_alert"></span>
                                            </div>
                                <div class="content-inner-note content-inner-note-shipping d-none">
                                                    <p>Miễn phí ship đơn hàng có tổng gía trị trên 2.000.000đ</p>
                                                <div class="sub-note">
                                                    Mua thêm <strong>1.525.000đ</strong> để được miễn phí SHIP
                                                    </div>
                                </div>
                            </div>
                        </div></div>
                        <div class="cart-summary__button">
                            <a href="order.html" class="btn btn--large" id="purchase-step-1">Đặt hàng</a>
                        </div>
                        <div class="cart-summary__vouchers">
                <!--            -->
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>



<!-------------------------------- cart ---------------------------------->
<!-- footer -->
<footer class="footer p-4">
    <div class="container-ft">
        <div class="row main-footer">
            <div class="left-footer col-md-6">
                <div class="top-left">
                    <div class="logo-ft"><img src="assets/images/logoNK.png" alt="logonk"></div>
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

<div id="toast-container" class="toast-bottom-right">
    <div class="toast toast-warning" aria-live="assertive" style="display: none;">
        <div class="toast-message">Đã xóa sản phẩm!</div>
    </div>
    
    <div class="toast toast-success" aria-live="polite" style="display: none;">
        <div class="toast-message">Thêm vào giỏ hàng thành công!</div>
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
<script src="js/productdetails.js"></script>
<script src="js/cart.js"></script>
</body>
</html>