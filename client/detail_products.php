<?php
    include "./DBUntil.php";
    $dbHelper = new DBUntil();
    $id = $_GET['id'];
    $results = $dbHelper->select("SELECT p.idProduct, p.nameProduct, p.description, p.price, pcs.color, sz.nameSize 
        FROM products p 
        JOIN product_size_color pcs ON p.idProduct = pcs.idProduct
        JOIN sizes sz ON sz.idSize = pcs.idSize WHERE p.idProduct = $id");
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

<?php include "./includes/head.php" ?>

<body>
    <?php include "./includes/header.php" ?>
    <!-- banner -->
    <div class="container mt-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html" class="nav-link">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sản
                    phẩm</li>
            </ol>
        </nav>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-md-5 me-2">
                <div class="image_product">
                    <img src="./image/product_demo.webp" alt="image" class="w-100">
                </div>
            </div>
            <div class="col-md-5 ms-3">
                <div class="product_content">
                    <?php foreach ($products as $product_id => $product): ?>
                    <form action method="post">
                        <h3 class="fw-bold fs-5 my-1"><?php echo $product['nameProduct']; ?></h3>
                        <p class="product_id my-1">MÃ SP: 123ASGH</p>
                        <p class="fw-bold mt-3 mb-4"><?php echo $product['price']; ?>đ</p>
                        <div class="product_color">
                            <label for class="d-block fs-6 mb-2 fw-bold">Màu sắc:</label>
                            <div class="button-group" id="color-group-<?php echo $product_id; ?>">
                                <?php 
                                    $colors = array_unique(array_column($product['variants'], 'color'));
                                    foreach ($colors as $color): ?>
                                <button type="button" class="btn"
                                    onclick="selectColor('<?php echo $product_id; ?>', '<?php echo $color; ?>')"><?php echo $color; ?></button>
                                <?php endforeach; ?>
                            </div>
                            <input type="hidden" name="color" id="color-<?php echo $product_id; ?>" required>
                        </div>
                        <!-- size  -->
                        <div class="product_size mt-3">
                            <label for class="d-block fs-6 mb-2 fw-bold">Kích
                                thước:</label>
                            <div class="button-group" id="size-group-<?php echo $product_id; ?>">
                                <?php 
                                    $sizes = array_unique(array_column($product['variants'], 'size'));
                                    foreach ($sizes as $size): ?>
                                <button type="button" class="btn rouded-1"
                                    onclick="selectSize('<?php echo $product_id; ?>', '<?php echo $size; ?>')"><?php echo $size; ?></button>
                                <?php endforeach; ?>
                            </div>
                            <input type="hidden" name="size" id="size-<?php echo $product_id; ?>" required>
                        </div>
                        <div class="choose_size mt-4">
                            <p class="choose_size--text my-1">
                                <i class="fa-solid fa-table class color-main"></i>
                                Hướng dẫn chọn size
                            </p>
                        </div>
                        <div class="image_freeship">
                            <img src="https://owen.cdn.vccloud.vn/media/amasty/ampromobanners/CD06C467-DE0F-457E-9AB0-9D90B567E118.jpeg"
                                alt class="w-100">
                        </div>
                        <button type="submit" class="btn btn-dark w-100 mt-5 fw-bold rounded-0">MUA HÀNG</button>
                        <?php endforeach; ?>
                    </form>

                    <div class="description mt-5">
                        <span class="description_heading fw-bold">MÔ TẢ</span>
                        <hr class="m-0">
                        <p>Lorem ipsum dolor sit amet consectetur,
                            adipisicing elit. Ea cumque maiores similique fu</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-1"></div>
        </div>
    </div>
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
    <?php include "./includes/footer.php" ?>