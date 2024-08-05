<?php
session_start();
if (isset($_SESSION['id'])) {
    $idUser = $_SESSION['id'];
}
header('Content-Type: application/json');
include "../DBUntil.php";
$dbHelper = new DBUntil();

if (isset($_GET['quantity']) && isset($_GET['productId']) && isset($_GET['idCart'])) {
    $quantity = $_GET['quantity'];
    $productId = $_GET['productId'];
    $idCart = $_GET['idCart'];

    $updateQuantity = $dbHelper->update("detailcart", ["quantityCart" => $quantity], "idDetailCart = $idCart");

    $product = $dbHelper->select("SELECT * FROM products WHERE idProduct = ?", [$productId]);

    
    $carts = $dbHelper->select("SELECT *
                                FROM carts ca 
                                INNER JOIN detailcart dca ON ca.idCart = dca.idCart
                                INNER JOIN products pr ON pr.idProduct = dca.idProduct
                                INNER JOIN users us ON us.idUser = ca.idUser
                                WHERE us.idUser = $idUser");
    function getTotal()
    {
        global $carts;
        $sum = 0;
        foreach ($carts as $cart) {
            $sum += $cart['price'] * $cart['quantityCart'];
        }
        return $sum;
    }

    if ($product) {
        $price = $product[0]['price'];
        $newPrice = $price * $quantity;
    // cập nhật giá mới
        echo json_encode(['status' => 'success', 'newPrice' => $newPrice, 'newTotal' => getTotal()]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Sản phẩm không tồn tại']);
    }       
} else {
    echo json_encode(['status' => 'error', 'message' => 'Đầu vào không hợp lệ']);
}
?>
