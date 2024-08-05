<?php
include "../DBUntil.php";
$dbHelper = new DBUntil();
$idComment = $_GET['id'];
var_dump($id);
$users = $dbHelper->delete("coment", "idComment = $idComment");
header("Location: cmt.php");   