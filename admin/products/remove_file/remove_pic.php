<?php
include_once ('../../../client/DBUntil.php');
$id = $_GET['id'];
$idPrd = $_GET['idPrd'];
var_dump($id);


$dbHelper = new DBUntil();

$categories = $dbHelper->delete("picproduct", "idPic = $id");
header("Location: ../../../../../../project-summer-2024/admin/products/list_image.php?id=$idPrd");