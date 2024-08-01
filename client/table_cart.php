<?php
include "./DBUntil.php";
$dbHelper = new DBUntil();
$id = $_GET['id'];
$results = $dbHelper->select("SELECT p.idProduct, p.nameProduct, p.description, p.price, pcs.color, sz.nameSize
        FROM products p 
        JOIN product_size_color pcs ON p.idProduct = pcs.idProduct
        JOIN sizes sz ON sz.idSize = pcs.idSize
        WHERE p.idProduct = $id");

$images = $dbHelper->select("SELECT * FROM picproduct WHERE idProduct = ?", [$id]);
$products = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $id;
    $color = $_POST['color'];
    $size = $_POST['size'];
    if (!isset($color) || empty($color)) {
        $errors['color'] = "Đây là trường bắt buộc";
    }

    echo $product_id . "<br>";
    echo $color . "<br>";
    echo $size . "<br>";
}

foreach ($results as $row) {
    $product_id = $row['idProduct'];
    if (!isset($products[$product_id])) {
        $products[$product_id] = [
            'nameProduct' => $row['nameProduct'],
            'description' => $row['description'],
            'price' => $row['price'],
            'variants' => []
        ];
    }
    $products[$product_id]['variants'][] = [
        'color' => $row['color'],
        'size' => $row['nameSize']
    ];
}

?>

<div class="bg-alert d-flex justify-content-center align-items-center w-100">
    <div class="content_alert">
        <!-- <h3 class="text-center">Thêm giỏ hàng</h3> -->
        <div class="text-end pe-3">
            <i class="fa-solid fa-xmark fs-4 fw-bold hidden-box"></i>
        </div>
        <div class="icon-warning d-flex justify-content-center">
            <div class="row p-3 pt-0">
                <div class="col-md-6">
                    <div class="image_product">
                        <!-- This div can be used to display the selected image or the main image -->
                        <img src="../admin/products/image/<?php echo htmlspecialchars($images[0]['namePic']); ?>" class="w-100">

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="product_content">
                        <?php foreach ($products as $product_id => $product) : ?>
                            <form action method="post">
                                <h3 class="fw-bold fs-5 my-1"><?php echo $product['nameProduct']; ?></h3>
                                <p class="product_id my-1">MÃ SP: 123ASGH</p>
                                <p class="fw-bold mt-3 mb-4"></p>
                                <div class="product_color">
                                    <label for class="d-block fs-6 mb-2 fw-bold">Màu sắc:</label>
                                    <!-- color  -->
                                    <div class="button-group" id="color-group-<?php echo $product_id; ?>">
                                        <?php // lọc màu trùng lặp
                                        $colors = array_unique(array_column($product['variants'], 'color'));
                                        foreach ($colors as $color) : ?>
                                            <button type="button" class="btn" style="background-color: <?php echo $color; ?>;" onclick="selectColor('<?php echo $product_id; ?>', '<?php echo $color; ?>', event)"></button>
                                        <?php endforeach; ?>
                                    </div>
                                    <input type="hidden" name="color" id="color-<?php echo $product_id; ?>" required>
                                </div>
                                <!-- size  -->
                                <div class="product_size mt-3">
                                    <label for class="d-block fs-6 mb-2 fw-bold">Kích thước:</label>
                                    <div class="button-group" id="size-group-<?php echo $product_id; ?>">
                                        <!-- kích thước  -->
                                    </div>
                                    <input type="hidden" id="selected-size-<?php echo $product_id; ?>" value="">
                                </div>
                                <div class="choose_size mt-4">
                                    <p class="choose_size--text my-1">
                                        <i class="fa-solid fa-table class color-main"></i>
                                    </p>
                                </div>
                                <div class="image_freeship">
                                    <img src="https://owen.cdn.vccloud.vn/media/amasty/ampromobanners/CD06C467-DE0F-457E-9AB0-9D90B567E118.jpeg" alt class="w-100">
                                </div>
                                <button type="submit" class="btn btn-dark w-100 mt-5 fw-bold rounded-0" onclick="alertCarts('<?php echo $product['nameProduct'] ?>')">Thêm vào giỏ
                                    hàng</button>
                            <?php endforeach; ?>
                            </form>

                            <div class="description mt-5">
                                <span class="description_heading fw-bold">MÔ TẢ</span>
                                <hr class="m-0">
                                <p>Lorem ipsum dolor sit amet consectetur,
                                    adipisicing elit. Ea cumque maiores similique fu</p>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</script>
<script src="./js/script.js"></script>
<script>
    function selectColor(productId, color, event) {
        var colorGroup = document.getElementById('color-group-' + productId);
        var buttons = colorGroup.getElementsByTagName('button');
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].classList.remove('active');
        }
        event.target.classList.add('active');
        const colorInput = document.getElementById('color-' + productId);
        const previouslySelectedColor = colorInput.value;

        // Nếu người dùng chọn một màu khác
        if (previouslySelectedColor !== color) {
            // Reset the selected size
            document.getElementById('selected-size-' + productId).value = '';

            // Xóa lớp active khỏi tất cả các nút kích thước
            const sizeButtons = document.querySelectorAll('#size-group-' + productId + ' button');
            sizeButtons.forEach(button => {
                button.classList.remove('active');
            });

            // Đặt giá trị của input ẩn thành màu đã chọn
            colorInput.value = color;

            // Gửi yêu cầu AJAX đến demo.php để lấy kích thước
            $.ajax({
                url: 'demo.php',
                method: 'GET',
                data: {
                    color: color,
                    productId: productId
                },
                success: function(response) {
                    // Hiển thị kết quả trong phần tử kích thước tương ứng
                    document.getElementById('size-group-' + productId).innerHTML = response;
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                }
            });
        }
    }

    function selectSize(productId, size, event) {
        // Lưu kích thước đã chọn vào input ẩn
        document.getElementById('selected-size-' + productId).value = size;

        // Xóa lớp active khỏi tất cả các nút kích thước
        const sizeButtons = document.querySelectorAll('#size-group-' + productId + ' button');
        sizeButtons.forEach(button => {
            button.classList.remove('active');
        });

        // Thêm lớp active vào nút kích thước được chọn
        event.target.classList.add('active');
    }
</script>

</html>