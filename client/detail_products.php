<?php
    include "./DBUntil.php";
    $dbHelper = new DBUntil();
    $id = $_GET['id'];
    $results = $dbHelper->select("SELECT p.idProduct, p.nameProduct, p.description, p.price, pcs.color, sz.nameSize
        FROM products p 
        JOIN product_size_color pcs ON p.idProduct = pcs.idProduct
        JOIN sizes sz ON sz.idSize = pcs.idSize
        WHERE p.idProduct = $id");

    $images = $dbHelper->select("SELECT * FROM picproduct WHERE idProduct = ?", [$id]);
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
        $product_id = $id;
        
       
        if (!isset($_POST['color']) || empty($_POST['color'])) {
            $errors['color'] = "Đây là trường bắt buộc";
        }
        else {
            $color = $_POST['color'];
        }
        if (!isset($_POST['size']) || empty($_POST['size'])) {
            $errors['size'] = "Đây là trường bắt buộc";
        }
        else {
            $size = $_POST['size'];
        }    
        echo $product_id. "<br>";
        echo $color. "<br>";
        echo $size. "<br>";
    }
    
?>

<?php include "./includes/head.php" ?>

<body class="">
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
                    <div class="show_image">
                        <!-- This div can be used to display the selected image or the main image -->
                        <img src="../admin/products/image/<?php echo htmlspecialchars($images[0]['namePic']); ?>">
                    </div>
                    <div class="image_thumbnail d-flex mt-2">
                        <?php foreach ($images as $image): ?>
                        <div class="thumbnails me-2">
                            <img src="../admin/products/image/<?php echo htmlspecialchars($image['namePic']); ?>"
                                alt="image" class="img-thumbnails">
                        </div>
                        <?php endforeach; ?>
                    </div>
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
                                <button type="button" class="btn" style="background-color: <?php echo $color; ?>;"
                                    onclick="selectColor('<?php echo $product_id; ?>', '<?php echo $color; ?>', event)"></button>
                                <?php endforeach; ?>
                            </div>
                            <input type="hidden" name="color" id="color-<?php echo $product_id; ?>" required>
                            <?php
                                if (isset($errors['color'])) {
                                    echo "<span class='errors text-danger'>{$errors['color']}</span>";
                                }
                            ?>
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
                                    onclick="selectSize('<?php echo $product_id; ?>', '<?php echo $size; ?>', event)"><?php echo $size; ?></button>
                                <?php endforeach; ?>
                            </div>
                            <input type="hidden" name="size" id="size-<?php echo $product_id; ?>" required>
                            <?php
                                if (isset($errors['size'])) {
                                    echo "<span class='errors text-danger'>{$errors['size']}</span>";
                                }
                            ?>
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
        // JavaScript to handle the click event on the thumbnails
        document.addEventListener('DOMContentLoaded', function() {
            const thumbnails = document.querySelectorAll('.image_thumbnail img');
            const showImage = document.querySelector('.show_image');
            
            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', function() {
                    // Remove active class from all thumbnails
                    thumbnails.forEach(thumb => thumb.classList.remove('active'));
                    
                    // Add active class to the clicked thumbnail
                    thumbnail.classList.add('active');
                    
                    // Set the clicked thumbnail image as the main image
                    showImage.innerHTML = `<img src="${thumbnail.src}" alt="main image">`;
                });
            });
        });
        </script>
        <script src="./js/script.js"></script>
    <?php include "./includes/footer.php" ?>