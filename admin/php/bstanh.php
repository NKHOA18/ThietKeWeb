<?php
require_once("config.php");

// Lấy giá trị của biến "event" từ yêu cầu GET
$event = isset($_GET["event"]) ? $_GET["event"] : "";

// Switch case để xử lý các yêu cầu từ client dựa trên giá trị của biến "event"
switch ($event) {
    case "get_images":
        // Kiểm tra và lấy giá trị của tham số ma_san_pham từ URL
        $product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : null;
        
        // Truy vấn để lấy dữ liệu các hình ảnh từ cơ sở dữ liệu
        $sql = "SELECT alq.ma_so, alq.ma_san_pham, alq.hinh_anh , sp.ten_san_pham
                FROM anh_lien_quan alq
                LEFT JOIN san_pham sp ON sp.ma_so = alq.ma_san_pham";
        if ($product_id) {
            $sql .= " WHERE alq.ma_san_pham = ?";
        }
        
        $stmt = $conn->prepare($sql);
        if ($product_id) {
            $stmt->bind_param("i", $product_id); // Sử dụng bind_param để tránh SQL injection
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $images = array();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $images[] = $row; // Thêm mảng $row vào mảng $images
            }
        }
        
        // Trả về dữ liệu "hình ảnh" dưới dạng JSON
        header('Content-Type: application/json');
        echo json_encode($images);
        break;
    
    
    case "add_image":
        // Lấy dữ liệu từ yêu cầu POST từ biểu mẫu HTML
        $ma_san_pham = $_POST["ma_san_pham"];
        
    
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
        $sql = "INSERT INTO `anh_lien_quan` (`ma_san_pham`, `hinh_anh`) 
                VALUES ('$ma_san_pham',  '$targetFile')";
        if ($conn->query($sql) === TRUE) {
            echo "Thêm hình ảnh cho sản phẩm thành công";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
        break;
    
              

    case "delete_image":
        $ma_so = $_GET["ma_so"];
    
        // Chuẩn bị và thực thi câu lệnh SQL để xóa dữ liệu
        $sql = "DELETE FROM `anh_lien_quan` WHERE `ma_so`='$ma_so'";
        if ($conn->query($sql) === TRUE) {
            echo "Xóa hình ảnh thành công";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
        break;    
    
        

        case "get_productss":
            $sql = "SELECT `ma_so`, `ten_san_pham` FROM `san_pham`";
            $result = $conn->query($sql);
    
            $productss = array();
    
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $productss[] = $row;
                }
            }
    
            header('Content-Type: application/json');
            echo json_encode($productss);
            break;


 
    default:
        echo "Yêu cầu không hợp lệ";
}

$conn->close();
?>
