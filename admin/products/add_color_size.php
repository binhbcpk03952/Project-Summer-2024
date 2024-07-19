<?php
    include "../../client/DBUntil.php";
    $dbHelper = new DBUntil();
    // $categories = $dbHelper->select("SELECT * FROM subcategories");
    $errors = [];
    $sizes = $dbHelper->select("SELECT * FROM sizes");
    

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
            $lastInsertId = $dbHelper->insert('categories', $data);
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
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <h1 class="mt-4">Thêm sản phẩm</h1>
                        <form action="" method="post">
                            <div id="sizeColorContainer">
                                <div>
                                    <select name="sizes[]" required>
                                        <?php foreach ($sizes as $size) { ?>
                                        <option value="<?= $size['idSize'] ?>"><?= $size['nameSize'] ?></option>
                                        <?php }; ?>
                                    </select>
                                    <input type="text" name="colors[]" placeholder="Color" required>
                                    <input type="number" name="quantities[]" placeholder="Quantity" required>
                                </div>
                            </div>
                            <button type="button" onclick="addSizeColor()">Add Another Size/Color</button>
                            <div class="text-end mt-3">

                                <button type="submit" class="btn color-bg text-white">Thêm sản phẩm</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </main>
        </div>
    </div>

    <?php include "../include/footer.php" ?>
    <script>
    function addSizeColor() {
        const container = document.getElementById('sizeColorContainer');
        const div = document.createElement('div');
        div.innerHTML = `
        <select name="sizes[]" required>
            <?php foreach ($sizes as $size) { ?>
                <option value="<?= $size['idSize'] ?>"><?= $size['nameSize'] ?></option>
            <?php }; ?>
        </select>
        <input type="text" name="colors[]" placeholder="Color" required>
        <input type="number" name="quantities[]" placeholder="Quantity" required>
        <button type="button" onclick="removeSizeColor(this)">Remove</button>
    `;
        container.appendChild(div);
    }

    function removeSizeColor(button) {
        button.parentElement.remove();
    }
    </script>
</body>

</html>