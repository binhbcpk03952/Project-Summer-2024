<?php
$errors = [];
$comment_text = "";
$image = "";
$idUser = $_SESSION['id'] ?? 0; 
$id_Product = isset($_GET['id']) ? intval($_GET['id']) : 0; 

// Fetch and display comments
$result = $dbHelper->select(
    "SELECT do.idProduct, o.idOrder, do.size, do.color, u.name, u.image as user_image, c.comment_text, c.commentDate, c.idComment, u.idUser, c.image as comment_image
     FROM coment c 
     INNER JOIN users u ON u.idUser = c.idUser
     INNER JOIN orders o ON u.idUser = o.idUser
     INNER JOIN detailorder do ON c.idProduct = do.idProduct
     WHERE c.idProduct = ?
     GROUP BY c.idProduct", [$id_Product]
);
?>
<?php 
    if(count($result) == 0){
        echo "<h2 class='text-center'>Sản phẩm chưa có bình luận nào!</h2>";
    }else{ ?>
<hr>
<?php foreach ($result as $row) : ?>
<div class="container list_comment">
    <div class="user_comment">
        <ul class="list-inline d-flex">
            <li><img src="../admin/users/image/<?= htmlspecialchars($row['user_image']); ?>"
                    style="width: 30px; height: 30px; border-radius: 50%;" alt=""></li>
            <li class="fw-bold fs-5 mx-2"><?= htmlspecialchars($row['name']); ?></li>
            <li class="mx-2"><span><?= date("d/m/Y", strtotime($row['commentDate'])); ?></span></li>
        </ul>
        <span class="fs-6 fw-light">( <?= htmlspecialchars($row['color']); ?>, <?= htmlspecialchars($row['size']); ?>
            )</span>
    </div>
    <div class="comment">
        <p class="fs-6"><?= nl2br(htmlspecialchars($row['comment_text'])); ?></p>
        <?php if (!empty($row['comment_image'])): ?>
        <img src="../../../project-summer-2024/client/comment/image/<?= htmlspecialchars($row['comment_image']); ?>"
            style="width: 100px; height: 100px;" alt="">
        <?php endif; ?>
    </div>
    <div class="action">
        <?php if ($idUser == $row['idUser']): ?>
            <a href="../../../project-summer-2024/client/comment/delete_comment.php?id=<?php echo $row['idProduct'] ?>"
                class="remove_users fw-bold text-danger text-decoration-none"
                >Xóa</a>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; 
}
?>

<?php
if ($idUser && $id_Product) {
    // Check if the user has purchased the product
    $idOrders = $dbHelper->select("SELECT idOrder FROM orders WHERE idUser = ?", [$idUser]);
    $purchasedProductIds = [];

    foreach ($idOrders as $order) {
        $detailOrders = $dbHelper->select("SELECT idProduct FROM detailorder WHERE idOrder = ?", [$order['idOrder']]);
        foreach ($detailOrders as $detail) {
            $purchasedProductIds[] = $detail['idProduct'];
        }
    }

    $productPurchased = in_array($id_Product, $purchasedProductIds);

    if ($productPurchased) {
        echo '<hr><div class="comment-form container">';
        echo '<h2>THÊM BÌNH LUẬN</h2>';
        echo '<form action="" method="POST" enctype="multipart/form-data">';
        echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id_Product) . '">';
        echo '<label for="comment">Bình luận:</label><br>';
        echo '<textarea class="form-control" id="comment" name="comment" placeholder="Nhập bình luận ..." required></textarea><br><br>';
        echo '<label for="image">Thêm hình ảnh:</label><br>';
        echo '<input type="file" id="image" name="image"><br><br>';
        echo '<button type="submit" name="submit_comment" class="btn btn-primary">Bình luận</button>';
        echo '</form></div>';

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_comment']) && $productPurchased) {
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $target_dir = __DIR__ . "/image/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $IMAGE_TYPES = ['jpg', 'jpeg', 'png'];

                if (!in_array($imageFileType, $IMAGE_TYPES)) {
                    $errors['image'] = "Image type must be JPG, JPEG, or PNG.";
                }

                if ($_FILES['image']["size"] > 1000000) {
                    $errors['image'] = "Image file size is too large.";
                }

                if (empty($errors) && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image = htmlspecialchars(basename($_FILES["image"]["name"]));
                } else {
                    $errors['image'] = "Sorry, there was an error uploading your file.";
                }
            }

            $comment_text = isset($_POST['comment']) ? htmlspecialchars($_POST['comment']) : "";
            $comment_date = date('Y-m-d H:i:s');

            if (empty($errors)) {
                $data = [
                    'comment_text' => $comment_text,
                    'commentDate' => $comment_date,
                    'idUser' => $idUser,
                    'idProduct' => $id_Product,
                    'image' => $image
                ];

                $add_comment = $dbHelper->insert("coment", $data);
                // Refresh the page to show the new comment
                // header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $id_Product);
                // exit;
            }
        }
    } else {
        echo '<p class="container">Bạn chưa mua sản phẩm này, không thể bình luận.</p>';
    }
} else {
    echo '<p>Invalid user or product ID.</p>';
}
?>
