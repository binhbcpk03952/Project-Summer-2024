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

            <aside class="col-md-2 d-block">
                <div class="aside-content show-aside bg-dark pt-5">
                    <ul class="nav-aside p-0 mx-4 mt-5">
                        <li class="nav-link">
                            <a href="index.php" class="text-white text-decoration-none">
                                <i class="fa-solid fa-layer-group mx-2"></i>
                                Tổng hợp
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="index.php?view=category_list" class="text-white text-decoration-none">
                                <i class="fa-brands fa-docker mx-2"></i>
                                Danh mục
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="index.php?view=user_list" class="text-white text-decoration-none">
                                <i class="fa-solid fa-user mx-2"></i>
                                Người dùng
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="index.php?view=product_list" class="text-white text-decoration-none">
                                <i class="fa-solid fa-shirt mx-2"></i>
                                Sản phẩm
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="index.php?view=order_list" class="text-white text-decoration-none">
                                <i class="fa-regular fa-calendar-check mx-2"></i>
                                Đơn hàng
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>
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
                        include_once('./users/remove_users.php');
                        break;
                    case 'user_update':
                        include_once('./users/update_users.php');
                        break;
                    case 'user_created':
                        include_once('./users/add.php');
                        break;
                        // danh mục 
                    case 'category_list':
                        include_once('./categories/list.php');
                        break;
                    case 'category_delete':
                        include_once('./categories/remove.php');
                        break;
                    case 'category_update':
                        include_once('./categories/update.php');
                        break;
                    case 'category_created':
                        include_once('./categories/add.php');
                        break;

                        //danh mục con
                    case 'subCategory_list':
                        include_once('./sub_categories/list.php');
                        break;
                    case 'subCategory_delete':
                        include_once('./sub_categories/remove.php');
                        break;
                    case 'subCategory_update':
                        include_once('./sub_categories/update.php');
                        break;
                    case 'subCategory_created':
                        include_once('./sub_categories/add.php');
                        break;

                        // sản phẩm
                    case 'product_list':
                        include_once('./products/list.php');
                        break;
                    case 'product_delete':
                        include_once('./products/remove.php');
                        break;
                    case 'product_update':
                        include_once('./products/update.php');
                        break;
                    case 'product_list-color':
                        include_once('./products/list_color.php');
                        break;
                    case 'product_list-image':
                        include_once('./products/list_image.php');
                        break;
                    case 'product_update-color':
                        include_once('./products/update-color.php');
                        break;
                    case 'product_update-image':
                        include_once('./products/update-image.php');
                        break;
                    case 'product_created':
                        include_once('./products/add.php');
                        break;
                    case 'product_created-color':
                        include_once('./products/add_color_size.php');
                        break;
                    case 'product_created-image':
                        include_once('./products/add_pic.php');
                        break;
                        // gio hang
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