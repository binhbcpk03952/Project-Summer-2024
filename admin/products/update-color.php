<?php
include "../../client/DBUntil.php";
$dbHelper = new DBUntil();
$idSizeColor = $_GET['id'];
$idProduct = $_GET['idPrd'];
$errors = [];

// Fetch option size details
$optionSize = $dbHelper->select(
    "SELECT * FROM product_size_color psc
     JOIN sizes sz ON sz.idSize = psc.idSize 
     WHERE psc.idSizeColor = ?",
    [$idSizeColor]
);

// Fetch available sizes
$sizes = $dbHelper->select("SELECT * FROM sizes");

// Adjust sizes array for form
$sizes[0] = [
    "idSize" => $optionSize[0]['idSize'],
    "nameSize" => $optionSize[0]['nameSize'],
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate the quantity
    if (!isset($_POST['quantityProduct']) || empty($_POST['quantityProduct'])) {
        $errors['quantityProduct'] = "Đây là trường bắt buộc <br>";
    } elseif (!is_numeric($_POST['quantityProduct']) || (int)$_POST['quantityProduct'] <= 0) {
        $errors['quantityProduct'] = "Số phải là dương <br>";
    }

    if (empty($errors)) {
        $data = [
            'color' => $_POST['color'],
            'quantityProduct' => $_POST['quantityProduct'],
        ];
        
        $condition = "idSizeColor = :idSizeColor";
        $params = ['idSizeColor' => $idSizeColor];
        
        $result = $dbHelper->update('product_size_color', $data, $condition, $params);

        if ($result) {
            header("Location: list_color.php?id=$idProduct");
            exit();
        } else {
            $errors['update'] = "Cập nhật không thành công. Vui lòng thử lại.";
        }
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
                        <form action="" method="post">
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
                                    <tr>
                                        <th>
                                            <select required id="select">
                                                <?php foreach ($sizes as $size) { ?>
                                                    <option value="<?php echo $size['idSize'] ?>"><?php echo $size['nameSize'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </th>

                                        <th>
                                            <input type="color" name="color" id="color" value="<?php echo $optionSize[0]['color'] ?>">
                                        </th>
                                        <th>
                                            <input type="text" name="quantityProduct" id="quantity" value="<?php echo $optionSize[0]['quantityProduct'] ?>">
                                            <?php
                                            if (isset($errors['quantityProduct'])) {
                                                echo "<span class='text-danger'>$errors[quantityProduct] </span>";
                                            }
                                            ?>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                            <?php
                            if (isset($errors['add_size_color'])) {
                                echo "<span class='text-danger'>$errors[add_size_color]</span>";
                            }
                            ?>
                            <div class="text-end mt-3">
                                <button type="submit" class="btn text-white color-bg">Cập nhật kích cỡ, màu sắc</button>
                            </div>
                        </form>

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
            } else if (quantityValue < 1) {
                error.innerText = "Vui lòng nhập số lượng lớn hơn 0.";
                bool = false;
            } else if (!Number.isInteger(quantityValue)) {
                error.innerText = "Vui lòng nhập số lượng đúng định dạng.";
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
            color.value = "";
            quantity.value = "";
        }

        function removeSizeColor(button) {
            button.parentElement.remove();
        }
    </script>
</body>

</html>
