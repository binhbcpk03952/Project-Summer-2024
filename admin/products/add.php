<?php
    include "../../client/DBUntil.php";
    $dbHelper = new DBUntil();
    $categories = $dbHelper->select("SELECT * FROM subcategories");
    $errors = [];
    

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       
        if(!isset($_POST['name_product']) || empty($_POST['name_product'])) {
                $errors['name_product'] = "Đây là trường bắt buộc <br>" ;
        }
        if(!isset($_POST['price']) || empty($_POST['price'])) {
            $errors['price'] = "Đây là trường bắt buộc <br>" ;
        } elseif ($_POST['price'] < 1) {
            $errors['price'] = "Giá tiền không được bé hơn 1 <br>" ;
        }
        elseif (!is_numeric($_POST['price'])){
            $errors['price'] = "Giá trị không hợp lệ <br>" ;
        }
        if(!isset($_POST['description']) || empty($_POST['description'])) {
            $errors['description'] = "Đây là trường bắt buộc <br>" ;
        }
        if(!isset($_POST['categories']) || empty($_POST['categories'])) {
            $errors['categories'] = "Đây là trường bắt buộc <br>" ;
        }

        if (count($errors) == 0) {
            $data = [
                'nameProduct' => $_POST['name_product'],
                'price' => $_POST['price'],
                'description' => $_POST['description'],
                'idSubCategory' => $_POST['categories'],
            ];
            $lastInsertId = $dbHelper->insert('products', $data);
            $id = $dbHelper->lastInsertId();
            header("Location: add_color_size.php?id=$id");
            exit();
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
                            <h1 class="mt-4">Thêm sản phẩm</h1>
                            <form action="" method="post">
                                <div class="name-product">
                                    <label for="">Tên sản phẩm</label>
                                    <input type="text" name="name_product"
                                        id="name_product" class="form-control">
                                        <?php
                                            if(isset($errors['name_product'])) {
                                                echo "<span class='text-danger'>$errors[name_product] </span>";
                                            }
                                        ?>
                                </div>
                                <div class="price-product">
                                    <label for="">Giá</label>
                                    <input type="text" name="price"
                                        id="price" class="form-control">
                                        <?php
                                            if(isset($errors['price'])) {
                                                echo "<span class='text-danger'>$errors[price] </span>";
                                            }
                                        ?>
                                </div>
                                <div class="description-product">
                                    <label for="">Mô tả</label>
                                    <textarea name="description" id="description" class="form-control"></textarea>
                                        <?php
                                            if(isset($errors['description'])) {
                                                echo "<span class='text-danger'>$errors[description] </span>";
                                            }
                                        ?>
                                </div><div class="cate-product">
                                    <label for="">Danh mục</label>
                                    <select name="categories" id="" class="form-select">
                                        <option value="">Chọn danh mục</option>
                                        <?php foreach ($categories as $cat) { ?>
                                            <option value="<?php echo $cat['idSubCategory'] ?>"><?php echo $cat['nameSubCategory']?></option>
                                        <?php } ?>
                                    </select>
                                        <?php
                                            if(isset($errors['categories'])) {
                                                echo "<span class='text-danger'>$errors[categories] </span>";
                                            }
                                        ?>
                                </div>
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="list.php" class="return btn text-white color-bg">
                                        <i class="fa-solid fa-right-from-bracket deg-180"></i>
                                        Quay lại
                                    </a>

                                    <button type="submit" class="btn color-bg text-white">Thêm sản phẩm</button>
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
