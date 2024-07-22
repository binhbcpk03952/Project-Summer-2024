<?php
    include "./DBUntil.php";
    $dbHelper = new DBUntil();

    $products = $dbHelper->select("SELECT p.*, MIN(pic.namePic) AS namePic 
    FROM products p
    JOIN picproduct pic ON p.idProduct = pic.idProduct
    GROUP BY p.idProduct
    ORDER BY p.idProduct");
    // var_dump($product);
?>

<?php include "./includes/head.php" ?>
<body>
    <?php include "./includes/header.php" ?>
    <!-- banner -->
    <div class="container mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html" class="nav-link">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh
                    mục</li>
            </ol>
        </nav>
        <div class="row banner">
            <img src="https://owen.vn/media/catalog/category/4546_x_1000_ao_1.jpg" alt>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <?php include "./includes/aside.php" ?>
            <main class="col-md-10">
                <div class="container">
                    <div class="row">
                    <?php foreach ($products as $product) { ?>
                        <div class="col-md-4 mt-5">
                            <div class="products-item">
                                <div class="image-product">
                                    <a href="detail_products.php?id=<?php echo $product['idProduct'] ?>" class="image-product-links">
                                        <img src="../admin/products/image/<?php echo $product['namePic'] ?>"
                                            alt class>
                                    </a>
                                    <a href="#" class="text-center text-decoration-none py-2 btn_add--checkout px-2">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                        Thêm vào giỏ hàng
                                    </a>
                                </div>
                                <div class="info_product mt-3">
                                    <a href="detailProduct.php?id=<?php echo $product['idProduct'] ?>" class="text-secondary fw-bold
                                         text-decoration-none">
                                         <?php echo $product['nameProduct'] ?>
                                    </a>
                                </div>
                                <div class="price-product fw-bold">
                                    <?php echo $product['price'] ?>đ
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    </div>
                </div>
            </main>
        </div>
    </div>
<?php include "./includes/footer.php" ?>