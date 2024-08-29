<?php
include_once('admin/php/config.php'); // Đảm bảo đường dẫn hợp lý

// Kiểm tra kết nối
if ($conn->connect_error) {
    die(json_encode(["error" => "Kết nối thất bại: " . $conn->connect_error]));
}

// Kiểm tra nếu có tham số product_id trên URL
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : null;
$size_name = isset($_GET['size']) ? strtolower($_GET['size']) : null;

// Hàm kiểm tra size đã chọn để đánh dấu là 'checked'
function checked_size($size, $selectedSize) {
    return strtolower($size) === $selectedSize ? 'checked' : '';
} 
// Câu truy vấn SQL để lấy chi tiết sản phẩm
$sql = "SELECT sp.ma_so, sp.ten_san_pham, sp.hinh_anh, sp.gia, sp.muc_giam, sp.mo_ta, sp.ma_the_loai, sp.trang_thai, tl.ten_the_loai, tt.ma_mau_sac, tt.mo_ta_them, ms.ten_mau_sac
        FROM san_pham sp
        LEFT JOIN thuoc_tinh_san_pham tt ON sp.ma_so = tt.ma_san_pham
        LEFT JOIN the_loai tl ON sp.ma_the_loai = tl.ma_so
        LEFT JOIN mau_sac ms ON ms.ma_so = tt.ma_mau_sac
        WHERE sp.ma_so = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $product_id);
$stmt->execute();
$result = $stmt->get_result();

// Lấy chỉ một bản ghi từ kết quả truy vấn
$row = $result->fetch_assoc();

if ($row) {
    // Lấy thông tin từng cột
    $ma_so = $row['ma_so'];
    $ten_san_pham = $row['ten_san_pham'];
    $hinh_anh = $row['hinh_anh'];
    $gia = $row['gia'];
    $muc_giam = $row['muc_giam'];
    $mo_ta = $row['mo_ta'];
    $trang_thai = $row['trang_thai'];
    $ma_the_loai = $row['ma_the_loai'];
    $ten_the_loai = $row['ten_the_loai'];
    $mo_ta_them = $row['mo_ta_them'];
    

    // Tính toán giá khuyến mãi
    if ($muc_giam > 0 && $muc_giam < 100) {
        $gia_khuyen_mai = $gia * (1 - $muc_giam / 100);
    } else {
        // Nếu mức giảm không hợp lệ (nếu có), giữ nguyên giá gốc
        $gia_khuyen_mai = $gia;
    }

    $sql_cs = "SELECT tt.ma_mau_sac, ms.ten_mau_sac, kc.ten_kich_co
            FROM thuoc_tinh_san_pham tt
            LEFT JOIN mau_sac ms ON ms.ma_so = tt.ma_mau_sac
            LEFT JOIN kich_co kc ON kc.ma_so = tt.ma_kich_co
            WHERE tt.ma_san_pham = ?";

    $stmt_cs = $conn->prepare($sql_cs);
    $stmt_cs->bind_param('i', $product_id);
    $stmt_cs->execute();
    $result_cs = $stmt_cs->get_result();

    $colors = [];
    $sizes = [];

    while ($row_cs = $result_cs->fetch_assoc()) {
        $colors[$row_cs['ma_mau_sac']] = $row_cs['ten_mau_sac'];
        $sizes[] = strtolower($row_cs['ten_kich_co']);
    }
    function add_slash_if_not_in_list($size, $sizes) {
        return in_array(strtolower($size), $sizes) ? 'text-uppercase' : 'text-uppercase slash';
    }
    function check_size_in_list($size, $sizes) {
        return in_array(strtolower($size), $sizes) ? $size : ' ';
    }    
    // Hiển thị thông tin sản phẩm và giá khuyến mãi
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
        <!----------------------------- product -------------------------- -->
        <section class="cartegory">
            <div class="container-ct">
                <div class="cartegory-top d-flex">
                    <ol class="breadcrumb__list">
                        <li class="breadcrumb__item"><a class="breadcrumb__link" href="index.php">Trang chủ</a></li>
                        <li class="breadcrumb__item"><a href="cartegory.php?category=<?php echo $ma_the_loai; ?>" class="breadcrumb__link" title="Áo croptop"><?php echo $ten_the_loai; ?></a></li>
                        <li class="breadcrumb__item"><a class="breadcrumb__link" title="<?php echo $ten_san_pham; ?>"><?php echo $ten_san_pham; ?></a></li>
                    </ol>
                </div>
                <div class="product-detail">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="slick-main" id="main-slider">
                                    <div class="product-img1"><img src="<?php echo $hinh_anh; ?>" width="480px" height="480px" alt="adi1"></div>
                                    <?php
                                        // Câu truy vấn ảnh liên quan
                                        $sql_related_images = "SELECT alq.ma_so, alq.ma_san_pham, alq.hinh_anh
                                                                FROM san_pham sp
                                                                LEFT JOIN anh_lien_quan alq ON sp.ma_so = alq.ma_san_pham
                                                                WHERE sp.ma_so = ?";
                                        $stmt_related_images = $conn->prepare($sql_related_images);
                                        $stmt_related_images->bind_param('i', $product_id);
                                        $stmt_related_images->execute();
                                        $result_related_images = $stmt_related_images->get_result();

                                        $related_images = [];
                                        while ($row_related_image = $result_related_images->fetch_assoc()) {
                                            $related_images[] = $row_related_image;
                                        }

                                        // Lặp qua các ảnh liên quan và hiển thị
                                        foreach ($related_images as $row_related_image) {
                                            $ma_so_anh = $row_related_image['ma_so'];
                                            $anh_lien_quan = $row_related_image['hinh_anh'];
                                            ?>
                                            <div class="product-img1"><img src="<?php echo $anh_lien_quan; ?>" width="480px" height="480px" alt="main<?php echo $ma_so_anh; ?>"></div>
                                            <?php
                                        }
                                        ?>
                                </div>
                                
                                <div class="slick-nav d-flex" id="thumbnail-slider">
                                    <div class="product-nav-img"><img src="<?php echo $hinh_anh; ?>" alt="adi1"></div>
                                    <?php
                                        // Lặp qua các ảnh liên quan và hiển thị trong thumbnail slider
                                        foreach ($related_images as $row_related_image) {
                                            $ma_so_anh = $row_related_image['ma_so'];
                                            $anh_lien_quan = $row_related_image['hinh_anh'];
                                            ?>
                                            <div class="product-nav-img"><img src="<?php echo $anh_lien_quan; ?>" alt="thumb<?php echo $ma_so_anh; ?>"></div>
                                            <?php
                                        }
                                        ?>
                                    
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="product-detail__information">
                                    <input type="hidden" name="type_sanpham" value="Nữ">
                                    <h1 style="text-transform: uppercase;"><?php echo $ten_san_pham; ?></h1>
                                    <div class="product-detail__sub-info">
                                        <p>
                                            SKU: <span><?php echo $ma_so; ?></span>
                                        </p>
                                        <div class="product-detail__rating">
                                            <div class="product-detail__rating-wrapper" data-percentage="100">
                                                <div class="product-detail__rating__background"></div>
                                                <div class="product-detail__rating__bar" style="width: 100%;"></div>
                                            </div>
                                            <span>(0 đánh giá)</span>
                                        </div>
                                    </div>
                                    <div class="product-detail__price">
                                        <input type="hidden" name="hid_product_price_not_format" value="<?php echo $gia; ?>">
                                        <b><?php echo number_format($gia_khuyen_mai, 0, ',', '.'); ?>đ</b>
                                        <del><?php echo number_format($gia, 0, ',', '.'); ?>đ</del>
                                        <div class="product-detail__price-sale">-<?php echo $muc_giam; ?><span>%</span></div>
                                    </div>
                                    <div class="product-detail__color">
                                        <p>Màu sắc: <span id="selected-color"><?php echo reset($colors); ?></span></p>
                                        <div class="product-detail__color__input">
                                            <?php foreach ($colors as $ma_mau_sac => $ten_mau_sac) { ?>
                                                <label class="bg-light">
                                                    <input type="radio" name="color" value="<?php echo $ten_mau_sac; ?>" data-ma-mau="<?php echo sprintf("%02d", $ma_mau_sac); ?>" <?php echo $ma_mau_sac == key($colors) ? 'checked' : ''; ?>>
                                                    <span>
                                                        <img src="assets/images/icon/0<?php echo sprintf("%02d", $ma_mau_sac); ?>.png" alt="0<?php echo sprintf("%02d", $ma_mau_sac); ?>" style="border-radius: 50%;">
                                                    </span>
                                                </label>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="product-detail__size">
                                        <div class="product-detail__size__input">
                                            <label>
                                                <input type="radio" name="size" value="<?php echo htmlspecialchars(check_size_in_list('s', $sizes)); ?>" <?php echo htmlspecialchars(checked_size('s', $size_name)); ?> data-product-sub-id="194807" data-product-sub-key="1610B97860030023">
                                                <span class="<?php echo add_slash_if_not_in_list('s', $sizes); ?>">s</span>
                                            </label>
                                            <label>
                                                <input type="radio" name="size" value="<?php echo htmlspecialchars(check_size_in_list('m', $sizes)); ?>" <?php echo htmlspecialchars(checked_size('l', $size_name)); ?>  data-product-sub-id="194809" data-product-sub-key="1620B97860030023">
                                                <span class="<?php echo add_slash_if_not_in_list('m', $sizes); ?>">m</span>
                                            </label>
                                            <label>
                                                <input type="radio" name="size" value="<?php echo htmlspecialchars(check_size_in_list('l', $sizes)); ?>" <?php echo htmlspecialchars(checked_size('m', $size_name)); ?>  data-product-sub-id="194812" data-product-sub-key="1630B97860030023">
                                                <span class="<?php echo add_slash_if_not_in_list('l', $sizes); ?>">l</span>
                                            </label>
                                            <label>
                                                <input type="radio" name="size" value="<?php echo htmlspecialchars(check_size_in_list('xl', $sizes)); ?>" <?php echo htmlspecialchars(checked_size('xl', $size_name)); ?>  data-product-sub-id="194815" data-product-sub-key="1640B97860030023">
                                                <span class="<?php echo add_slash_if_not_in_list('xl', $sizes); ?>">xl</span>
                                            </label>
                                            <label>
                                                <input type="radio" name="size" value="<?php echo htmlspecialchars(check_size_in_list('xxl', $sizes)); ?>" <?php echo htmlspecialchars(checked_size('xxl', $size_name)); ?>  data-product-sub-id="194817" data-product-sub-key="1650B97860030023">
                                                <span class="<?php echo add_slash_if_not_in_list('xxl', $sizes); ?>">xxl</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="product-detail__quantity">
                                        <p style="font-size: 16px; font-weight: 500; line-height: 1.2; vertical-align: baseline; margin-bottom: 0">Số lượng</p>
                                        <div class="product-detail__quantity-input">
                                            <input type="hidden" name="size_checked" value="m" data-quantity="11">
                                            <input type="hidden" name="product_sub_id" value="189385">
                                            <input type="number" value="1" name="quantity" max="11" id="quantityInput">
                                            <div class="product-quantity product-detail__quantity--increase">+</div>
                                            <div class="product-quantity product-detail__quantity--decrease">-</div>
                                        </div>                                
                                    </div>
                                    <div class="product-detail__actions <?php echo ($trang_thai == 2) ? 'het-hang' : ''; ?>">
                                        <?php if ($trang_thai == 2): ?>
                                            <button class="btn btn--large bag-gray mr-3" style="font-size: 15px;padding: 10px 20px;">
                                                Hết hàng
                                            </button>
                                            <button class="btn btn--large btn--outline btn--wishlist" data-id="<?php echo $ma_so; ?>" style="padding: 10px 10px;">
                                                <i class="fa fa-heart-o"></i>
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn--large add-to-cart-detail" style="font-size: 15px;padding: 10px 20px;">
                                                Thêm vào giỏ
                                            </button>                               
                                            <a href="javascript:void(0)" id="purchase">
                                                <button class="btn btn--large btn--outline" style="font-size: 15px;padding: 10px 20px;">
                                                    Mua hàng
                                                </button>
                                            </a>
                                            <button class="btn btn--large btn--outline btn--wishlist" data-id="<?php echo $ma_so; ?>" style="padding: 10px 10px;">
                                                <i class="fa fa-heart-o"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                    <div class="product-detail__tab">
                                        <div class="product-detail__tab-header">
                                            <div class="tab-item active">
                                                <span>GIỚI THIỆU</span>
                                            </div>
                                            <div class="tab-item">
                                                <span>CHI TIẾT SẢN PHẨM</span>
                                            </div>
                                            <div class="tab-item">
                                                <span>BẢO HÀNH</span>
                                            </div>
                                        </div>
                                        <div class="product-detail__tab-body">
                                            <div class="tab-content hideContent active">
                                                <p><?php echo $mo_ta; ?></p>

                                            </div>
                                            <div class="tab-content hideContent">
                                                
                                                    <?php 
                                                        $attributes = explode(", ", $mo_ta_them);

                                                        echo '<table class="" width="70%">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="padding-bottom:5px;"><b>Dòng sản phẩm</b></td>
                                                                    <td style="padding-bottom:5px;">' . $attributes[0] . '</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding-bottom:5px;"><b>Nhóm sản phẩm</b></td>
                                                                    <td style="padding-bottom:5px;">' . $attributes[1] . '</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding-bottom:5px;"><b>Kiểu dáng</b></td>
                                                                    <td style="padding-bottom:5px;">' . $attributes[2] . '</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding-bottom:5px;"><b>Độ dài</b></td>
                                                                    <td style="padding-bottom:5px;">' . $attributes[3] . '</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding-bottom:5px;"><b>Họa tiết</b></td>
                                                                    <td style="padding-bottom:5px;">' . $attributes[4] . '</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding-bottom:5px;"><b>Chất liệu</b></td>
                                                                    <td style="padding-bottom:5px;">' . $attributes[5] . '</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>';
                                                    ?>
                                            </div>
                                            <div class="tab-content hideContent">
                                                <p>Chi tiết bảo quản sản phẩm :&nbsp;</p>

                                                <p><strong>* Các sản phẩm thuộc dòng cao cấp (Senora) và áo khoác (dạ, tweed,&nbsp;lông, phao) chỉ giặt khô,&nbsp;tuyệt đối không giặt ướt.</strong></p>

                                                <p>* Vải dệt kim: sau khi giặt sản phẩm phải được phơi ngang tránh bai giãn.</p>

                                                <p>* Vải voan, lụa, chiffon nên giặt bằng tay.</p>

                                                <p>* Vải thô, tuytsi, kaki không có phối hay trang trí đá cườm thì có thể giặt máy.</p>

                                                <p>* Vải thô, tuytsi, kaki có&nbsp;phối màu tương phản hay trang trí voan, lụa, đá cườm thì cần giặt tay.</p>

                                                <p>* Đồ Jeans nên hạn chế giặt bằng máy giặt vì sẽ làm phai màu jeans. Nếu giặt thì&nbsp;nên lộn trái sản phẩm khi giặt, đóng khuy, kéo khóa, không nên giặt chung cùng đồ sáng màu, tránh dính màu vào các sản phẩm khác.&nbsp;</p>

                                                <p>* Các sản phẩm cần được giặt ngay không ngâm tránh bị loang màu, phân biệt màu và loại vải để tránh trường hợp vải phai. Không nên giặt sản phẩm với xà phòng có chất tẩy mạnh, nên giặt cùng xà phòng pha loãng.</p>

                                                <p>* Các sản phẩm có thể&nbsp;giặt bằng máy thì chỉ nên để chế độ giặt nhẹ, vắt mức trung bình và nên phân các loại sản phẩm cùng màu và cùng loại vải khi giặt.</p>

                                                <p>* Nên phơi sản phẩm tại chỗ thoáng mát, tránh ánh nắng trực tiếp sẽ dễ bị phai bạc màu, nên làm khô quần áo bằng cách phơi ở những điểm gió sẽ giữ màu vải tốt hơn.</p>

                                                <p>* Những chất vải 100% cotton, không nên phơi sản phẩm bằng mắc áo mà nên vắt ngang sản phẩm lên dây phơi để tránh tình trạng rạn vải.</p>

                                                <p>* Khi ủi sản phẩm bằng bàn là và sử dụng chế độ hơi nước sẽ làm cho sản phẩm dễ ủi phẳng, mát và không bị cháy, giữ màu sản phẩm được đẹp và bền lâu hơn. Nhiệt độ của bàn là tùy theo từng loại vải.&nbsp;</p>

                                            </div>
                                            <div class="show-more">
                                                <a>
                                                    <img class="image-down" src="assets/images/icon/image-down.png" alt="image down">
                                                    <img class="image-up hideImg" src="assets/images/icon/image-up.png" alt="image down">
                                                </a>
                                                <div class="inline"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>   
                </div>
            

                <div class="product-related">
                    <div class="block-title">
                        sản phẩm liên quan
                    </div>
                    <div class="product-list">
                        <?php
                        // Câu truy vấn SQL để lấy sản phẩm liên quan dựa trên ma_the_loai
                        $sql_related_products = "SELECT sp.ma_so, sp.ten_san_pham, sp.hinh_anh, sp.gia, sp.muc_giam, sp.mo_ta, tt.ma_mau_sac
                                                FROM san_pham sp
                                                LEFT JOIN thuoc_tinh_san_pham tt ON tt.ma_san_pham = sp.ma_so
                                                WHERE sp.ma_the_loai = ? AND sp.ma_so != ?
                                                ORDER BY sp.ma_so
                                                LIMIT 50"; // Giới hạn số sản phẩm liên quan hiển thị
                        $stmt_related_products = $conn->prepare($sql_related_products);
                        $stmt_related_products->bind_param('ii', $ma_the_loai, $ma_so);
                        $stmt_related_products->execute();
                        $result_related_products = $stmt_related_products->get_result();

                        $grouped_products = [];

                        // Nhóm các sản phẩm theo mã số sản phẩm
                        while ($row_related = $result_related_products->fetch_assoc()) {
                            $related_id = $row_related['ma_so'];
                            if (!isset($grouped_products[$related_id])) {
                                $grouped_products[$related_id] = [
                                    'ma_so' => $related_id,
                                    'ten_san_pham' => $row_related['ten_san_pham'],
                                    'hinh_anh' => $row_related['hinh_anh'],
                                    'gia' => $row_related['gia'],
                                    'muc_giam' => $row_related['muc_giam'],
                                    'mo_ta' => $row_related['mo_ta'],
                                    'colors' => []
                                ];
                            }
                            $grouped_products[$related_id]['colors'][] = $row_related['ma_mau_sac'];
                        }

                        // Hiển thị sản phẩm liên quan
                        foreach ($grouped_products as $product) {
                            $related_id = $product['ma_so'];
                            $related_name = $product['ten_san_pham'];
                            $related_image = $product['hinh_anh'];
                            $related_price = $product['gia'];
                            $related_discount = $product['muc_giam'];
                            $related_final_price = $related_discount > 0 ? $related_price * (1 - $related_discount / 100) : $related_price;

                            // Tạo danh sách màu sắc
                            $colorsHTML = '';
                            foreach ($product['colors'] as $index => $color) {
                                if ($color < 10) {
                                    $color = sprintf("%02d", $color);
                                }
                                $colorsHTML .= '
                                    <li class="' . ($index === 0 ? 'checked' : '') . '">
                                        <img src="assets/images/icon/0' . $color . '.png" alt="0' . $color . '" class="owl-lazy" style="opacity: 1;">
                                    </li>';
                            }
                            ?>
                            <div class="item">
                                <div class="item-cat-product">
                                    <div class="product">
                                        <?php if ($related_discount > 0) { ?>
                                            <span class="badget">-<?php echo $related_discount; ?><span>%</span></span>
                                        <?php } ?>
                                        <div class="thumb-product">
                                            <a href="productdetails.php?product_id=<?php echo $related_id; ?>">
                                                <img src="<?php echo $related_image; ?>" alt="<?php echo $related_name; ?>" class="lazy">
                                            </a>
                                        </div>
                                        <div class="info-product">
                                            <div class="list-color">
                                                <ul>
                                                    <?php echo $colorsHTML; ?>
                                                </ul>
                                                <div class="favourite" data-id="<?php echo $related_id; ?>">
                                                    <i class="fa fa-heart-o"></i>
                                                </div>                                               
                                            </div>
                                            <h3 class="title-product">
                                                <a href="productdetails.php?product_id=<?php echo $related_id; ?>"><?php echo $related_name; ?></a>
                                            </h3>
                                            <div class="price-product">
                                                <ins><span><?php echo number_format($related_final_price, 0, ',', '.'); ?>&nbsp;₫</span></ins>
                                                <?php if ($related_discount > 0) { ?>
                                                    <del><span><?php echo number_format($related_price, 0, ',', '.'); ?>&nbsp;₫</span></del>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>




                </div>            
            </div>

        </section>
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
        <div id="notification" class="notification">
            <span>
                <i class="fa fa-shopping-bag" aria-hidden="true"></i>
            </span>
            <h2>Đã thêm vào giỏ hàng thành công!</h2>
        </div>                
        <script src="js/sub-action.js"></script>
        <script src="js/menu.js"></script>
        <script src="js/productdetails.js"></script>
        <!-- <script src="js/cart.js"></script> -->
        </body>
        </html>
    <?php
} else {
    // Hiển thị thông báo nếu không tìm thấy sản phẩm
    echo "Không tìm thấy sản phẩm.";
}

// Đóng kết nối và giải phóng biến
$stmt->close();
$conn->close();
?>


