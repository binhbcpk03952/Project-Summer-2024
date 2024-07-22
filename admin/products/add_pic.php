<?php
    include "../../client/DBUntil.php";
    $dbHelper = new DBUntil();
    $uploadDirectory = "image/";
    $id = $_GET['id'];

// Tạo thư mục nếu chưa tồn tại
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
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            // Upload file lên server
            if (move_uploaded_file($images['tmp_name'][$i], $targetFilePath)) {
                // Lưu thông tin file vào cơ sở dữ liệu
                $data = [
                    'namePic' => $fileName,
                    'idProduct' => $id,
                ];
                $lastInsert = $dbHelper->insert("picproduct", $data);
                header("location: list.php");
                exit();
            } else {
                echo "Error uploading file " . $fileName;
            }
        } else {
            echo "Invalid file type: " . $fileName;
        }
    }

    echo "Files uploaded successfully.";
} else {
    echo "No files selected.";
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