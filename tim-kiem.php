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
    
    <link rel="stylesheet" href="css/toast.css">
    <link rel="stylesheet" href="css/style.css">
    <title>TsportNS</title>
</head>
<body>
    <!-- header -->
    <?php include 'header.php'; ?>
<!-- header -->


<section class="cartegory">
    <div class="container-ct">
        <div class="cartegory-top d-flex">           
            <ol class="breadcrumb__list">
                <li class="breadcrumb__item"><a class="breadcrumb__link" href="index.php">Trang chủ</a></li>
                <li class="breadcrumb__item"><a href="cartegory.php" class="breadcrumb__link" title="ÁO">Tất cả sản phẩm</a></li>
            </ol>
        </div>
    </div>
    <div class="container-ct">
        <div class="row-cart">
            <div class="cartegory-left">
                <h3>Danh mục sản phẩm</h3>
                <div class="filter-product">
                    <ul class="category-list" data-category="1">
                        <p class="item-side-title">
                            Nữ
                            <span class="fa fa-plus-circle"></span>
                            <span class="fa fa-minus-circle" style="display: none;"></span>
                        </p>
                        <li class="category-items" style="display: none;"></li>
                    </ul>
                    <ul class="category-list" data-category="2">
                        <p class="item-side-title">
                            Nam
                            <span class="fa fa-plus-circle"></span>
                            <span class="fa fa-minus-circle" style="display: none;"></span>
                        </p>
                        <li class="category-items" style="display: none;"></li>
                    </ul>
                    <ul class="category-list" data-category="3">
                        <p class="item-side-title">
                            Trẻ em
                            <span class="fa fa-plus-circle"></span>
                            <span class="fa fa-minus-circle" style="display: none;"></span>
                        </p>
                        <li class="category-items" style="display: none;"></li>
                    </ul>
                </div>

                <h3>Tìm Theo</h3>
                <div class="filter-side">
                    <ul class="list-side">
                        <li class="item-side item-side-size">
                            <p class="item-side-title">Size
                                <span class="fa fa-pluss"></span>
                                <span class="fa fa-minuss"></span>
                            </p>
                            <div class="sub-list-side d-block" >
                                <input type="hidden" name="hid_size">
                                <label class="item-sub-list po-relative">
                                    <input class="field-cat" type="radio" name="att_size[]" value="s">
                                    <span class="item-sub-title item-sub-pr ">S</span>
                                </label>
                                <label class="item-sub-list po-relative">
                                    <input class="field-cat" type="radio" name="att_size[]" value="m">
                                    <span class="item-sub-title item-sub-pr ">M</span>
                                </label>
                                <label class="item-sub-list po-relative">
                                    <input class="field-cat" type="radio" name="att_size[]" value="l">
                                    <span class="item-sub-title item-sub-pr ">L</span>
                                </label>
                                <label class="item-sub-list po-relative">
                                    <input class="field-cat" type="radio" name="att_size[]" value="xl">
                                    <span class="item-sub-title item-sub-pr ">XL</span>
                                </label>
                                <label class="item-sub-list po-relative">
                                    <input class="field-cat" type="radio" name="att_size[]" value="xxl">
                                    <span class="item-sub-title item-sub-pr ">XXL</span>
                                </label>
                                
                            </div>
                        </li>

                        <li class="item-side item-side-color">
                            <p class="item-side-title active">Màu sắc<span class="fa fa-pluss"></span><span class="fa fa-minuss"></span></p>
                            <div class="sub-list-side d-block">
                                <div class="color-filter">
                                    <input type="hidden" name="hid_color">
                                    <label class="item-sub-list po-relative">
                                        <input class="field-cat" type="radio" name="att_color[]" value="049">
                                        <span class="item-sub-title item-sub-pr " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Đen">
                                            <img src="assets/images/icon/049.png" title="Đen">
                                        </span>
                                    </label>
                                        <label class="item-sub-list po-relative">
                                        <input class="field-cat" type="radio" name="att_color[]" value="001">
                                        <span class="item-sub-title item-sub-pr bg-light" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Trắng">
                                            <img src="assets/images/icon/001.png" title="Trắng">
                                        </span>
                                    </label>
                                        <label class="item-sub-list po-relative">
                                        <input class="field-cat" type="radio" name="att_color[]" value="038">
                                        <span class="item-sub-title item-sub-pr " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Xanh dương">
                                            <img src="assets/images/icon/038.png" title="Xanh dương">
                                        </span>
                                    </label>
                                        <label class="item-sub-list po-relative">
                                        <input class="field-cat" type="radio" name="att_color[]" value="054">
                                        <span class="item-sub-title item-sub-pr " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Vàng">
                                            <img src="assets/images/icon/054.png" title="Vàng">
                                        </span>
                                    </label>
                                        <label class="item-sub-list po-relative">
                                        <input class="field-cat" type="radio" name="att_color[]" value="015">
                                        <span class="item-sub-title item-sub-pr " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Hồng">
                                            <img src="assets/images/icon/015.png" title="Hồng">
                                        </span>
                                    </label>
                                        <label class="item-sub-list po-relative">
                                        <input class="field-cat" type="radio" name="att_color[]" value="031">
                                        <span class="item-sub-title item-sub-pr " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Đỏ">
                                            <img src="assets/images/icon/031.png" title="Đỏ">
                                        </span>
                                    </label>
                                        <label class="item-sub-list po-relative">
                                        <input class="field-cat" type="radio" name="att_color[]" value="052">
                                        <span class="item-sub-title item-sub-pr " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Xám">
                                            <img src="assets/images/icon/052.png" title="Xám">
                                        </span>
                                    </label>
                                        <label class="item-sub-list po-relative">
                                        <input class="field-cat" type="radio" name="att_color[]" value="004">
                                        <span class="item-sub-title item-sub-pr " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Be">
                                            <img src="assets/images/icon/004.png" title="Be">
                                        </span>
                                    </label>
                                        <label class="item-sub-list po-relative">
                                        <input class="field-cat" type="radio" name="att_color[]" value="064">
                                        <span class="item-sub-title item-sub-pr " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Nâu">
                                            <img src="assets/images/icon/064.png" title="Nâu">
                                        </span>
                                    </label>
                                        <label class="item-sub-list po-relative">
                                        <input class="field-cat" type="radio" name="att_color[]" value="035">
                                        <span class="item-sub-title item-sub-pr " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Xanh lá">
                                            <img src="assets/images/icon/035.png" title="Xanh lá">
                                        </span>
                                    </label>
                                        <label class="item-sub-list po-relative">
                                        <input class="field-cat" type="radio" name="att_color[]" value="011">
                                        <span class="item-sub-title item-sub-pr " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Cam">
                                            <img src="assets/images/icon/011.png" title="Cam">
                                        </span>
                                    </label>
                                    <label class="item-sub-list po-relative">
                                        <input class="field-cat" type="radio" name="att_color[]" value="033">
                                        <span class="item-sub-title item-sub-pr " data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Tím">
                                            <img src="assets/images/icon/033.png" title="Tím">
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </li>
                        <li class="item-side item-side-discount">
                            <p class="item-side-title  active">Mức chiết khấu<span class="icon-ic_plus"></span><span class="icon-ic_minus"></span></p>
                            <div class="sub-list-side" style="display: block;">
                            <input type="hidden" name="hid_discount">
                                    <label class="item-sub-list po-relative">
                                <input class="field-cat" type="radio" name="att_discount" value="1">
                                <span class="item-sub-title item-sub-pr">Dưới 30%</span>
                            </label>
                                    <label class="item-sub-list po-relative">
                                <input class="field-cat" type="radio" name="att_discount" value="2">
                                <span class="item-sub-title item-sub-pr ">Từ 30% - 50%</span>
                            </label>
                                    <label class="item-sub-list po-relative">
                                <input class="field-cat" type="radio" name="att_discount" value="3">
                                <span class="item-sub-title item-sub-pr ">Từ 50% - 70%</span>
                            </label>
                                    <label class="item-sub-list po-relative">
                                <input class="field-cat" type="radio" name="att_discount" value="4">
                                <span class="item-sub-title item-sub-pr ">Từ 70%</span>
                            </label>
                                    <label class="item-sub-list po-relative">
                                <input class="field-cat" type="radio" name="att_discount" value="5">
                                <span class="item-sub-title item-sub-pr ">Giá đặc biệt</span>
                            </label>
                                </div>
                        </li>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // Lấy tất cả các radio button trong color-filter và item-side-discount
                                const colorFilters = document.querySelectorAll('.color-filter .field-cat');
                                const discountFilters = document.querySelectorAll('.item-side-discount .field-cat');
                        
                                // Xử lý sự kiện khi chọn radio button trong color-filter
                                colorFilters.forEach(function(input) {
                                    input.addEventListener('change', function() {
                                        // Xóa lớp active từ tất cả các label trong color-filter
                                        document.querySelectorAll('.color-filter .item-sub-title').forEach(function(label) {
                                            label.classList.remove('active');
                                        });
                        
                                        this.closest('label').querySelector('.item-sub-title').classList.add('active');
                                    });
                                });
                        
                                // Xử lý sự kiện khi chọn radio button trong item-side-discount
                                discountFilters.forEach(function(input) {
                                    input.addEventListener('change', function() {
                                        // Xóa lớp active từ tất cả các label trong item-side-discount
                                        document.querySelectorAll('.item-side-discount .item-sub-title').forEach(function(label) {
                                            label.classList.remove('active');
                                        });
                        
                                        this.closest('label').querySelector('.item-sub-title').classList.add('active');
                                    });
                                });
                            });
                        </script>
                        
                        <li class="item-side item-side-collection">
                            <div class="collection-filter">
                                <p class="item-side-title active">Giá</p>
                                <div class="sub-list-side" id="filter-price">                               
                                    <label class="d-block">
                                        <input class="le-readio" name="att_price" type="checkbox" value="1">
                                        <i class="fake-box"></i>
                                        <span> Tất cả </span>
                                    </label>    

                                    <label>
                                        <input class="le-readio active" name="att_price" type="checkbox" value="2">
                                        <i class="fake-box"></i>
                                        <span>	0 VNĐ ~ 1.000.000 VNĐ</span>
                                    </label>
                    
                                    <label>
                                        <input class="le-readio" name="att_price" type="checkbox" value="3">
                                        <i class="fake-box"></i>
                                        <span>	1.000.000VNĐ ~ 2.000.000VNĐ</span></label>
                                
                                    <label>
                                        <input class="le-readio" name="att_price" type="checkbox" value="4">
                                        <i class="fake-box"></i>
                                        <span>	2.000.000VNĐ ~ 3.000.000 VNĐ</span></label>
                                
                                    <label>
                                        <input class="le-readio active" name="att_price" type="checkbox" value="5">
                                        <i class="fake-box"></i>
                                        <span>	3.000.000VNĐ ~ 5.000.000 VNĐ</span></label>
                                
                                    <label>
                                        <input class="le-readio" name="att_price" type="checkbox" value="6">
                                        <i class="fake-box"></i>
                                        <span>	Trên 5.000.000VNĐ</span></label>
                                    
                                </div>
                            </div>
                        </li>

                    </ul>
                    <div class="col-md-12 p-0" style="margin-top: 30px">
                        <div class="row m-0 p-0">
                            <div class="col-7">
                                <button type="button" class="btn btn--large but_filter_remove" style="font-size: 13px;padding: 10px 20px;">Bỏ lọc</button>
                            </div>
                            <div class="col-5">
                                <button type="button" class="btn btn--large btn--outline but_filter_product" style="font-size: 13px;padding: 10px 20px;">Lọc</button>
                            </div>
                        </div>
                        <p class="required" id="msg_error_size_color"></p>
                    </div>
                </div>
            </div>

            

            <div class="cartegory-right">
                <div class="top-main d-flex">
                    <div class="cartegory-right-top-item">
                        <h3>Kết Quả tìm Kiếm theo </h3>
                    </div>
                    <div class="cartegory-right-top-item">
                        <div class="item-filter">
                            <span class="hi">Sắp xếp theo <i class="fa fa-chevron-down"></i></span>
                            <input type="hidden" name="sel_order" value="">
                                <div class="list-number-row">
                                    <div class="item-number-row">
                                        <a href="javascript:void(0)" class="sel-order-option" data-value="">Mặc định</a>
                                    </div>
                                    <div class="item-number-row">
                                        <a href="javascript:void(0)" class="sel-order-option" data-value="latest">Mới nhất</a>
                                    </div>
                                    <div class="item-number-row">
                                        <a href="javascript:void(0)" class="sel-order-option" data-value="best_seller">Được mua nhiều nhất</a>
                                    </div>
                                    <div class="item-number-row">
                                        <a href="javascript:void(0)" class="sel-order-option" data-value="favourite">Được yêu thích nhất</a>
                                    </div>
                                    <div class="item-number-row">
                                        <a href="javascript:void(0)" class="sel-order-option" data-value="price_desc">Giá: cao đến thấp</a>
                                    </div>
                                    <div class="item-number-row">
                                        <a href="javascript:void(0)" class="sel-order-option" data-value="price_asc">Giá: thấp đến cao</a>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!-- <div class="sidebar-prod">
                        <div class="filter-search">
                            <i class="fa fa-filter"></i>
                        </div>
                    </div>  -->
                </div>
                <div class="sub-main-prod">
                    <div class="list-products list-products-cat d-flex">
                        <div class="item-cat-product">
                            <div class="product">
                                <span class="badget">-20<span>%</span></span>
                            <div class="thumb-product">
                                <a href="/sanpham/set-bo-tuysi-phoi-blazer-ms-61m8395-38233">
                                <img src="assets/nkstore/sp1.webp" alt="Set bộ Tuysi phối blazer" class="lazy">
                                </a>
                            </div>
                            <div class="info-product">
                                <div class="list-color">
                                    <ul>
                                        <li class="">
                                            <a href="javascript:void(0)" class="color-picker" data-id="38232">
                                                <img src="assets/images/icon/035.png" alt="035" class="lazy">
                                            </a>
                                        </li>
                                        <li class="checked ">
                                            <a href="javascript:void(0)" class="color-picker" data-id="38233">
                                                <img src="assets/images/icon/010.png" alt="010" class="lazy">
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="favourite" data-id="38233">
                                        <i class="fa fa-heart-o"></i>
                                    </div>
                                </div>
                                <h3 class="title-product">
                                    <a href="/sanpham/set-bo-tuysi-phoi-blazer-ms-61m8395-38233">Set bộ Tuysi phối blazer</a>
                                </h3>
                                <div class="price-product">
                                    <ins>
                                    <span>1.504.000đ</span>
                                    </ins>
                                    <del>
                                    <span>1.880.000đ</span>
                                    </del>
                                </div>
                            </div>
                            <div class="add-to-cart">
                                <a href="javascript:void(0)"><i class="fa fa-shopping-bag"></i></a>
                            </div>
                            <div class="list-size">
                                <ul>
                                <li data-product-sub-id="186168"><button class="btn bt-large">s</button></li>
                                    <li data-product-sub-id="186177"><button class="btn bt-large">m</button></li>
                                    <li data-product-sub-id="186189"><button class="btn bt-large">l</button></li>
                                    <li data-product-sub-id="186199"><button class="btn bt-large">xl</button></li>
                                    <li data-product-sub-id="186211"><button class="btn bt-large">xxl</button></li>
                                </ul>
                            </div>
                        </div>
                        </div>

                    </div>
                </div>

                <ul class="list-inline-pagination">
                    <li><a href="#">«</a></li>
                    <li id="products_active_ts"><a href="#">1</a></li>
                    <li><a href="">2</a></li>
                    <li><a href="">3</a></li>
                    <li><a href="">4</a></li>
                    <li><a href="">5</a></li>
                    <li><a href="">»</a></li>
                    <li class="last-page"><a href="">Trang cuối</a></li>
                </ul>

            </div>

        </div>
    </div>
</section>


<!-- cartegory -->
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
    <div class="toast toast-warning" aria-live="assertive" style="display: none;">
        <div class="toast-message">Đã xóa sản phẩm!</div>
    </div>
    
    <div class="toast toast-success" aria-live="polite" style="display: none;">
        <div class="toast-message">Thêm vào giỏ hàng thành công!</div>
    </div>
        
</div>
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
<script src="js/sub-action.js"></script>
<script src="js/timkiemsanpham.js"></script>
<script src="js/menu.js"></script>
<script src="js/item-filter.js"></script>
<!-- <script src="js/productdetails.js"></script> -->

</body>
</html>
