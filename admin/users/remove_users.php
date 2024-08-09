<?php
// include "../../client/DBUntil.php";
// $dbHelper = new DBUntil();
include "./include/role.php";
$id = $_GET['id'];
var_dump($id);
$users = $dbHelper->delete("users", "idUser = $id");
header("Location: index.php?view=user_list");   