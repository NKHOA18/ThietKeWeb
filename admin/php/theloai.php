<?php
require_once("config.php");

// Lấy giá trị của biến "event" từ yêu cầu GET
$event = isset($_GET["event"]) ? $_GET["event"] : "";

// Switch case để xử lý các yêu cầu từ client dựa trên giá trị của biến "event"
switch ($event) {
    case "get_categories":
        // Truy vấn để lấy dữ liệu các thể loại từ cơ sở dữ liệu
        $sql = "SELECT `ma_so`, `ten_the_loai`, `nhom` FROM `the_loai` WHERE 1";
        $result = $conn->query($sql);

        $categories = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $category = array(
                    "ma_so" => $row["ma_so"],
                    "ten_the_loai" => $row["ten_the_loai"],
                    "nhom" => $row["nhom"]
                );
                array_push($categories, $category);
            }
        }

        // Trả về dữ liệu "thể loại" dưới dạng JSON
        header('Content-Type: application/json');
        echo json_encode($categories);
        break;

    case "add_category":
        // Xử lý thêm một thể loại mới vào cơ sở dữ liệu
        // Lấy dữ liệu từ yêu cầu POST từ biểu mẫu HTML
        $ma_so = $_POST["ma_so"];
        $ten_the_loai = $_POST["ten_the_loai"];
        $nhom = $_POST["nhom"];

        // Chuẩn bị và thực thi câu lệnh SQL để thêm dữ liệu
        $sql = "INSERT INTO the_loai (ma_so, ten_the_loai, nhom) VALUES ('$ma_so', '$ten_the_loai', '$nhom')";
        if ($conn->query($sql) === TRUE) {
            echo "Thêm thể loại thành công";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
        break;
    
    case "update_category":
    
        $ma_so = $_POST["ma_so"];
        $ten_the_loai = $_POST["ten_the_loai"];
        $nhom = $_POST["nhom"];

        // Chuẩn bị và thực thi câu lệnh SQL để thêm dữ liệu
        $sql = "UPDATE `the_loai` SET `ten_the_loai`='$ten_the_loai',`nhom`='$nhom' WHERE `ma_so`='$ma_so'";
        if ($conn->query($sql) === TRUE) {
            echo "cập nhật thể loại thành công";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
        break;    

    case "delete_category":
        $ma_so = $_GET["ma_so"];
    
        // Chuẩn bị và thực thi câu lệnh SQL để xóa dữ liệu
        $sql = "DELETE FROM `the_loai` WHERE `ma_so`='$ma_so'";
        if ($conn->query($sql) === TRUE) {
            echo "Xóa thể loại thành công";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
        break;

    case "check_products":
        $ma_so = $_GET["ma_so"];
    
        // Chuẩn bị truy vấn SQL để kiểm tra
        $sql = "SELECT COUNT(*) AS product_count FROM `san_pham` WHERE `ma_the_loai`='$ma_so'";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $product_count = $row["product_count"];
    
            // Trả về kết quả dưới dạng JSON
            echo json_encode(array("hasProducts" => ($product_count > 0), "product_count" => $product_count));
        } else {
            echo json_encode(array("hasProducts" => false, "product_count" => 0));
        }
        break;
        
        

        case "delete_products":
            $ma_so = $_GET["ma_so"];
        
            // Kiểm tra xem có sản phẩm nào cần xóa không
            $sql_check = "SELECT COUNT(*) AS product_count FROM `san_pham` WHERE `ma_the_loai`='$ma_so'";
            $result_check = $conn->query($sql_check);
            $row_check = $result_check->fetch_assoc();
            $product_count = $row_check["product_count"];
        
            if ($product_count > 0) {
                // Chuẩn bị và thực thi câu lệnh SQL để xóa dữ liệu
                $sql_delete = "DELETE FROM `san_pham` WHERE `ma_the_loai`='$ma_so'";
                if ($conn->query($sql_delete) === TRUE) {
                    echo "Xóa sản phẩm thành công";
                } else {
                    echo "Lỗi khi xóa sản phẩm: " . $conn->error;
                }
            } else {
                echo "Không có sản phẩm cần xóa";
            }
            break;
        case "check_ma_the_loai":
            $ma_so = $_GET["ma_so"];
        
            $sql = "SELECT COUNT(*) as count FROM the_loai WHERE ma_so = '$ma_so'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $categoryId = $row["count"]; // Sửa thành count để lấy số lượng
        
                // Trả về kết quả dưới dạng JSON
                echo json_encode(array("hasCategoryId" => ($categoryId > 0), "categoryId" => $categoryId));
            } else {
                echo json_encode(array("hasCategoryId" => false, "categoryId" => 0));
            }
            break;
        

    default:
        echo "Yêu cầu không hợp lệ";
}

$conn->close();
?>
