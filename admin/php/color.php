<?php
require_once("config.php");

// Lấy giá trị của biến "event" từ yêu cầu GET
$event = isset($_GET["event"]) ? $_GET["event"] : "";

// Switch case để xử lý các yêu cầu từ client dựa trên giá trị của biến "event"
switch ($event) {
    case "get_colors":
        // Truy vấn để lấy dữ liệu các thể loại từ cơ sở dữ liệu
        $sql = "SELECT `ma_so`, `ten_mau_sac` FROM `mau_sac` WHERE 1";
        $result = $conn->query($sql);

        $colors = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $color = array(
                    "ma_so" => $row["ma_so"],
                    "ten_mau_sac" => $row["ten_mau_sac"],
                );
                array_push($colors, $color);
            }
        }

        // Trả về dữ liệu "thể loại" dưới dạng JSON
        header('Content-Type: application/json');
        echo json_encode($colors);
        break;

    case "add_color":
        // Xử lý thêm một thể loại mới vào cơ sở dữ liệu
        // Lấy dữ liệu từ yêu cầu POST từ biểu mẫu HTML
        $ma_so = $_POST["ma_so"];
        $ten_mau_sac = $_POST["ten_mau_sac"];

        // Chuẩn bị và thực thi câu lệnh SQL để thêm dữ liệu
        $sql = "INSERT INTO mau_sac (ma_so, ten_mau_sac) VALUES ('$ma_so', '$ten_mau_sac')";
        if ($conn->query($sql) === TRUE) {
            echo "Thêm màu sắc thành công";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
        break;
    
    case "update_color":
    
        $ma_so = $_POST["ma_so"];
        $ten_mau_sac = $_POST["ten_mau_sac"];

        // Chuẩn bị và thực thi câu lệnh SQL để thêm dữ liệu
        $sql = "UPDATE `mau_sac` SET `ten_mau_sac`='$ten_mau_sac' WHERE `ma_so`='$ma_so'";
        if ($conn->query($sql) === TRUE) {
            echo "cập nhật màu sắc thành công";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
        break;    

    case "delete_color":
        $ma_so = $_GET["ma_so"];
    
        // Chuẩn bị và thực thi câu lệnh SQL để xóa dữ liệu
        $sql = "DELETE FROM `mau_sac` WHERE `ma_so`='$ma_so'";
        if ($conn->query($sql) === TRUE) {
            echo "Xóa thể loại thành công";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
        break;
        case "check_ma_mau_sac":
            $ma_so = $_GET["ma_so"];
        
            $sql = "SELECT COUNT(*) as count FROM mau_sac WHERE ma_so = '$ma_so'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $categoryId = $row["count"]; // Sửa thành count để lấy số lượng
        
                // Trả về kết quả dưới dạng JSON
                echo json_encode(array("hasColorId" => ($colorId > 0), "colorId" => $categoryId));
            } else {
                echo json_encode(array("hasColorId" => false, "colorId" => 0));
            }
            break;    

    default:
        echo "Yêu cầu không hợp lệ";
}

$conn->close();
?>
