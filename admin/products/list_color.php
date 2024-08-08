<?php
include "../../client/DBUntil.php";
$dbHelper = new DBUntil();
$idProduct = $_GET['id'];
$listProducts = $dbHelper->select("SELECT PR.*, SC.*, sz.*,
                                        (SELECT PI.namePic
                                         FROM picproduct PI
                                         WHERE PI.idProduct = PR.idProduct
                                         ORDER BY PI.idPic
                                         LIMIT 1) AS namePic
                                    FROM products PR
                                    INNER JOIN product_size_color SC ON PR.idProduct = SC.idProduct
                                    INNER JOIN sizes sz ON sz.idSize = SC.idSize
                                    WHERE PR.idProduct = ?", [$idProduct]);
// var_dump($listProducts);                                 
?>


<!DOCTYPE html>
<html lang="en">
<?php include "../include/head.php" ?>
<style>
    .dropdown-menus {
        display: none;
        list-style: none;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        z-index: 2;
    }

    .dropdown-menus li {
        margin: 5px 0;
    }

    .dropdown-menus li:hover {
        color: #c46a2f;
    }

    .dropdown-menus li a {
        text-decoration: none;
        color: #000;
    }

    .action_dad {
        width: 100px;
    }

    /* .action .position-relative:hover .dropdown-menus { */
    /* display: block; */
    /* } */
</style>

<body>
    <?php include "../include/header.php" ?>
    <div class="container-fluid">
        <div class="row">
            <?php include "../include/aside.php" ?>

            <!-- main  -->
            <main class="col-md-10 mt-5">
                <h1 class="mt-4">Quản lí hình ảnh sản phẩm</h1>
                <div class="container-fluid mt-2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html" class="nav-link">Trang quản lí</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Quản lí sản phẩm</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <div class="search-items">
                        <form action="">
                            <input type="search" name="search_items" id="search_items">
                        </form>
                    </div>
                    <div class="add-category">
                        <a href="./add.php" class="btn color-bg text-white px-4 mx-5">Thêm sản phẩm</a>
                    </div>
                </div>
                <h2><?php echo $listProducts[0]['nameProduct'] ?></h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Màu sắc</th>
                            <th>Kích thước</th>
                            <th>Số lượng</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php foreach ($listProducts as $product) { ?>
                            <tr class="align-middle">
                                <td><?php echo $product['color'] ?></td>
                                <td><?php echo $product['nameSize'] ?></td>
                                <td><?php echo $product['quantityProduct'] ?></td>
                                <td class="action_dad">
                                    <div class="action d-flex">
                                        <a href="remove.php?id=<?php echo $product['idProduct'] ?>" class="remove_product
                                    fw-bold text-danger text-decoration-none me-2" onclick="alertRemove(event, 'người dùng')">Xóa</a>
                                        <div class="position-relative">
                                            <a href="#" class="update_product 
                                            text-decoration-none fw-bold mx-2" onclick="showChange(event, this)">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </a>
                                            <ul class="dropdown-menus position-absolute top-3 end-0 px-3 py-1" id="dropdown-menu">
                                                <li><a class="dropdown-item" href="update.php?id=<?php echo $product['idProduct'] ?>">Cập nhật thông tin</a></li>
                                                <li><a class="dropdown-item" href="update_color?id=<?php echo $product['idProduct'] ?>">Danh sách màu sắc</a></li>
                                                <li><a class="dropdown-item" href="update_image?id=<?php echo $product['idProduct'] ?>">Danh sách hình ảnh</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>
    <script>
        let openDropdown = null;

        function showChange(event, element) {
            event.preventDefault();

            // Close any currently open dropdowns
            if (openDropdown && openDropdown !== element.nextElementSibling) {
                openDropdown.style.display = 'none';
            }

            // Toggle the clicked dropdown
            let dropdown = element.nextElementSibling;
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
                openDropdown = null;
            } else {
                dropdown.style.display = 'block';
                openDropdown = dropdown;
            }
        }
    </script>

    <?php include "../include/footer.php" ?>
</body>

</html>