<?php
// include_once ('../../client/DBUntil.php');
$id = $_GET['id'];
var_dump($id);


$dbHelper = new DBUntil();

$categories = $dbHelper->delete("subcategories", "idSubCategory = $id");
header("Location:  index.php?view=subCategory_list");