<?php
require_once("config.php");

$sql = "SELECT ct.`ma_san_pham`, sp.hinh_anh, sp.ten_san_pham, sp.ma_the_loai, dh.ngay_tao, ct.`gia`, ct.`so_luong` 
        FROM `chi_tiet_don_hang` ct
        LEFT JOIN don_hang dh ON dh.ma_so = ct.ma_don_hang
        LEFT JOIN san_pham sp ON sp.ma_so = ct.ma_san_pham
        WHERE 1";
        $result = $conn->query($sql);

        $ctdonhangs = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ctdonhang = array(
                    "ma_san_pham" => $row["ma_san_pham"],
                    "hinh_anh" => $row["hinh_anh"],
                    "ten_san_pham" => $row["ten_san_pham"],
                    "ma_the_loai" => $row["ma_the_loai"],
                    "ngay_tao" => $row["ngay_tao"],
                    "so_luong" => $row["so_luong"],
                    "gia" => $row["gia"]
  
                );
                array_push($ctdonhangs, $ctdonhang);
            }
        }

        // Trả về dữ liệu "thể loại" dưới dạng JSON
        header('Content-Type: application/json');
        echo json_encode($ctdonhangs);

$conn->close();
?>