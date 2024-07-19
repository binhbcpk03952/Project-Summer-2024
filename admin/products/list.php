<?php
    include "../../client/DBUntil.php";
    $dbHelper = new DBUntil();
    $listProducts = $dbHelper->select("SELECT PR.*,
                                              SUM(SC.quantityProduct) AS total_quantity,
                                              (SELECT PI.namePic
                                               FROM picproduct PI
                                               WHERE PI.idProduct = PR.idProduct
                                               ORDER BY PI.idPic
                                               LIMIT 1) AS namePic
                                       FROM products PR
                                       INNER JOIN product_size_color SC ON PR.idProduct = SC.idProduct
                                       GROUP BY PR.idProduct");
    // var_dump($listProducts);                                 
?>


<!DOCTYPE html>
<html lang="en">
    <?php include "../include/head.php" ?>
    
    <body>
       <?php include "../include/header.php" ?>
        <div class="container-fluid">
            <div class="row">
                <?php include "../include/aside.php" ?>

                <!-- main  -->
                <main class="col-md-10 mt-5">
                    <h1 class="mt-4">Quản lí sản phẩm</h1>
                    <div class="container-fluid mt-2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"
                                        class="nav-link">Trang quản lí</a></li>
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
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Mô tả</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($listProducts as $product) { ?>
                            <tr>
                                <td><?php echo $product['namePic']?></td>
                                <td><?php echo $product['nameProduct']?></td>
                                <td><?php echo $product['price']?></td>
                                <td><?php echo $product['total_quantity']?></td>
                                <td><?php echo $product['description']?></td>
                                <td>
                                    <div class="action">
                                        <a href="update.php?id=<?php echo $product['idProduct'] ?>" class="update_product text-decoration-none fw-bold mx-2">Cập nhật</a>
                                        <a href="remove.php?id=<?php echo $product['idProduct'] ?>" class="remove_product
                                            fw-bold text-danger text-decoration-none" onclick="alertRemove(event, 'người dùng')">Xóa</a>
                                    </div>
                                </td>
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>
                </main>
            </div>
        </div>

        <?php include "../include/footer.php" ?>     
    </body>

</html>
