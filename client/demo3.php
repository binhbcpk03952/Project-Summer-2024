<?php
session_start();
include "./DBUntil.php";
$dbHelper = new DBUntil();

$idUser = $_SESSION['id'];

/**
 * Lấy id người dùng 
 * từ id người dùng lấy id sản phẩm người dùng đã mua 
 */
$idOrders = $dbHelper->select("SELECT idOrder FROM orders WHERE idUser = ?", [$idUser]);

// Initialize an array to store product IDs
$idProducts = [];

foreach ($idOrders as $order) {
    $detailOrders = $dbHelper->select("SELECT idProduct FROM detailorder WHERE idOrder = ?", [$order['idOrder']]);
    foreach ($detailOrders as $detail) {
        $idProducts[] = $detail['idProduct'];
    }
}

// Fetch product details
foreach ($idProducts as $productId) {
    $product = $dbHelper->select("SELECT * FROM products WHERE idProduct = ?", [$productId]);
    echo $product[0]['idProduct'] . " ";
    echo $product[0]['nameProduct'] . "<br>";
}
?>
