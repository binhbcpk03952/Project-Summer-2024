<?php
    session_start();
    if (isset($_SESSION['id'])) {
        $idUser = $_SESSION['id'];
    }
    include "./DBUntil.php";
    $dbHelper = new DBUntil();
    $checkCart = $dbHelper->select("SELECT * FROM users us  
                                            JOIN carts ca ON ca.idUser = us.idUser
                                            WHERE ca.idUser = ?", [$_SESSION['id']]);
    $idCart = $checkCart[0]['idCart'];

    $carts = $dbHelper->select("SELECT dca.*, MIN(pic.namePic) AS namePic, pr.*, psc.*, us.*
                                FROM carts ca 
                                JOIN detailcart dca ON ca.idCart = dca.idCart
                                INNER JOIN products pr ON pr.idProduct = dca.idProduct
                                JOIN picProduct pic ON pic.idProduct = pr.idProduct
                                JOIN product_size_color psc ON psc.idProduct = pr.idProduct
                                INNER JOIN users us ON us.idUser = ca.idUser
                                WHERE us.idUser = ? AND dca.idCart = ?
                                GROUP BY dca.idDetailCart", [$idUser, $idCart]);
    function getTotal()
    {
        global $carts;
        $sum = 0;
        foreach ($carts as $cart) {
            $sum += $cart['price'] * $cart['quantityCart'];
        }
        return $sum;
    }
    // echo getTotal();
    var_dump($carts);
    // echo count($carts);
?>
<!DOCTYPE html>
<html lang="en">
<?php include "./includes/head.php" ?>
<link rel="stylesheet" href="./css/style.css">

<body>
    <?php include "./includes/header.php" ?>
    <!-- banner -->
    <div class="container mt-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html" class="nav-link">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
            </ol>
        </nav>
    </div>
    <section id="cart">
        <div class="container">
            <div class="row">
                <h1>Giỏ hàng</h1>
                <div class="col-md-9">
                    <table class="table table-cart">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th></th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Tổng tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($carts as $cart): ?>
                            <tr>
                                <td>
                                    <div class="cart-products d-flex align-items-center">
                                        <div class="image-products">
                                            <img src="../admin/products/image/<?php echo $cart['namePic'] ?>" alt=""
                                                class="w-100">
                                        </div>
                                        <div class="product-content mx-2">
                                            <a href="#" class="name-products text-secondary
                                                 fw-bold text-decoration-none"><?php echo $cart['nameProduct'] ?></a>
                                            <p class="product-color">Màu sắc: <?php echo $cart['color'] ?></p>
                                            <p class="product-size">Kích thước: <?php echo $cart['size'] ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="remove-cart d-flex align-items-center">
                                        <a href="./carts/remove.php?idCart=<?php echo $cart['idCart'] ?>" class="fw-bold text-decoration-none">Xóa</a>
                                    </div>
                                </td>
                                <td>
                                    <div class="quantity">
                                        <button class="prev" 
                                            onclick="updateQuantity(this, -1, <?php echo $cart['idProduct'] ?>, <?php echo $cart['quantityProduct'] ?>,<?php echo $cart['idCart'] ?>)">-</button>
                                        <input type="text" class="quantity-cart" name="quantity-cart"
                                            value="<?php echo $cart['quantityCart'] ?>">
                                        <button class="pluss" 
                                            onclick="updateQuantity(this, 1, <?php echo $cart['idProduct'] ?>, <?php echo $cart['quantityProduct'] ?>, <?php echo $cart['idCart'] ?>)">+</button>
                                    </div>
                                </td>
                                <td>
                                    <span class="price">
                                        <?php echo $cart['price'] ?>
                                        <span class="fw-bold fs-7 text-decoration-underline">đ</span>
                                    </span>
                                </td>
                                <td>
                                    <span class="total-price" id="totalPrice-<?php echo $cart['idCart'] ?>">
                                        <?php echo $cart['price'] * $cart['quantityCart'] ?>
                                    </span>
                                    <span class="fw-bold fs-7 text-decoration-underline">đ</span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                    <div class="d-flex justify-content-end">
                        <div class="general-cart d-flex justify-content-between ">
                            <div class="start-items">
                                <p class="fw-bold">Tổng sản phẩm:</p>
                                <p class="fw-bold color-main">TẠM TÍNH</p>
                            </div>
                            <div class="end-items text-end">
                                <p class="quantity-products"><?php echo count($carts); ?></p>
                                <p class="total-quantityInCart">
                                    <span id="total_price"><?php echo getTotal() ?></span>
                                    <span class="fw-bold fs-7 text-decoration-underline">đ</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-3 mb-4">
                        <div class="to-shop">
                            <a href="./shop.php"
                                class="text-decoration-none text-center toCheck py-2 px-4 text-dark fw-bold">
                                TIẾP TỤC MUA HÀNG
                            </a>
                        </div>
                        <div class="to-checkout">
                            <form action="" method="post">
                                <input type="hidden" name="totalPrice" id="">
                                <button
                                    class="toCheck text-decoration-none text-center py-2 px-5 bg-dark text-white fw-bold">ĐẶT
                                    HÀNG</button>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="img-cart">
                        <img src="./image/image-cart.jpg" alt="" class="w-100">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- footer -->
    <?php include "./includes/footer.php" ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./js/script.js"></script>
    <script>
    </script>
</body>

</html>