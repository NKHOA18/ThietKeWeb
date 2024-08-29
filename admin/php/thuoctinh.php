<?php
require_once("config.php");

$event = isset($_GET["event"]) ? $_GET["event"] : "";

switch ($event) {
    case "get_attributes":
        $sql = "SELECT tt.ma_so, tt.ma_san_pham, tt.ma_mau_sac, tt.ma_kich_co, tt.mo_ta_them, sp.ten_san_pham
                FROM `thuoc_tinh_san_pham` tt
                LEFT JOIN san_pham sp ON sp.ma_so = tt.ma_san_pham";
        $result = $conn->query($sql);

        $attributes = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $attributes[] = $row;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($attributes);
        break;

    case "add_attribute":
        $maSanPham = $_POST['ma_san_pham'];
        $maMauSac = $_POST['ma_mau_sac'];
        $maKichCo = $_POST['ma_kich_co'];
        $moTaThem = $_POST['mo_ta_them'];

        $sql = "INSERT INTO `thuoc_tinh_san_pham` ( `ma_san_pham`, `ma_mau_sac`, `ma_kich_co`, `mo_ta_them`, `trang_thai`)
                VALUES ('$maSanPham', '$maMauSac', '$maKichCo', '$moTaThem','1')";

        if ($conn->query($sql) === TRUE) {
            echo "Thêm thuộc tính sản phẩm thành công";
        } else {
            echo "Lỗi khi thêm thuộc tính: " . $conn->error;
        }
        break;

    case "delete_attribute":
        $ma_so = $_GET["ma_so"];

        $sql = "DELETE FROM `thuoc_tinh_san_pham` WHERE `ma_so`='$ma_so'";
        if ($conn->query($sql) === TRUE) {
            echo "Xóa thuộc tính sản phẩm thành công";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
        break;

    case "get_colors":
        $sql = "SELECT `ma_so`, `ten_mau_sac` FROM `mau_sac`";
        $result = $conn->query($sql);

        $colors = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $colors[] = $row;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($colors);
        break;

    case "get_products":
        $sql = "SELECT `ma_so`, `ten_san_pham` FROM `san_pham`";
        $result = $conn->query($sql);

        $products = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($products);
        break;

    case "get_sizes":
        $sql = "SELECT `ma_so`, `ten_kich_co` FROM `kich_co`";
        $result = $conn->query($sql);

        $sizes = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sizes[] = $row;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($sizes);
        break;

    default:
        echo "Yêu cầu không hợp lệ";
}

$conn->close();
?>
