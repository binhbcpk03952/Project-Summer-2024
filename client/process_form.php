<?php
session_start();
include "./DBUntil.php";
$dbHelper = new DBUntil();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Làm sạch dữ liệu đầu vào
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
    $color = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_STRING);
    $size = filter_input(INPUT_POST, 'size', FILTER_SANITIZE_STRING);

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

    // Kiểm tra xem người dùng đã đăng nhập hay chưa
    if (isset($_SESSION['id'])) {
        // Lấy thông tin sản phẩm
        $product = $dbHelper->select("SELECT * FROM products WHERE idProduct = ?", [$product_id])[0];
        $nameProduct = $product['nameProduct'];

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $isCheckCart = $dbHelper->select("SELECT * FROM carts ca 
                                          JOIN detailcart dtc ON dtc.idCart = ca.idCart
                                          JOIN users us ON us.idUser = ca.idUser
                                          WHERE us.idUser = ?
                                                AND dtc.idProduct = ?
                                                AND dtc.size = ?
                                                AND dtc.color = ?", [$_SESSION['id'], $product_id, $size, $color]);

        if ($isCheckCart) {
            // Cập nhật số lượng nếu sản phẩm đã có trong giỏ hàng
            $idDetailCart = $isCheckCart[0]['idDetailCart'];
            $quantity = $isCheckCart[0]['quantityCart'] + 1;
            $condition = "idDetailCart = $idDetailCart";
            $updateCart = $dbHelper->update("detailcart", ['quantityCart' => $quantity], $condition);
        } else {
            // Kiểm tra xem giỏ hàng của người dùng đã tồn tại chưa
            $checkCart = $dbHelper->select("SELECT * FROM users us  
                                            JOIN carts ca ON ca.idUser = us.idUser
                                            WHERE ca.idUser = ?", [$_SESSION['id']]);

            if ($checkCart) {
                // Nếu giỏ hàng đã tồn tại, thêm sản phẩm vào giỏ hàng
                $id = $checkCart[0]['idCart'];
                $dataDetailCart = [
                    "quantityCart" => 1,
                    "idProduct" => $product_id,
                    "idCart" => $id,
                    "color" => $color,
                    "size" => $size,
                ];
                $detailCartLast = $dbHelper->insert("detailcart", $dataDetailCart);
            } else {
                // Nếu giỏ hàng chưa tồn tại, tạo giỏ hàng mới và thêm sản phẩm vào giỏ hàng
                $data = ["idUser" => $_SESSION['id']];
                $insertCart = $dbHelper->insert("carts", $data);

                if ($insertCart) {
                    $id = $dbHelper->lastInsertId();
                    $dataDetailCart = [
                        "quantityCart" => 1,
                        "idProduct" => $product_id,
                        "idCart" => $id,
                        "color" => $color,
                        "size" => $size,
                    ];
                    $detailCart = $dbHelper->insert("detailcart", $dataDetailCart);
                } else {
                    $detailCart = false;
                }
            }
        }

        // Kiểm tra kết quả và phản hồi tương ứng
        if ((isset($insertCart) && $insertCart && isset($detailCart) && $detailCart) || (isset($updateCart) && $updateCart) || (isset($detailCartLast))) {
            $escapedNameProduct = htmlspecialchars($nameProduct, ENT_QUOTES, 'UTF-8');
            echo json_encode(['status' => 'success', 'message' => "$escapedNameProduct"]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Không thể thêm sản phẩm vào giỏ hàng.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng']);
        // Tùy chọn chuyển hướng tới trang đăng nhập
        // header('Location: index.php');
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Phương thức yêu cầu không hợp lệ.']);
}
?>
