<?php
include "../../client/DBUntil.php";
$dbHelper = new DBUntil();
$idProduct = $_GET['id'];
$listProducts = $dbHelper->select("SELECT * FROM products prd
                                   JOIN picproduct pic ON pic.idProduct = prd.idProduct 
                                   WHERE prd.idProduct = ?", [$idProduct]);
// var_dump($listProducts);                                 
?>


<!DOCTYPE html>
<html lang="en">
<?php include "../include/head.php" ?>
<style>
    .dropdown-menus {
        display: none;
        list-style: none;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        z-index: 2;
    }

    .dropdown-menus li {
        margin: 5px 0;
    }

    .dropdown-menus li:hover {
        color: #c46a2f;
    }

    .dropdown-menus li a {
        text-decoration: none;
        color: #000;
    }

    .action_dad {
        /* width: 100px; */
    }

    .list_color {
        width: 40px;
        height: 40px;
        border: #ccc 2px solid;
        border-radius: 3px;
    }

    .size_image {
        width: 300px;
    }

    /* .action .position-relative:hover .dropdown-menus { */
    /* display: block; */
    /* } */
    .list_image--product {
    /* Ensure each image container is the same size */
    width: 100%;
    height: 200px; /* Adjust the height as needed */
    overflow: hidden; /* Hide overflow to ensure images fit */
    display: flex;
    align-items: center; /* Center images vertically */
    justify-content: center; /* Center images horizontally */
}

.list_image--product img {
    width: 100%; /* Make image fill the container */
    height: auto; /* Maintain aspect ratio */
    object-fit: cover; /* Ensure image covers the container while maintaining aspect ratio */
}

/* Optional: Add a border or padding for better visuals */
.change_imgage {
    border: 1px solid #ddd; /* Light border around images */
    padding: 5px;
    border-radius: 5px; /* Rounded corners */
}

.action {
    /* Ensure actions have consistent styling */
    text-align: center;
    margin-top: 10px;
}

</style>

<body>
    <?php include "../include/header.php" ?>
    <div class="container-fluid">
        <div class="row">
            <?php include "../include/aside.php" ?>

            <!-- main  -->
            <main class="col-md-10 mt-5">
                <h1 class="mt-4">Quản lí hình ảnh sản phẩm</h1>
                <div class="container-fluid mt-2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html" class="nav-link">Trang quản lí</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Quản lí sản phẩm</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <div class="search-items">
                        <form action="">
                            <input type="search" name="search_items" id="search_items">
                        </form>
                    </div>
                    <div class="add-category">
                        <a href="./add_pic.php?id=<?php echo $idProduct?>" class="btn color-bg text-white px-3 mx-5">Thêm hình ảnh</a>
                    </div>
                </div>
                <h2 class="mt-2">Tên sản phẩm: <?php echo $listProducts[0]['nameProduct'] ?></h2>
                <div class="row mb-4">
                    <?php foreach ($listProducts as $product) { ?>
                        <div class="col-md-3">
                            <div class="change_imgage">
                                <div class="list_image--product">
                                    <img src="./image/<?php echo $product['namePic'] ?>" alt="<?php echo $product['namePic'] ?>" class="w-100">
                                </div>
                                <div class="action d-flex justify-content-center mt-3">
                                    <a href="update-image.php?id=<?php echo $product['idPic'] ?>&idPrd=<?php echo $product['idProduct'] ?>" class="remove_product
                                                fw-bold text-primary text-decoration-none me-3">Cập nhật</a>
                                    <a href="./remove_file/remove_pic.php?id=<?php echo $product['idPic'] ?>&idPrd=<?php echo $product['idProduct'] ?>" class="remove_product
                                                fw-bold text-danger text-decoration-none me-2" onclick="alertRemove(event, 'hình ảnh')">Xóa</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </main>
        </div>
    </div>

    <?php include "../include/footer.php" ?>
</body>

</html>