<?php
    include "../../client/DBUntil.php";
    $dbHelper = new DBUntil();
    // $categories = $dbHelper->select("SELECT * FROM subcategories");
    $errors = [];
    $optionSize = $dbHelper->select("SELECT * FROM sizes");
    // var_dump($optionSize);

    if (isset($_SERVER['HTTP_REFERER'])) {
        $prevHttps = $_SERVER['HTTP_REFERER'];
    }
    
    

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_POST['size']) || empty($_POST['size'])) {
            $errors['add_size_color'] = "Không có dữ liệu";
        }

        $sizes = isset($_POST['size']) ? $_POST['size'] : [];
        $colors = isset($_POST['color']) ? $_POST['color'] : [];
        $quantities = isset($_POST['quantity']) ? $_POST['quantity'] : [];
        $id = $_GET['id'];
        
        // Kiểm tra nếu các mảng có cùng số lượng phần tử
        if (count($sizes) == count($colors) && count($colors) == count($quantities)) {
            for ($i = 0; $i < count($sizes); $i++) {
                // echo "Size: " . htmlspecialchars($sizes[$i]) . "<br>";
                // echo "Color: " . htmlspecialchars($colors[$i]) . "<br>";
                // echo "Quantity: " . htmlspecialchars($quantities[$i]) . "<br><br>";

                $data = [
                    'idProduct' => $id,
                    'idSize' => $sizes[$i],
                    'color' => $colors[$i],
                    'quantityProduct' => $quantities[$i],
                ];
                $lastInsert = $dbHelper->insert('product_size_color', $data);
            }
            if (isset($prevHttps) && $prevHttps = "http://localhost/project-summer-2024/admin/products/list_color.php?id=$id") {
                header("Location: " . $prevHttps);
                exit();
            } else {
                header("Location: add_pic.php?id=$id");
            }
        } else {
            echo "Invalid input data.";
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
                        <h1 class="mt-4">Thêm kích cỡ, màu sắc</h1>
                        <form action method="post">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Size</th>
                                        <th>Color</th>
                                        <th>Số lượng</th>
                                        <th>...</th>
                                    </tr>
                                </thead>
                                <tbody id="table">

                                </tbody>
                            </table>
                            <?php 
                                 if(isset($errors['add_size_color'])) {
                                    echo "<span class='text-danger'>$errors[add_size_color]</span>";
                                }
                            ?>
                            <div class="text-end mt-3">
                                <button type="submit" class="btn text-white color-bg">Thêm kích cỡ, màu sắc</button>
                            </div>
                        </form>
                        <div id="sizeColorContainer">
                            <div>
                                <div>
                                    <label for="" class="fw-bold me-2">Size:</label>
                                    <select required id="select">
                                    <?php foreach ($optionSize as $size) { ?>
                                        <option value="<?php echo $size['idSize'] ?>"><?php echo $size['nameSize'] ?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                                <div class="mt-2">
                                    <label for="" class="fw-bold me-2">Màu sắc: </label>
                                    <input type="color" placeholder="Color" id="color" required>
                                </div>
                                <div class="mt-2">
                                    <label for="" class="fw-bold me-2 mt-2">Số lượng</label>
                                    <input type="text" placeholder="Quantity" id="quantity" required>
                                    <span class="alert_error text-danger d-block"></span>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn color-bg text-white" onclick="addSizeColor()">
                           Thêm
                        </button>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="col-md-2"></div>
        </div>
        </main>
    </div>
    </div>

    <?php include "../include/footer.php" ?>
    <script>
        function addSizeColor() {
            const container = document.getElementById('table');
            const div = document.createElement('tr');
            let select = document.querySelector('#select');
            let color = document.querySelector('#color');
            let quantity = document.querySelector('#quantity');
            const error = document.querySelector('.alert_error');
            let bool = true;
            const quantityValue = parseInt(quantity.value, 10);

            if (quantity.value.trim() == "") {
                error.innerText = "Vui lòng nhập số lượng."
                bool = false;
            }
            else if (quantityValue < 1) {
                error.innerText = "Vui lòng nhập lớn hơn 1.";
                bool = false;
            }
            else if (!Number.isInteger(quantityValue)) {
                error.innerText = "Vui lòng nhập đúng định dạng";
                bool = false;
            }
            if (bool) {
                error.innerText = ""
                div.innerHTML = `
                    <td><input type="text" name="size[]" value="${select.value}" class="btn-tb" readonly></td>
                    <td><input type="text" name="color[]" value="${color.value}" class="btn-tb" readonly></td>
                    <td><input type="text" name="quantity[]" value="${quantity.value}" class="btn-tb" readonly></td>
                    <td onclick="removeSizeColor(this)"><button type="button" class="btn_remove">Remove</button></td>
                `;
                container.appendChild(div);
                update();
            }
        }
        
        function update() {
            let select = document.querySelector('#select');
            let color = document.querySelector('#color');
            let quantity = document.querySelector('#quantity');
            // select.value = reset;
            color.value = "";
            quantity.value = "";
        }

        function removeSizeColor(button) {  
            button.parentElement.remove();
        }
    </script>
</body>

</html>