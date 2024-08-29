<?php
require_once("config.php");

// Lấy giá trị của biến "event" từ yêu cầu GET
$event = isset($_GET["event"]) ? $_GET["event"] : "";

// Switch case để xử lý các yêu cầu từ client dựa trên giá trị của biến "event"
switch ($event) {
    case "get_sizes":
        // Truy vấn để lấy dữ liệu các thể loại từ cơ sở dữ liệu
        $sql = "SELECT `ma_so`, `ten_kich_co` FROM `kich_co` WHERE 1";
        $result = $conn->query($sql);

        $sizes = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $size = array(
                    "ma_so" => $row["ma_so"],
                    "ten_kich_co" => $row["ten_kich_co"],
                );
                array_push($sizes, $size);
            }
        }

        // Trả về dữ liệu "thể loại" dưới dạng JSON
        header('Content-Type: application/json');
        echo json_encode($sizes);
        break;

    case "add_size":
        // Xử lý thêm một thể loại mới vào cơ sở dữ liệu
        // Lấy dữ liệu từ yêu cầu POST từ biểu mẫu HTML
        $ma_so = $_POST["ma_so"];
        $ten_kich_co = $_POST["ten_kich_co"];

        // Chuẩn bị và thực thi câu lệnh SQL để thêm dữ liệu
        $sql = "INSERT INTO kich_co (ma_so, ten_kich_co) VALUES ('$ma_so', '$ten_kich_co')";
        if ($conn->query($sql) === TRUE) {
            echo "Thêm màu sắc thành công";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
        break;
    
    case "update_size":
    
        $ma_so = $_POST["ma_so"];
        $ten_kich_co = $_POST["ten_kich_co"];

        // Chuẩn bị và thực thi câu lệnh SQL để thêm dữ liệu
        $sql = "UPDATE `kich_co` SET `ten_kich_co`='$ten_kich_co' WHERE `ma_so`='$ma_so'";
        if ($conn->query($sql) === TRUE) {
            echo "cập nhật màu sắc thành công";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
        break;    

    case "delete_size":
        $ma_so = $_GET["ma_so"];
    
        // Chuẩn bị và thực thi câu lệnh SQL để xóa dữ liệu
        $sql = "DELETE FROM `kich_co` WHERE `ma_so`='$ma_so'";
        if ($conn->query($sql) === TRUE) {
            echo "Xóa thể loại thành công";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
        break;
        case "check_ma_kich_co":
            $ma_so = $_GET["ma_so"];
        
            $sql = "SELECT COUNT(*) as count FROM kich_co WHERE ma_so = '$ma_so'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $categoryId = $row["count"]; // Sửa thành count để lấy số lượng
        
                // Trả về kết quả dưới dạng JSON
                echo json_encode(array("hasSizeId" => ($sizeId > 0), "sizeId" => $categoryId));
            } else {
                echo json_encode(array("hasSizeId" => false, "sizeId" => 0));
            }
            break;    

    default:
        echo "Yêu cầu không hợp lệ";
}

$conn->close();
?>
