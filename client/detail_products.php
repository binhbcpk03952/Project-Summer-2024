<?php
session_start();
include "./DBUntil.php";
$dbHelper = new DBUntil();
function formatCurrencyVND($number) {
    // Sử dụng number_format để định dạng số tiền mà không có phần thập phân
    return number_format($number, 0, ',', '.') . ' đ';
}        

// Validate and sanitize input
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
    echo "Invalid product ID.";
    exit;
}

// Fetch product details
$results = $dbHelper->select("SELECT p.idProduct, p.nameProduct, p.description, p.price, pcs.color, sz.nameSize
                                  FROM products p 
                                  JOIN product_size_color pcs ON p.idProduct = pcs.idProduct
                                  JOIN sizes sz ON sz.idSize = pcs.idSize
                                  WHERE p.idProduct = ?
                                  ORDER BY pcs.idSize ASC", [$id]);

// Fetch product images
$images = $dbHelper->select("SELECT * FROM picproduct WHERE idProduct = ?", [$id]);

$products = [];
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

<?php include "./includes/head.php" ?>

<body class="">
    <?php include "./includes/header.php" ?>
    <!-- banner -->
    <div class="container mt-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html" class="nav-link">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sản
                    phẩm</li>
            </ol>
        </nav>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-md-5 me-2">
                <div class="image_product">
                    <div class="show_image">
                        <!-- This div can be used to display the selected image or the main image -->
                        <img src="../admin/products/image/<?php echo htmlspecialchars($images[0]['namePic']); ?>">
                    </div>
                    <div class="image_thumbnail d-flex mt-2">
                        <?php foreach ($images as $image) : ?>
                            <div class="thumbnails me-2">
                                <img src="../admin/products/image/<?php echo htmlspecialchars($image['namePic']); ?>" alt="image" class="img-thumbnails">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-5 ms-3">
                <div class="product_content">
                    <?php foreach ($products as $product_id => $product) : ?>
                        <form id="product-form-<?php echo $product_id; ?>">
                            <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id; ?>">
                            <h3 class="fw-bold fs-5 my-1"><?php echo htmlspecialchars($product['nameProduct']); ?></h3>
                            <p class="product_id my-1">MÃ SP: 123ASGH</p>
                            <p class="fw-bold mt-3 mb-4"><?php echo formatCurrencyVND(htmlspecialchars($product['price'])) ?></p>
                            <div class="product_color">
                                <label for="" class="d-block fs-6 mb-2 fw-bold">Màu sắc:</label>
                                <div class="button-group" id="color-group-<?php echo $product_id; ?>">
                                    <?php
                                    $colors = array_unique(array_column($product['variants'], 'color'));
                                    foreach ($colors as $color) : ?>
                                        <button type="button" class="btn" style="background-color: <?php echo htmlspecialchars($color); ?>;" onclick="selectColor('<?php echo $product_id; ?>', '<?php echo htmlspecialchars($color); ?>', event)"></button>
                                    <?php endforeach; ?>
                                </div>
                                <input type="hidden" name="color" id="color-<?php echo $product_id; ?>" required>
                                <span class='errors text-danger' id="color-error-<?php echo $product_id; ?>"></span>
                            </div>
                            <div class="product_size mt-3">
                                <label for="" class="d-block fs-6 mb-2 fw-bold">Kích thước:</label>
                                <div class="button-group" id="size-group-<?php echo $product_id; ?>">

                                </div>
                                <input type="hidden" name="size" id="selected-size-<?php echo $product_id; ?>" value="">
                                <span class='errors text-danger' id="size-error-<?php echo $product_id; ?>"></span>
                            </div>
                            <div class="choose_size mt-4">
                                <p class="choose_size--text my-1">
                                    <i class="fa-solid fa-table class color-main"></i>
                                </p>
                            </div>
                            <div class="image_freeship">
                                <img src="https://owen.cdn.vccloud.vn/media/amasty/ampromobanners/CD06C467-DE0F-457E-9AB0-9D90B567E118.jpeg" alt="" class="w-100">
                            </div>
                            <button type="button" class="btn btn-dark w-100 mt-5 fw-bold rounded-0" onclick="submitForm('<?php echo $product_id; ?>')">Thêm vào giỏ hàng</button>
                        </form>
                    <?php endforeach; ?>
                    <div class="description mt-5">
                        <span class="description_heading fw-bold">MÔ TẢ</span>
                        <hr class="m-0">
                        <p class="fs-7"><?php echo $results[0]['description'] ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-1"></div>
        </div>
    </div>
    <div id="alerts-container"></div>
    <script>
        // JavaScript to handle the click event on the thumbnails
    </script>
    <script src="./js/script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php include "./comment/comment.php" ?>
<script>
function alertCart(content) {
    let container = document.getElementById('alerts-container');
    let alertHtml = `
        <div class="container-fluid position_alert" id="alertCart">
            <div class="bg-alert d-flex justify-content-center align-items-center w-100">
                <div class="content_alert alert_cart">
                    <div class="icon-warning d-flex justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-circle-check-big icon_cart mt-3"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 
                            11 3 3L22 4"/></svg>
                    </div>
                    <h3 class="text-center fs-6 mt-3">Thêm sản phẩm <span class="fw-bold">${content}</span> vào giỏ hàng thành công.</h3>
                </div>
            </div>
        </div>
    `;
    container.innerHTML += alertHtml;
    setTimeout(() => {
        let alertElement = document.getElementById('alertCart');
        if (alertElement) {
            alertElement.remove();
        }
    }, 2000);
}


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

function submitForm(productId) {
    const form = document.getElementById('product-form-' + productId);
    const color = document.getElementById('color-' + productId).value;
    const size = document.getElementById('selected-size-' + productId).value;

    // Thực hiện validate phía client
    let valid = true;
    if (!color) {
        document.getElementById('color-error-' + productId).innerText = 'Đây là trường bắt buộc';
        valid = false;
    } else {
        document.getElementById('color-error-' + productId).innerText = '';
    }

    if (valid) {
        $.ajax({
            url: 'process_form.php',
            method: 'POST',
            data: $(form).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    console.log(response.message);
                    alertCart(response.message);
                    // Tuỳ chọn, bạn có thể đóng modal ở đây
                    $('#box_cart').hide();
                } else if (response.status === 'errors') {
                    alert('Lỗi: ' + response.message);
                    location.href = "login.php"
                } else {
                    alert('Lỗi: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.log('Lỗi: ' + error);
            }
        });
    }
}

</script>
    <?php include "./includes/footer.php" ?>