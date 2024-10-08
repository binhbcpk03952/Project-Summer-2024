<?php
session_start();
include "./DBUntil.php";
$dbHelper = new DBUntil();

$idUser = $_SESSION['id'];

// Fetch order IDs for the user
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
$products = [];
foreach ($idProducts as $productId) {
    $product = $dbHelper->select("SELECT nameProduct FROM products WHERE idProduct = ?", [$productId]);
    if (!empty($product)) {
        $products[] = $product[0]['nameProduct'];
    }
}

// Return the product names as JSON
echo json_encode($products);
?>
