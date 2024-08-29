<?php
require_once("config.php");

// Lấy giá trị của biến "event" từ yêu cầu GET
$event = isset($_GET["event"]) ? $_GET["event"] : "";

// Switch case để xử lý các yêu cầu từ client dựa trên giá trị của biến "event"
switch ($event) {
    case "get_orders":
        $sql = "SELECT `ma_so`, `ten_nguoi_dung`, `so_dien_thoai`, `dia_chi`, `ngay_tao`, `trang_thai_thanh_toan`, `trang_thai_don_hang` FROM `don_hang`";
        $result = $conn->query($sql);

        $users = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $user = array(
                    "ma_so" => $row["ma_so"],
                    "ten_nguoi_dung" => $row["ten_nguoi_dung"],
                    "so_dien_thoai" => $row["so_dien_thoai"],
                    "dia_chi" => $row["dia_chi"],
                    "ngay_tao" => $row["ngay_tao"],
                    "trang_thai_thanh_toan" => $row["trang_thai_thanh_toan"],
                    "trang_thai_don_hang" => $row["trang_thai_don_hang"]
                );
                array_push($users, $user);
            }
        }

        // Trả về dữ liệu "thể loại" dưới dạng JSON
        header('Content-Type: application/json');
        echo json_encode($users);
        break;

    case "update_orderstatus":
        $ma_so = $_POST["ma_so"];
        $trang_thai_don_hang = $_POST["trang_thai_don_hang"];
    
        $sql = "UPDATE `don_hang` SET `trang_thai_don_hang`= '$trang_thai_don_hang' WHERE `ma_so`='$ma_so'";
    
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["success" => true, "message" => "Cập nhật trạng thái thành công"]);
        } else {
            echo json_encode(["success" => false, "message" => "Lỗi: " . $sql . "<br>" . $conn->error]);
        }
        break;
    
    case "delete_order":
        $ma_so = $_POST["ma_so"];
    
        $sql = "DELETE FROM `don_hang` WHERE `ma_so`='$ma_so'";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["success" => true, "message" => "Xóa đơn hàng thành công"]);
        } else {
            echo json_encode(["success" => false, "message" => "Lỗi: " . $sql . "<br>" . $conn->error]);
        }
        break;  
    
    case "check_orderdetails":
        $ma_so = $_GET["ma_so"];
    
        $sql = "SELECT COUNT(*) AS orderdetail_count FROM `chi_tiet_don_hang` WHERE `ma_don_hang`='$ma_so'";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $orderdetail_count = $row["orderdetail_count"];
    
            echo json_encode(array("hasOrderdetails" => ($orderdetail_count > 0), "orderdetail_count" => $orderdetail_count));
        } else {
            echo json_encode(array("hasOrderdetails" => false, "orderdetail_count" => 0));
        }
        break;
    
    case "delete_orderdetails":
        $ma_so = $_POST["ma_so"];
    
        $sql = "DELETE FROM `chi_tiet_don_hang` WHERE `ma_don_hang`='$ma_so'";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["success" => true, "message" => "Xóa chi tiết đơn hàng thành công"]);
        } else {
            echo json_encode(["success" => false, "message" => "Lỗi: " . $sql . "<br>" . $conn->error]);
        }
        break;
    
    default:
        echo "Yêu cầu không hợp lệ";
    }
        
        


$conn->close();
?>
