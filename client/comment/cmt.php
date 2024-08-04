<?php
    include_once("../DBUntil.php");
    session_start();

    // Khởi tạo biến và mảng lưu lỗi
    $errors = [];
    $comment_text = "";
    $dbHelper = new DBUntil();
    $name = "";
    $image = "";
    $idUser = 1; // Thay bằng $_SESSION['id'] trong ứng dụng thực tế
    $idProduct = 1; // Thay bằng $_SESSION['idProduct'] trong ứng dụng thực tế

    // Lấy thông tin người dùng và sản phẩm từ cơ sở dữ liệu
    $user = $dbHelper->select("SELECT * FROM users WHERE idUser = ?", [$idUser]);
    $name = $user[0]['name'];
    $product = $dbHelper->select("SELECT * FROM products WHERE idProduct = ?", [$idProduct]);

    // Xử lý khi người dùng gửi bình luận
    if (isset($_POST['submit_comment'])) {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $target_dir = __DIR__ . "/image/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $IMAGE_TYPES = array('jpg', 'jpeg', 'png');
            if (!in_array($imageFileType, $IMAGE_TYPES)) {
                $errors['image'] = "Image type must be JPG, JPEG, or PNG.";
            }
    
            if ($_FILES['image']["size"] > 1000000) {
                $errors['image'] = "Image file size is too large.";
            }
    
            // If no errors, proceed with file upload
            if (empty($errors)) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image = htmlspecialchars(basename($_FILES["image"]["name"]));
                } else {
                    $errors['image'] = "Sorry, there was an error uploading your file.";
                }
            }
        } 
        if (!empty($_POST['comment'])) {
            $comment_text = htmlspecialchars($_POST['comment']);
        } else {
            $errors['comment'] = "Vui lòng nhập bình luận.";
        }
        if(empty($errors)){
            $data = [
                'comment_text' => $comment_text,
                'idUser' => $idUser,
                'idProduct' => $idProduct,
                'commentDate' => date('Y-m-d H:i:s'),
                'image' => $image,
            ];
            $dbHelper->insert('coment', $data);
        } 
    }

    // Lấy danh sách bình luận cho sản phẩm
    $result = $dbHelper->select("SELECT * FROM coment WHERE idProduct = ? ORDER BY commentDate DESC", [$idProduct]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Bình luận sản phẩm</title>
</head>

<body>
<div class="container mt-5">
    <h3 class="mb-4">Bình luận</h3>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="comment">Bình luận:</label>
            <textarea name="comment" class="form-control" rows="3"></textarea>
            <?php if (isset($errors['comment'])): ?>
                <p class="text-danger"><?php echo $errors['comment']; ?></p>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label for="image">Hình ảnh</label><br>
            <input type="file" id="image" name="image" class="form-control-file mb-3" multiple>
            <?php if (isset($errors['image'])): ?>
                <p class="text-danger"><?php echo $errors['image']; ?></p>
            <?php endif; ?>
        </div>
        <button type="submit" name="submit_comment" class="btn btn-primary">Gửi bình luận</button>
    </form>

    <h3 class="mt-5">Danh sách bình luận</h3>
    <?php if (count($result) > 0): ?>
        <div class="list-group">
            <?php foreach ($result as $value): ?>
                <div class="list-group-item">
                    <p><strong><?php echo $name; ?></strong> (<?php echo $value['commentDate']; ?>)</p>
                    <p><?php echo $value['comment_text']; ?></p>
                    <?php if ($value['image']): ?>
                        <img src="image/<?php echo $value['image']; ?>" class="img-fluid" style="max-width: 200px; max-height: 200px;">
                    <?php endif; ?>
                    <div class="action">
                        <a href="update_comment.php?id=<?php echo $value['idComment']; ?>" class="update_users text-decoration-none fw-bold mx-2">Chỉnh sửa</a>
                        <a href="delete_comment.php?id=<?php echo $value['idComment'] ?>" class="remove_users fw-bold text-danger text-decoration-none" onclick="alertRemove(event, 'người dùng')">Xóa</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
