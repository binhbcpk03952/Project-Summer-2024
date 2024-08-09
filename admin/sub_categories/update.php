<?php
    include "../../client/DBUntil.php"; 
    session_start();
    $dbHelper = new DBUntil();

    $categories = $dbHelper->select('SELECT * FROM categories');
    $id = $_GET['id'];
    $catgory = $dbHelper->select("SELECT * FROM subcategories sub
                                  INNER JOIN categories ca ON ca.idCategories = sub.idCategories
                                  WHERE idSubCategory = $id")[0];

    $categories = $dbHelper->select("SELECT * FROM categories");
    $categories[0] = [
        "idCategories" => $catgory['idCategories'],
        "nameCategories" => $catgory['nameCategories']
    ];
    var_dump(($catgory));
    $errors = [];
    function isCheckCate($name, $id) {
        global $dbHelper;
        $result = $dbHelper->select("SELECT nameSubCategory FROM subcategories WHERE nameSubCategory = ? AND idSubCategory != ?", [$name, $id]);
        return count($result) > 0;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       
        if(!isset($_POST['name_categories']) || empty($_POST['name_categories'])) {
                $errors['name_categories'] = "Đây là trường bắt buộc <br>" ;
        }
        if(!isset($_POST['name_category']) || empty($_POST['name_category'])) {
            $errors['name_category'] = "Đây là trường bắt buộc <br>" ;
    }
        elseif (isCheckCate($_POST['name_categories'], $id)) {
            $errors['name_categories'] = "Danh mục đã tồn tại <br>" ;
        }
        // var_dump($_POST);

        if (count($errors) == 0) {
            $data = [
                'nameSubCategory' => $_POST['name_categories'],
                'idCategories' => $_POST['name_category']
            ];
            $lastInsertId = $dbHelper->update('subcategories', $data , "idSubCategory = $id"); 
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
                            <h1 class="mt-4">Cập nhật danh mục</h1>
                            <form action="" method="post">
                                <div class="name-category">
                                    <label for="">Tên danh mục con</label>
                                    <input type="text" name="name_categories"
                                        id="name_category" class="form-control" value="<?php echo $catgory['nameSubCategory']?>">
                                        <?php
                                            if(isset($errors['name_categories'])) {
                                                echo "<span class='text-danger'>$errors[name_categories] </span>";
                                            }
                                        ?>
                                </div>
                                <div class="option-select mt-3">
                                    <select class="form-select" name="name_category">
                                    <?php foreach ($categories as $cat) { ?>
                                        <option value="<?php echo $cat['idCategories'] ?>"><?php echo $cat['nameCategories'] ?></option>
                                    <?php } ?>
                                    </select>
                                    <?php
                                        if(isset($errors['name_category'])) {
                                            echo "<span class='text-danger'>$errors[name_category] </span>";
                                        }
                                    ?>
                                </div>
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="list.php" class="return btn text-white color-bg">
                                        <i class="fa-solid fa-right-from-bracket deg-180"></i>
                                        Quay lại
                                    </a>

                                    <button type="submit" class="btn color-bg text-white">cập nhật danh mục</button>
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
