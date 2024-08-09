<?php
// include_once ('../../client/DBUntil.php');
$id = $_GET['id'];
var_dump($id);
include "./include/role.php";


$dbHelper = new DBUntil();

$categories = $dbHelper->delete("categories", "idCategories = $id");
header("Location:  index.php?view=category_list");