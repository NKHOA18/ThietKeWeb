<?php
session_start();

$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<header id="header" class="site-header" role="banner" itemscope="" itemtype="http://schema.org/WPHeader">
    <div class="container d-flex">
        <div class="toggle"><i class="fas fa-bars"></i></div>
        <div class="main-menu">
            <ul class="menu d-flex">
                <li><a href="index.php">Trang chủ</a></li>
                <li class="category-nu">
                    <a href="cartegory.php">NỮ</a>
                    <ul class="sub-menu">
                        <li>
                            <h4><a href="" id="newArrivalLink">NEW ARRIVAL</a></h4>
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
                    <a href="cartegory.php">NAM</a>
                    <ul class="sub-menu">
                        <li>
                            <h4><a href="" id="newArrivalLink">NEW ARRIVAL</a></h4>
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
                    <a href="cartegory.php">TRẺ EM</a>
                    <ul class="sub-menu">
                        <li>
                            <h4><a href="" id="newArrivalLink">NEW ARRIVAL</a></h4>
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
            <a href="/nkstore/index.php"><img src="assets/images/NKlogo.png" alt="Đăng nhập | IVY moda"></a>
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
            <li> <a class="fas fa-headset" href="/nkstore/checkorder.php"></a></li>
            <div class="item-wallet"> 
                <li> <a id="user-icon" class="fas fa-user" href="/nkstore/login.html"></a></li>
                <div class="sub-action" id="sub-action-menu">
                    <div class="top-action">
                        <a class="icon" href="/nkstore/login.html"><h3>Tài khoản của tôi</h3></a>
                    </div>
                    <ul>
                        <li><a href="/nkstore/infouser.php"><i class="fas fa-user"></i>Thông tin tài khoản</a></li>
                        <li><a href="/nkstore/customer/order_list.php"><i class="fa fa-tasks"></i>Quản lý đơn hàng</a></li>
                        <li><a href="/nkstore/customer/address_list.php"><i class="fa fa-location-arrow"></i>Sổ địa chỉ</a></li>                   
                        <li><a href="/nkstore/customer/san-pham-yeu-thich.php"><i class="fa fa-heart-o"></i>Sản phẩm yêu thích</a></li> 
                        <li><a href="/nkstore/customer/question.php"><i class="fas fa-headset"></i>Hỏi đáp sản phẩm</a></li>                   
                        <li><a href="/nkstore/ivy-support/danh-sach"><i class="fa fa-hand-o-right"></i>Hỗ trợ - NKstore</a></li>
                        <li><a href="#"><i class="fa fa-sign-out"></i>Đăng xuất</a></li>
                    </ul>
                </div>
            </div>
            <li> <a class="icon" href="cart.php"><i class="fas fa-shopping-cart"></i>
                    <span class="number-cart"><?php echo $cart_count; ?></span>
                </a>
            </li>
        </div>
    </div>
</header>