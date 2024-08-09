<?php
session_start();
include "../client/DBUntil.php";
$dbHelper = new DBUntil();
include "./include/role.php";
?>

<!DOCTYPE html>
<html lang="en">

<?php include "./include/head.php" ?>
<link rel="stylesheet" href="./css/style.css">

<body>
    
<?php include "./include/header.php" ?>
    <div class="container-fluid">
        <div class="row">
        <?php include "./include/aside.php" ?>
            <main class="col-md-10 mt-5">
                <button class="btn" onclick="alertRemove('danh mục')">Check</button>
            </main>

        </div>
    </div>

    <script src="https://kit.fontawesome.com/121f50087c.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
    <!-- <script src="js/script.js"></script> -->
    <script src="js/main.js"></script>
</body>

</html>