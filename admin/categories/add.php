<?php
    include "../../client/DBUntil.php";
    $dbHelper = new DBUntil();

    $errors = [];
    function isCheckCate($name) {
        global $dbHelper;
        $result = $dbHelper->select("SELECT nameCategories FROM categories WHERE nameCategories=?", [$name]);
        if (count($result) > 0) {
            return true;
        }
        return false;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       
        if(!isset($_POST['name_category']) || empty($_POST['name_category'])) {
                $errors['name_category'] = "Đây là trường bắt buộc <br>" ;
        }
        elseif (isCheckCate($_POST['name_category'])) {
            $errors['name_category'] = "Danh mục đã tồn tại <br>" ;
        }
        // var_dump($_POST);

        if (count($errors) == 0) {
            $lastInsertId = $dbHelper->insert('categories', array('nameCategories' => $_POST['name_category'],));
            header('Location: list.php');
        }
    }
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
                            <h1 class="mt-4">Thêm danh mục</h1>
                            <form action="" method="post">
                                <div class="name-category">
                                    <label for="">Tên danh mục</label>
                                    <input type="text" name="name_category"
                                        id="name_category" class="form-control">
                                        <?php
                                            if(isset($errors['name_category'])) {
                                                echo "<span class='text-danger'>$errors[name_category] </span>";
                                            }
                                        ?>
                                </div>
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="#" class="return btn text-white color-bg">
                                        <i class="fa-solid fa-right-from-bracket deg-180"></i>
                                        Quay lại
                                    </a>

                                    <button type="submit" class="btn color-bg text-white">Thêm danh mục</button>
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
