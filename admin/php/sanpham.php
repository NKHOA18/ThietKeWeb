<?php
require_once("config.php");

// Lấy giá trị của biến "event" từ yêu cầu GET
$event = isset($_GET["event"]) ? $_GET["event"] : "";

// Switch case để xử lý các yêu cầu từ client dựa trên giá trị của biến "event"
switch ($event) {
    case "get_products":
        // Truy vấn để lấy dữ liệu các thể loại từ cơ sở dữ liệu
        $sql = "SELECT `ma_so`, `ten_san_pham`, `hinh_anh`, `gia`, `muc_giam`, `mo_ta`, `so_luong`, `ma_the_loai`, `trang_thai` FROM `san_pham` WHERE 1";
        $result = $conn->query($sql);

        $products = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $product = array(
                    "ma_so" => $row["ma_so"],
                    "ten_san_pham" => $row["ten_san_pham"],
                    "hinh_anh" => $row["hinh_anh"],
                    "gia" => $row["gia"],
                    "muc_giam" => $row["muc_giam"],
                    "mo_ta" => $row["mo_ta"],
                    "so_luong" => $row["so_luong"],
                    "ma_the_loai" => $row["ma_the_loai"],
                    "trang_thai" => $row["trang_thai"],
                );
                array_push($products, $product);
            }
        }

        // Trả về dữ liệu "thể loại" dưới dạng JSON
        header('Content-Type: application/json');
        echo json_encode($products);
        break;

    case "add_product":
        // Lấy dữ liệu từ yêu cầu POST từ biểu mẫu HTML
        $ten_san_pham = $_POST["ten_san_pham"];
        $gia = $_POST["gia"];
        $muc_giam = $_POST["muc_giam"];
        $mo_ta = $_POST["mo_ta"];
        $so_luong = $_POST["so_luong"];
        $ma_the_loai = $_POST["ma_the_loai"];
        $trang_thai = $_POST["trang_thai"];
    
        // Xử lý upload hình ảnh
        if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] == 0) {
            $targetDir = "D:/xampp/htdocs/nkstore/assets/nkstore/uploads/";
            $targetFile = $targetDir . basename($_FILES["hinh_anh"]["name"]);

            if ($_FILES['hinh_anh']['size'] > 5000000) { // Giới hạn dung lượng 5MB
                echo "Lỗi: Dung lượng tệp tin quá lớn.";
                exit;
            }
            $fileInfo = pathinfo($targetFile);
            while (file_exists($targetFile)) {
                $targetFile = $targetDir . $fileInfo['filename'] . '_' . uniqid() . '.' . $fileInfo['extension'];
            }

            if (move_uploaded_file($_FILES["hinh_anh"]["tmp_name"], $targetFile)) {
                // Thành công khi di chuyển hình ảnh, tiếp tục thêm vào cơ sở dữ liệu
                $targetFile = str_replace("D:/xampp/htdocs/nkstore/", "", $targetFile);
            } else {
                echo "Lỗi khi lưu tệp tin hình ảnh.";
                exit;
            }
        } else {
            $targetFile = "";
        }
    
        // Chuẩn bị và thực thi câu lệnh SQL để thêm dữ liệu
        $sql = "INSERT INTO `san_pham`(`ten_san_pham`, `hinh_anh`, `gia`, `muc_giam`, `mo_ta`, `so_luong`, `ma_the_loai`, `trang_thai`) 
                VALUES ('$ten_san_pham', '$targetFile', '$gia', '$muc_giam', '$mo_ta', '$so_luong', '$ma_the_loai', b'$trang_thai')";
        if ($conn->query($sql) === TRUE) {
            echo "Thêm sản phẩm thành công";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
        break;
    
    case "update_product":
        $ma_so = $_POST["ma_so"];
        $ten_san_pham = $_POST["ten_san_pham"];
        $gia = $_POST["gia"];
        $muc_giam = $_POST["muc_giam"];
        $mo_ta = $_POST["mo_ta"];
        $so_luong = $_POST["so_luong"];
        $ma_the_loai = $_POST["ma_the_loai"];
        $trang_thai = $_POST["trang_thai"];
    
        // Xử lý upload hình ảnh mới nếu có
        $targetFile = ""; // Biến lưu đường dẫn hình ảnh mới
        if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] == UPLOAD_ERR_OK) {
            $targetDir = "D:/xampp/htdocs/nkstore/assets/nkstore/uploads/";
            $targetFile = $targetDir . basename($_FILES["hinh_anh"]["name"]);
    
            // Kiểm tra dung lượng tệp tin
            if ($_FILES['hinh_anh']['size'] > 5000000) { // Giới hạn dung lượng 5MB
                echo "Lỗi: Dung lượng tệp tin quá lớn.";
                exit;
            }
    
            // Di chuyển tệp tin vào thư mục đích
            if (!move_uploaded_file($_FILES["hinh_anh"]["tmp_name"], $targetFile)) {
                echo "Lỗi khi lưu tệp tin hình ảnh.";
                exit;
            }
    
            // Định dạng lại đường dẫn hình ảnh
            $targetFile = str_replace("D:/xampp/htdocs/nkstore/", "../", $targetFile);
        }
    
        // Cập nhật thông tin sản phẩm, bao gồm cả hình ảnh nếu có thay đổi
        if (!empty($targetFile)) {
            $sql = "UPDATE `san_pham` SET `ten_san_pham`='$ten_san_pham', `hinh_anh`='$targetFile', `gia`='$gia', `muc_giam`='$muc_giam', `mo_ta`='$mo_ta', `so_luong`='$so_luong', `ma_the_loai`='$ma_the_loai', `trang_thai`= b'$trang_thai' WHERE `ma_so`='$ma_so'";
        } else {
            $sql = "UPDATE `san_pham` SET `ten_san_pham`='$ten_san_pham', `gia`='$gia', `muc_giam`='$muc_giam', `mo_ta`='$mo_ta', `so_luong`='$so_luong', `ma_the_loai`='$ma_the_loai', `trang_thai`= b'$trang_thai' WHERE `ma_so`='$ma_so'";
        }
    
        if ($conn->query($sql) === TRUE) {
            echo "Cập nhật sản phẩm thành công";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
        break;
              

    case "delete_product":
        $ma_so = $_GET["ma_so"];
    
        // Chuẩn bị và thực thi câu lệnh SQL để xóa dữ liệu
        $sql = "DELETE FROM `san_pham` WHERE `ma_so`='$ma_so'";
        if ($conn->query($sql) === TRUE) {
            echo "Xóa sản phẩm thành công";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
        break;    
    
    case "update_status":
        $ma_so = $_GET["ma_so"];
        $trang_thai = $_GET["trang_thai"];
        
        $sql = "UPDATE `san_pham` SET `trang_thai`= b'$trang_thai' WHERE `ma_so`='$ma_so'";
    
        if ($conn->query($sql) === TRUE) {
            echo "Cập nhật sản phẩm thành công";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
        break;
            
        

    case "get_categories":
        $sql = "SELECT `ma_so`, `ten_the_loai` , nhom FROM `the_loai` WHERE 1";
        $result = $conn->query($sql);

        $categories = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $category = array(
                    "ma_so" => $row["ma_so"],
                    "ten_the_loai" => $row["ten_the_loai"],
                    "nhom" => row["nhom"]
                );
                array_push($categories, $category);
            }
        }

        header('Content-Type: application/json');
        echo json_encode($categories);
        break;


    case "check_ma_so":
        $ma_so = $_GET["ma_so"];

        $sql = "SELECT COUNT(*) as count FROM san_pham WHERE ma_so = '$ma_so'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $productId = $row["count"]; // Sửa thành count để lấy số lượng
    
            // Trả về kết quả dưới dạng JSON
            echo json_encode(array("hasProductId" => ($productId > 0), "productId" => $productId));
        } else {
            echo json_encode(array("hasProductId" => false, "productId" => 0));
        }
        break;
    default:
        echo "Yêu cầu không hợp lệ";
}

$conn->close();
?>
