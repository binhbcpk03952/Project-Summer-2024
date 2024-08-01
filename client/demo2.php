<?php
include_once ("./DBUntil.php");
$dbHelper = new DBUntil();
    // $id = $_GET['id'];
    $results = $dbHelper->select("SELECT p.idProduct, p.nameProduct, p.description, p.price, pcs.color, sz.nameSize
        FROM products p 
        JOIN product_size_color pcs ON p.idProduct = pcs.idProduct
        JOIN sizes sz ON sz.idSize = pcs.idSize
        WHERE p.idProduct = 4");

    $images = $dbHelper->select("SELECT * FROM picproduct WHERE idProduct = ?", [4]);
    $products = [];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $product_id = $id;
        $color = $_POST['color'];
        $size = $_POST['size'];
        if (!isset($color) || empty($color)) {
            $errors['color'] = "Đây là trường bắt buộc";
        }
    
        echo $product_id. "<br>";
        echo $color. "<br>";
        echo $size. "<br>";
    }

    foreach ($results as $row) {
        $product_id = $row['idProduct'];
        if (!isset($products[$product_id])) {
            $products[$product_id] = [
                'nameProduct' => $row['nameProduct'],
                'description' => $row['description'],
                'price' => $row['price'],
                'variants' => []
            ];
        }
        $products[$product_id]['variants'][] = [
            'color' => $row['color'],
            'size' => $row['nameSize']
        ];
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chọn màu sắc</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <?php
        // Giả sử bạn có một danh sách sản phẩm $products
        foreach ($products as $product):
            $product_id = 4;
    ?>
    <div class="product">
        <h2><?php echo $product['nameProduct']; ?></h2>
        <div class="button-group" id="color-group-<?php echo $product_id; ?>">
            <?php
                // Lọc màu trùng lặp
                $colors = array_unique(array_column($product['variants'], 'color'));
                foreach ($colors as $color):
            ?>
            <button type="button" class="btn" style="background-color: <?php echo $color; ?>;"
                onclick="selectColor('<?php echo $product_id; ?>', '<?php echo $color; ?>', event)"></button>
            <?php endforeach; ?>
        </div>
        <input type="hidden" name="color" id="color-<?php echo $product_id; ?>" required>
        <div id="sizes-<?php echo $product_id; ?>"></div> <!-- Thêm phần tử để hiển thị kích thước -->
    </div>
    <?php endforeach; ?>

    <script>
        function selectColor(productId, color, event) {
            // Đặt giá trị của input ẩn thành màu đã chọn
            document.getElementById('color-' + productId).value = color;

            // Gửi yêu cầu AJAX đến process_color.php để lấy kích thước
            $.ajax({
                url: 'demo.php',
                method: 'GET',
                data: {
                    color: color
                },
                success: function(response) {
                    // Hiển thị kết quả trong phần tử kích thước tương ứng
                    document.getElementById('sizes-' + productId).innerHTML = response;
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                }
            });
        }
    </script>
</body>
</html>
