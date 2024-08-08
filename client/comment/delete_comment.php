<?php
include "../DBUntil.php";
$dbHelper = new DBUntil();
$idProduct = $_GET['id'];
var_dump($id);
$users = $dbHelper->delete("coment", "idProduct = $idProduct");
header("Location: ../../../project-summer-2024/client/detail_products.php?id=$idProduct");
 