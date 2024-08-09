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
                <?php
                // include_once('../DBUtil.php');
                include_once('./Message.php');
                $view = isset($_GET['view']) ? $_GET['view'] : 'index';
                // var_dump($view);
                switch ($view) {
                    case 'user_list':
                        include_once('./users/list.php');
                        break;
                    case 'user_delete':
                        include_once('./User/delete.php');
                        break;
                    case 'user_update':
                        include_once('./User/edit.php');
                        break;
                    case 'user_created':
                        include_once('./User/created.php');
                        break;
                    case 'category_list':
                        include_once('./Categories/list.php');
                        break;
                    case 'category_delete':
                        include_once('./Categories/delete.php');
                        break;
                    case 'category_update':
                        include_once('./Categories/edit.php');
                        break;
                    case 'category_created':
                        include_once('./Categories/createdCat.php');
                        break;
                    case 'product_list':
                        include_once('./products/list.php');
                        break;
                    case 'product_delete':
                        include_once('./products/delete.php');
                        break;
                    case 'product_update':
                        include_once('./products/edit.php');
                        break;
                    case 'product_created':
                        include_once('./products/created-Prd.php');
                        break;
                    case 'order_list':
                        include_once('./order/order-admin.php');
                        break;
                    case 'update_order':
                        include_once('./order/update-order.php');
                        break;
                    case 'refuse_order':
                        include_once('./order/refuse.php');
                        break;
                    case 'general_list':
                        include_once('./order/general.php');
                        break;
                }
                ?>
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