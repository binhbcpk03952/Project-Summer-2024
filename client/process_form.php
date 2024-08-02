<?php
include "./DBUntil.php";
$dbHelper = new DBUntil();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate và làm sạch dữ liệu đầu vào
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
    $color = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_STRING);
    $size = filter_input(INPUT_POST, 'size', FILTER_SANITIZE_STRING);

    $product = $dbHelper->select("SELECT * FROM products WHERE idProduct = $product_id")[0];

    $nameProduct = $product['nameProduct'];

    // Kiểm tra tính hợp lệ của dữ liệu đầu vào
    if (!$product_id || !filter_var($product_id, FILTER_VALIDATE_INT)) {
        echo json_encode(['status' => 'error', 'message' => 'Mã sản phẩm không hợp lệ.']);
        exit;
    }
    if (!$color || empty($color)) {
        echo json_encode(['status' => 'error', 'message' => 'Màu sắc là bắt buộc.']);
        exit;
    }
    if (!$size || empty($size)) {
        echo json_encode(['status' => 'error', 'message' => 'Kích thước là bắt buộc.']);
        exit;
    }

    // Chèn dữ liệu vào bảng giỏ hàng
    $data = [
        "idUser" => 1,
    ];
    $insertCart = $dbHelper->insert("carts", $data);

    if ($insertCart) {
        // echo json_encode(['status' => 'success', 'message' => 'Sản phẩm đã được thêm vào giỏ hàng.']);
        $escapedNameProduct = htmlspecialchars($nameProduct, ENT_QUOTES, 'UTF-8');
        echo 'success: Sản phẩm \'' . $escapedNameProduct . '\' đã được thêm vào giỏ hàng.';
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Không thể thêm sản phẩm vào giỏ hàng.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Phương thức yêu cầu không hợp lệ.']);
}
?>
