<?php
include "./DBUntil.php";
$dbHelper = new DBUntil;

// Truy vấn dữ liệu từ cơ sở dữ liệu
$results = $dbHelper->select("SELECT p.idProduct, p.nameProduct, p.description, p.price, pcs.color, sz.nameSize 
        FROM products p 
        JOIN product_size_color pcs ON p.idProduct = pcs.idProduct
        JOIN sizes sz ON sz.idSize = pcs.idSize");



$products = [];
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $color = $_POST['color'];
    $size = $_POST['size'];
    if (!isset($color) || empty($color)) {
        $errors['color'] = "Đây là trường bắt buộc";
    }

    echo $product_id;
    echo $color;
    echo $size;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Product List</title>
    <style>
    .button-group {
        display: flex;
        flex-wrap: wrap;
    }

    .button-group button {
        margin: 5px;
        padding: 10px;
        border: 1px solid #ccc;
        background-color: #f9f9f9;
        cursor: pointer;
    }

    .button-group button.active {
        background-color: #007bff;
        color: white;
    }
    </style>
</head>

<body>
    <?php foreach ($products as $product_id => $product): ?>
    <div class="product">
        <h2><?php echo $product['nameProduct']; ?></h2>
        <p><?php echo $product['description']; ?></p>
        <p>Price: $<?php echo $product['price']; ?></p>
        <form action="demo2.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <label for="color">Color:</label>
            <div class="button-group" id="color-group-<?php echo $product_id; ?>">
                <?php 
                    $colors = array_unique(array_column($product['variants'], 'color'));
                    foreach ($colors as $color): ?>
                <button type="button"
                    onclick="selectColor('<?php echo $product_id; ?>', '<?php echo $color; ?>')"><?php echo $color; ?></button>
                <?php endforeach; ?>
            </div>
            <input type="hidden" name="color" id="color-<?php echo $product_id; ?>" required>
            <?php
                if (isset($errors['color'])) {
                    echo "<span class='errors text-danger'>{$errors['color']}</span> <br>";
                }
            ?>
            <label for="size">Size:</label>
            <div class="button-group" id="size-group-<?php echo $product_id; ?>">
                <?php 
                    $sizes = array_unique(array_column($product['variants'], 'size'));
                    foreach ($sizes as $size): ?>
                <button type="button"
                    onclick="selectSize('<?php echo $product_id; ?>', '<?php echo $size; ?>')"><?php echo $size; ?></button>
                <?php endforeach; ?>
            </div>
            <input type="hidden" name="size" id="size-<?php echo $product_id; ?>" required>
            <button type="submit">Add to Cart</button>
        </form>
    </div>
    <?php endforeach; ?>

    <script>
    function selectColor(productId, color) {
        var colorGroup = document.getElementById('color-group-' + productId);
        var buttons = colorGroup.getElementsByTagName('button');
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].classList.remove('active');
        }
        event.target.classList.add('active');
        document.getElementById('color-' + productId).value = color;
    }

    function selectSize(productId, size) {
        var sizeGroup = document.getElementById('size-group-' + productId);
        var buttons = sizeGroup.getElementsByTagName('button');
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].classList.remove('active');
        }
        event.target.classList.add('active');
        document.getElementById('size-' + productId).value = size;
    }
    </script>
</body>

</html>