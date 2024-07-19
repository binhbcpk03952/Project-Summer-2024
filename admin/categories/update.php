<?php
    include "../../client/DBUntil.php";
    $dbHelper = new DBUntil();
    $id = $_GET['id'];
    
    $category = $dbHelper->select("SELECT * FROM categories WHERE idCategories = ?", [$id])[0];
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
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <h1 class="mt-4">Cập nhật danh mục</h1>
                            <form action="" method="post">
                                <div class="name-category">
                                    <label for="">Tên danh mục</label>
                                    <input type="text" name="name_category"
                                        id="name_category" class="form-control" value="<?php echo $category['nameCategories'] ?>">
                                </div>
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="#" class="return btn text-white color-bg">
                                        <i class="fa-solid fa-right-from-bracket deg-180"></i>
                                        Quay lại
                                    </a>

                                    <button type="submit" class="btn color-bg text-white">Cập nhật</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                </main>
            </div>
        </div>

        <?php include "../include/footer.php" ?>     
    </body>

</html>
