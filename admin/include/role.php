<?php
    if (isset($_SESSION['id'])) {
        $idUser = $_SESSION['id'];
        $roleUser = $dbHelper->select("SELECT * FROM users WHERE idUser = $idUser")[0];
    }
    // echo $_SERVER['HTTP_REFERER'];
    
    if ($roleUser['role'] !== "admin" || !isset($_SESSION['id'])) {
        if ($_SERVER['HTTP_REFERER']) {
            header("Location: ". $_SERVER['HTTP_REFERER']);
        } else {
            header("Location: http://localhost/project-summer-2024/client/index.php");
        }
    }
?>