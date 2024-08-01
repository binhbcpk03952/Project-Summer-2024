<?php
    include_once ("./DBUntil.php");
    $dbHelper = new DBUntil();

    if (isset($_GET['color'])) {
        $selectedColor = $_GET['color'];

        // Tạo đối tượng Database
        $dbHelper = new DBUntil;

        // Truy vấn SQL để lấy danh sách kích thước dựa trên màu đã chọn
        $sql = "SELECT p.idProduct, p.nameProduct, p.description, p.price, pcs.color, sz.nameSize 
                FROM products p 
                JOIN product_size_color pcs ON p.idProduct = pcs.idProduct
                JOIN sizes sz ON sz.idSize = pcs.idSize
                WHERE pcs.color = :color";

        $params = ['color' => $selectedColor];
        $results = $dbHelper->select($sql, $params);

        $uniqueSizes = [];

        // Hiển thị kết quả
        if (!empty($results)) {
            foreach ($results as $row) {
                if (!in_array($row['nameSize'], $uniqueSizes)) {
                    $uniqueSizes[] = $row['nameSize'];
                }
            }
            
            // Trả về các nút kích thước có thể click
            foreach ($uniqueSizes as $size) {
                echo "<button type='button' class='btn' onclick='selectSize(\"$size\")'>$size</button> ";
            }
        } else {
            echo "Không có kết quả nào.";
        }
    }
?>
