<?php
    include "../../client/DBUntil.php";
    $dbHelper = new DBUntil();
    $category = $dbHelper->select("SELECT * FROM categories CA 
                                   INNER JOIN subcategories SC 
                                   ON CA.idCategories = SC.idCategories");
    // var_dump($category);
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
                    <h1 class="mt-4">Quản lí danh mục con</h1>
                    <div class="container-fluid mt-2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"
                                        class="nav-link">Trang quản lí</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Quản lí danh mục con</li>
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
                            <a href="./add.php" class="btn color-bg text-white px-4 mx-5">Thêm danh mục</a>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Mã danh mục</th>
                                <th>Tên danh mục con</th>
                                <th>Tên danh mục</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($category as $category) { ?>
                            <tr>
                                <td><?php echo $category['idSubCategory']?></td>
                                <td><?php echo $category['nameSubCategory']?></td>
                                <td><?php echo $category['nameCategories']?></td>
                                <td>
                                    <div class="action">
                                        <a href="update.php?id=<?php echo $category['idCategories'] ?>" class="update_category text-decoration-none fw-bold mx-2">Cập nhật</a>
                                        <a href="remove.php?id=<?php echo $category['idSubCategory'] ?>" class="remove_category
                                            fw-bold text-danger text-decoration-none" onclick="alertRemove(event, 'danh mục')">Xóa</a>
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
