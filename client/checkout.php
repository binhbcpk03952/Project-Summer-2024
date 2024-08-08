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

$carts = $dbHelper->select("SELECT dca.*, MIN(pic.namePic) AS namePic, pr.*, psc.*, us.*, dca.color
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
$address = $dbHelper->select("SELECT * FROM address WHERE idUser = ?", [$idUser]);
// echo $address[0]['nameStreet'];
// var_dump($address);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['addressOrder']) || empty($_POST['addressOrder'])) {
        $errors['addressOrder'] = "Đây là trường bắt buộc";
    } else {
        $addressOrder = $_POST['addressOrder'];
    }
    if (!isset($_POST['payment_method']) || empty($_POST['payment_method'])) {
        $errors['payment_method'] = "Đây là trường bắt buộc";
    } else {
        $payment_method = $_POST['payment_method'];
    }

    $noteOrder = $_POST['noteOrder'];

    if (count($errors) === 0) {
        echo "validate thanh cong";
        // chuaan bi du lieu de them du lieu vao database
        $currentDateTime = getdate();
        $mysqlDateTime = date("Y-m-d H:i:s", mktime(
            $currentDateTime['hours'] + 5,
            $currentDateTime['minutes'],
            $currentDateTime['seconds'],
            $currentDateTime['mon'],
            $currentDateTime['mday'],
            $currentDateTime['year']
        ));
        echo $mysqlDateTime;

        $isIdCart = $dbHelper->select("SELECT * FROM carts WHERE idUser = ?", [$_SESSION['id']]);
        $checkCarts = $isIdCart[0]['idCart'];
        $detailCart = $dbHelper->select("SELECT * FROM detailcart WHERE idCart = ?", [$checkCarts]);
        // var_dump($detailCart);
        $formatted_address = $address[0]['nameStreet'] . ', ' . $address[0]['nameAddress'];
        $dataInsertOrder = [
            "orderDate" => $mysqlDateTime,
            "statusOrder" => 1,
            "address" => $formatted_address,
            "noteOrder" => $noteOrder,
            "totalPrice" => getTotal() + 30000,
            "idUser" => $_SESSION['id'],
        ];

        $insertOrder = $dbHelper->insert("orders", $dataInsertOrder);
        $idOrder = $dbHelper->lastInsertId();
        // echo '<pre>';
        // var_dump($dataInsertOrder);
        // echo '</pre>';
        foreach ($detailCart as $row) {
            $data = [
                "quantityOrder" => $row['quantityCart'],
                "size" => $row['size'],
                "color" => $row['color'],
                "idProduct" => $row['idProduct'],
                "idOrder" => $idOrder,
            ];
            $insertDetailOrder = $dbHelper->insert("detailorder", $data);
        }

        if ($insertOrder && $insertDetailOrder) {
            echo '<script>alert("mua hang thanh cong!")</script>';

            $removeCart = $dbHelper->delete("detailcart", "idCart = $checkCarts");
            header("Location: shop.php");
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<?php include "./includes/head.php" ?>
<body>
    <?php include "./includes/header.php" ?>
    <!-- banner -->
    <div class="container mt-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html" class="nav-link">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
            </ol>
        </nav>
    </div>
    <section id="checkout">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-checkout">
                        <h1 class="fs-2">THANH TOÁN</h1>
                        <form action="" method="post">
                            <div class="address-delivery">
                                <p class="fw-bold mb-2">1. Địa chỉ nhận hàng</p>
                                <div class="detail-address px-2">
                                    <?php if (!$address) { ?>
                                        <a href="add_address.php?id=<?php echo $_SESSION['id'] ?>" class="add_to--address nav-link d-flex align-item-center ms-2">
                                            <i class="fa-solid fa-plus fs-3"></i>
                                            <label for="" class="ms-3">Thêm thông tin nhận hàng</label>
                                        </a>
                                    <?php } else { ?>
                                        <div class="address-content">
                                            <p class="m-0">
                                                <span class="fw-bold"><?php echo $checkCart[0]['name'] ?></span> |
                                                <span class="phone-number text-secondary"><?php echo $address[0]['phone'] ?></span>
                                            </p>
                                            <p class="vilage-streetName m-0 text-secondary"><?php echo $address[0]['nameStreet'] ?></p>
                                            <p class="provine-district m-0 text-secondary"><?php echo $address[0]['nameAddress'] ?></p>

                                            <?php if ($address) { ?>
                                                <input type="hidden" name="addressOrder" id="addressOrder" value="<?php echo $address[0]['idAddress'] ?>">
                                            <?php } else { ?>
                                                <input type="hidden" name="addressOrder" id="addressOrder" value="">
                                            <?php } ?>
                                            <?php
                                            if (isset($errors['addressOrder'])) {
                                                echo "<span class='errors text-danger'>{$errors['addressOrder']}</span>";
                                            }
                                            ?>
                                        </div>
                                    <?php } ?>
                                    <div class="noteOrder mt-3">
                                        <label for="note">Ghi chú</label>
                                        <textarea name="noteOrder" id="note" class="w-100 value-forgot"></textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="delivery-price">
                                <p class="fw-bold mb-2">2. Vận chuyển</p>
                                <div class="d-flex justify-content-between px-2">
                                    <div class="input-checked">
                                        <label for="" class="fs-6">GHN-Tiêu chuẩn</label>
                                    </div>
                                    <p class="price delivery">+30.000đ</p>
                                </div>
                            </div>
                            <hr>
                            <div class="payment">
                                <p class="fw-bold mb-2">3. Phương thức thanh toán</p>
                                <div class="payment-method px-2">
                                    <div class="pay">
                                        <input type="radio" name="payment_method" id="" value="1">
                                        <label for="" class="fs-6 mx-2">Thanh toán khi nhận hàng</label>
                                    </div>
                                    <div class="vnPay mt-1">
                                        <input type="radio" name="payment_method" id="" value="2">
                                        <label for="" class="fs-6 mx-2">Thanh toán VNPAY</label>
                                    </div>
                                    <?php
                                        if (isset($errors['payment_method'])) {
                                            echo "<span class='errors text-danger'>{$errors['payment_method']}</span>";
                                        }
                                    ?>
                                </div>

                            </div>
                            <hr>
                            <div class="coupon">
                                <p class="fw-bold mb-2">4. Áp dụng mã giảm giá</p>
                                <div class="coupon-input px-2">
                                        <?php
                                            
                                        ?>
                                    <input type="search" name="coupon" id="coupon" placeholder="Nhập mã giảm giá">
                                    <button type="button">
                                        Sử dụng
                                    </button>
                                </div>
                            </div>
                            <div class="px-2">
                                <button type="submit" class="btn-toCheckout w-100 mt-3 px-2 fw-bold">ĐẶT HÀNG</button>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="position-sticky">
                        <h2 class="fs-5 color-main">THÔNG TIN ĐƠN HÀNG</h2>
                        <table class="table table-cart">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Giá</th>
                                    <th>Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($carts as $cart) : ?>
                                    <tr>
                                        <td>
                                            <div class="cart-products d-flex align-items-center">
                                                <div class="image-products">
                                                    <img src="../admin/products/image/<?php echo $cart['namePic'] ?>" alt="" class="w-100">
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
                                            <span><?php echo $cart['quantityCart'] ?></span>
                                        </td>
                                        <td>
                                            <span class="price">
                                                <?php echo $cart['price'] ?>
                                                <span class="fw-bold fs-7 text-decoration-underline">đ</span>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="total-price" id="totalPrice-<?php echo $cart['idDetailCart'] ?>">
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
                                    <p class="fw-bold ">Tổng tiền:</p>
                                    <p class="fw-bold ">Vận chuyển:</p>
                                </div>
                                <div class="end-items text-end">
                                    <p class="quantity-products"><?php echo count($carts) ?></p>
                                    <p class="total-quantityInCart">
                                        <?php echo getTotal() ?>
                                        <span class="fw-bold fs-7 text-decoration-underline">đ</span>
                                    </p>
                                    <p class="price-delivery">
                                        30.000
                                        <span class="fw-bold fs-7 text-decoration-underline">đ</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="total d-flex justify-content-between p-2">
                            <span class="fw-bold color-main">THÀNH TIỀN</span>
                            <span class="total-price">
                                <?php echo getTotal() + 30000 ?>
                                <span class="fw-bold fs-7 text-decoration-underline">đ</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- footer -->
    <?php include "./includes/footer.php" ?>
</body>

</html>