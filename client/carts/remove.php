<?php
    include "../DBUntil.php";
    $dbHelper = new DBUntil();
    if (isset($_GET['idCart'])) {
        $idCart = $_GET['idCart'];

        // $dbHelper->delete("carts", "idCart = $idCart");
        // $dbHelper->delete("detailcart")
        header('Location: ../cart.php');
    }
?>