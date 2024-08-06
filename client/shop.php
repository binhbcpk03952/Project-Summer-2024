<?php
session_start();
include "./DBUntil.php";
$dbHelper = new DBUntil();
$login_success = false;

if (isset($_SESSION['success']) && $_SESSION['success'] === true) {
    $login_success = true;
    unset($_SESSION['success']); // Unset the session variable to avoid repeated alerts
}

$products = $dbHelper->select("SELECT p.*, MIN(pic.namePic) AS namePic 
    FROM products p
    JOIN picproduct pic ON p.idProduct = pic.idProduct
    GROUP BY p.idProduct
    ORDER BY p.idProduct");
?>

<?php include "./includes/head.php"; ?>

<!-- Tải jQuery trước mã JavaScript của bạn -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="./js/ajax.js"></script> 
<script src="./js/script.js"></script>

<body>

<div id="alerts-container"></div> <!-- Container cho thông báo -->

<script>
function alertSuccessfully(content) {
    let container = document.getElementById('alerts-container');
    let alertHtml = `
        <div class="container-fluid position_alert" id="alertSuccessfully">
            <div class="bg-alert d-flex justify-content-center align-items-center w-100">
                <div class="content_alert alert_cart">
                    <div class="icon-warning d-flex justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-circle-check-big icon_cart mt-3"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 
                            11 3 3L22 4"/></svg>
                    </div>
                    <h3 class="text-center fs-6 mt-3">${content} Thành công!</h3>
                </div>
            </div>
        </div>
    `;
    container.innerHTML += alertHtml;
    setTimeout(() => {
        let alertElement = document.getElementById('alertSuccessfully');
        if (alertElement) {
            alertElement.remove();
        }
    }, 2000);
}

<?php if ($login_success): ?>
    alertSuccessfully("Đăng nhập Thành Công!");
<?php endif; ?>
</script>
    <?php include "./includes/header.php" ?>
    <div class="container mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html" class="nav-link">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh mục</li>
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
                                        <img src="../admin/products/image/<?php echo $product['namePic'] ?>" alt>
                                    </a>
                                    <button type="button" class="product-button border-0 add_cart_btn text-center text-decoration-none py-2 btn_add--checkout px-2"
                                            data-product-id="<?php echo $product['idProduct'] ?>">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                        Thêm vào giỏ hàng
                                    </button>
                                </div>
                                <div class="info_product mt-3">
                                    <a href="detail_products.php?id=<?php echo $product['idProduct'] ?>" class="text-secondary fw-bold text-decoration-none">
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
    <div class="container-fluid position_alert" id="box_cart"></div>
    <div class="container-fluid position_alert" id="alerts-container"></div> <!-- Thêm container cho các alert -->
    <?php include "./includes/footer.php" ?>
</body>
</html>
