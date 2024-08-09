<?php
include "../../client/DBUntil.php";
$dbHelper = new DBUntil();
$uploadDirectory = "image/";
$id = $_GET['id'];
$idProduct = $_GET['idPrd'];

$image = $dbHelper->select("SELECT * FROM picproduct WHERE idPic = ?", [$id]);

// Create directory if it does not exist
if (!is_dir($uploadDirectory)) {
    mkdir($uploadDirectory, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['images'])) {
    $images = $_FILES['images'];

    // Ensure only one file is uploaded
    if (count($images['name']) > 1) {
        echo "Please upload only one image.";
        exit();
    }

    $fileName = basename($images['name'][0]);
    $targetFilePath = $uploadDirectory . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Validate file type
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');
    if (in_array($fileType, $allowTypes)) {
        // Upload file to server
        if (move_uploaded_file($images['tmp_name'][0], $targetFilePath)) {
            // Save file info to database
            $data = [
                'namePic' => $fileName,
                'idProduct' => $idProduct,
            ];
            $lastInsert = $dbHelper->update("picproduct", $data, "idPic = $id");

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
                exit(); // Ensure no further code execution after redirect
            }
        } else {
            echo "Error uploading file " . $fileName;
        }
    } else {
        echo "Invalid file type: " . $fileName;
    }
} else {
    echo "No files selected.";
}
?>
<style>
    main {
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin: 20px 0;
    }






    input[type="file"] {
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f8f8f8;
    }

    .button-1 {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .button-1:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    .button-1:focus {
        outline: none;
    }

    .anh-1 {
        margin-top: 20px;
        text-align: center;
        /* Center the image preview */
    }

    .anh-1 img {
        max-width: 100%;
        /* Make sure the image fits within the container */
        max-height: 600px;
        /* Increase the height limit */
        height: auto;
        border: 1px solid #ddd;
        border-radius: 8px;
        display: block;
        margin: 0 auto;
        /* Center the image horizontally */
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
                    <input type="file" id="imageUpload" name="images[]" accept="image/*">
                    <div class="anh-1" id="imagePreview">
                    <img src="./image/<?php echo $image[0]['namePic'] ?>" class="d-block" style="max-width: 500px; height: auto;" alt="">

                    </div>

                    <button class="button-1" type="submit">Upload Images</button>
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