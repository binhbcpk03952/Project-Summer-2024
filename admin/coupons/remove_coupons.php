<?php
include "../../client/DBUntil.php";
$dbHelper = new DBUntil();
$id = $_GET['id'];
var_dump($id);
$users = $dbHelper->delete("coupons", "idCoupon = $id");
header("Location: list.php");   