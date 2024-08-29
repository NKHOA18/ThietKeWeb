<?php
include_once('admin/php/config.php'); // Đảm bảo đường dẫn hợp lý

// Kiểm tra kết nối
if ($conn->connect_error) {
    die(json_encode(["error" => "Kết nối thất bại: " . $conn->connect_error]));
}

// Lấy sản phẩm theo nhóm
function getProductsByGroup($groupId, $conn) {
    $sql = "SELECT sp.ma_so, sp.ten_san_pham, sp.hinh_anh, sp.gia, sp.muc_giam, sp.ngay_tao, tl.nhom, tt.ma_mau_sac, tt.ma_kich_co
            FROM san_pham sp
            LEFT JOIN the_loai tl ON sp.ma_the_loai = tl.ma_so
            LEFT JOIN thuoc_tinh_san_pham tt ON tt.ma_san_pham = sp.ma_so
            WHERE tl.nhom = $groupId
            ORDER BY sp.ngay_tao DESC";

    $result = $conn->query($sql);

    // Lưu trữ các sản phẩm đã lấy ra với mã số khác nhau
    $products = [];
    $ma_so_seen = [];
    while ($row = $result->fetch_assoc()) {
        if (!in_array($row['ma_so'], $ma_so_seen)) {
            $products[] = $row;
            $ma_so_seen[] = $row['ma_so'];
            if (count($products) >= 10) {
                break;
            }
        }
    }

    return $products;
}

// Lấy sản phẩm cho từng nhóm
$productGroups = [
    "women" => getProductsByGroup(1, $conn),
    "men" => getProductsByGroup(2, $conn),
    "kids" => getProductsByGroup(3, $conn)
];

// Trả về kết quả dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($productGroups);

$conn->close();

// Các hàm hỗ trợ
function maColor($ma_mau_sac) {
    return $ma_mau_sac < 10 ? '0' . $ma_mau_sac : $ma_mau_sac;
}

function maSize($ma_kich_co) {
    switch($ma_kich_co) {
        case "1":
            return "S";
        case "2":
            return "M";
        case "3":
            return "L";
        case "4":
            return "XL";
        case "5":
            return "XXL";
        default:
            return "S";
    }
}

function maDiscount($muc_giam) {
    if ($muc_giam < 30) {
        return 1; 
    } else if ($muc_giam >= 30 && $muc_giam < 50) {
        return 2; 
    } else if ($muc_giam >= 50 && $muc_giam < 70) {
        return 3; 
    } else if ($muc_giam >= 70) {
        return 4; 
    } else if ($muc_giam === 299) {
        return 5; 
    } else {
        return 0; 
    }
}
?>
