
<?php
include "../../client/DBUntil.php";
$dbHelper = new DBUntil();
$uploadDirectory = "image/";
$id = $_GET['id'];
// Tạo thư mục nếu chưa tồn tại
// Debugging logs
$prevHttps = "http://localhost/project-summer-2024/admin/products/list_image.php?id=$id";





if (!is_dir($uploadDirectory)) {
    mkdir($uploadDirectory, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['images'])) {
    $images = $_FILES['images'];
    $fileCount = count($images['name']);

    for ($i = 0; $i < $fileCount; $i++) {
        $fileName = basename($images['name'][$i]);
        $targetFilePath = $uploadDirectory . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Kiểm tra định dạng file
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');
        if (in_array($fileType, $allowTypes)) {
            // Upload file lên server
            if (move_uploaded_file($images['tmp_name'][$i], $targetFilePath)) {
                // Lưu thông tin file vào cơ sở dữ liệu
                $data = [
                    'namePic' => $fileName,
                    'idProduct' => $id,
                ];
                $lastInsert = $dbHelper->insert("picproduct", $data);
            } else {
                echo "Error uploading file " . $fileName;
            }
        } else {
            echo "Invalid file type: " . $fileName;
        }
    }
    echo "Files uploaded successfully.";
    if ($lastInsert) {
        $prevHttps = "http://localhost/project-summer-2024/admin/products/list_image.php?id=$id";

        if (isset($_SERVER['HTTP_REFERER'])) {
            $previous_url = $_SERVER['HTTP_REFERER'];

            if (strpos($previous_url, $prevHttps) !== false) {
                header("Location: " . $previous_url);
            } else {
                header("Location: list.php?id=$id");
            }
        } else {
            header("Location: list.php?id=$id");
        }
        exit(); // Đảm bảo không có mã nào khác được thực thi sau khi chuyển hướng
    }
} else {
    echo "No files selected.";
}
?>
<style>
    input[type="file"] {
        display: block;
        margin-bottom: 10px;
        padding: 10px;
        border: 2px dashed #ccc;
        border-radius: 5px;
        background-color: #fff;
        cursor: pointer;
    }

    button[type="submit"] {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin-top: 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: #45a049;
    }

    #imagePreview img {
        max-width: 100%;
        height: auto;
        margin-top: 10px;
        border: 1px solid #ccc;
        padding: 5px;
        border-radius: 5px;
    }
</style>

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
                <form action="" method="post" enctype="multipart/form-data" class="mt-5">
                    <input type="file" id="imageUpload" name="images[]" accept="image/*" multiple>
                    <div id="imagePreview"></div>
                    <button type="submit">Upload Images</button>
                </form>
            </main>
        </div>
    </div>

    <?php include "../include/footer.php" ?>

    <script>
        document.getElementById('imageUpload').addEventListener('change', function(event) {
            var imagePreview = document.getElementById('imagePreview');
            imagePreview.innerHTML = ''; // Xóa nội dung cũ trước khi hiển thị ảnh mới

            var files = event.target.files;

            for (var i = 0; i < files.length; i++) {
                var file = files[i];

                if (file) {
                    var reader = new FileReader();
                    reader.onload = (function(file) {
                        return function(e) {
                            var img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.display = 'block';
                            imagePreview.appendChild(img);
                        };
                    })(file);
                    reader.readAsDataURL(file);
                }
            }
        });
    </script>
</body>

</html>