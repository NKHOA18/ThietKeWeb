<?php
require_once("config.php");

// Lấy giá trị của biến "event" từ yêu cầu GET
$event = isset($_GET["event"]) ? $_GET["event"] : "";

// Switch case để xử lý các yêu cầu từ client dựa trên giá trị của biến "event"
switch ($event) {
    case "get_users":
        $sql = "SELECT `ma_so`, `ho_nguoi_dung`, `ten_nguoi_dung`, `email`, `so_dien_thoai`, `dia_chi`, `gioi_tinh`, `ngay_sinh`, `ngay_tao`, `ma_quyen` FROM `nguoi_dung`";
        $result = $conn->query($sql);

        $users = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $user = array(
                    "ma_so" => $row["ma_so"],
                    "ho_nguoi_dung" => $row["ho_nguoi_dung"],
                    "ten_nguoi_dung" => $row["ten_nguoi_dung"],
                    "email" => $row["email"],
                    "so_dien_thoai" => $row["so_dien_thoai"],
                    "dia_chi" => $row["dia_chi"],
                    "gioi_tinh" => $row["gioi_tinh"],
                    "ngay_sinh" => $row["ngay_sinh"],
                    "ngay_tao" => $row["ngay_tao"],
                    "ma_quyen" => $row["ma_quyen"]
                );
                array_push($users, $user);
            }
        }

        // Trả về dữ liệu "thể loại" dưới dạng JSON
        header('Content-Type: application/json');
        echo json_encode($users);
        break;

    case "updatekhachhang":
        $makh = isset($_GET['makh']) ? $_GET['makh'] : '';
        $tenkh = isset($_GET['tenkh']) ? $_GET['tenkh'] : '';
        $gt = isset($_GET['gt']) ? $_GET['gt'] : '';
        $cccd = isset($_GET['cccd']) ? $_GET['cccd'] : '';
        $sdt = isset($_GET['sdt']) ? $_GET['sdt'] : '';

        if (!empty($makh) && !empty($tenkh) && !empty($gt) && !empty($cccd) && !empty($sdt)) {
            $sql = "UPDATE `khachhang` SET `tenkh`=?, `gt`=?, `cccd`=?, `sdt`=? WHERE `makh`=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $tenkh, $gt, $cccd, $sdt, $makh);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $res["success"] = 1; // {"success":1}
                } else {
                    $res["success"] = 0; // {"success":0}
                }
            } else {
                $res["success"] = 0; // {"success":0}
            }

            $stmt->close();
        } else {
            $res["success"] = 0; // {"success":0}
        }

        echo json_encode($res);
        break;

    default:
        echo "Yêu cầu không hợp lệ";
}

$conn->close();
?>
