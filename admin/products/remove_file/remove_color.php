<?php
include_once ('../../../client/DBUntil.php');
$id = $_GET['id'];
$idPrd = $_GET['idPrd'];
var_dump($id);


$dbHelper = new DBUntil();

$categories = $dbHelper->delete("product_size_color", "idSizeColor = $id");
header("Location: ../../../../../../project-summer-2024/admin/products/list_color.php?id=$idPrd");