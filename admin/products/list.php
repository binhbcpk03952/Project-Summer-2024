<?php
    include "../../client/DBUntil.php";
    $dbHelper = new DBUntil();
    $listProducts = $dbHelper->select("SELECT PR.*,
                                              SUM(SC.quantityProduct) AS total_quantity,
                                              (SELECT PI.namePic
                                               FROM picproduct PI
                                               WHERE PI.idProduct = PR.idProduct
                                               ORDER BY PI.idPic
                                               LIMIT 1) AS namePic
                                       FROM products PR
                                       INNER JOIN product_size_color SC ON PR.idProduct = SC.idProduct
                                       GROUP BY PR.idProduct");
    // var_dump($listProducts);          
    function formatCurrencyVND($number) {
        // Sử dụng number_format để định dạng số tiền mà không có phần thập phân
        return number_format($number, 0, ',', '.') . 'đ';
    }                       
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
    width: 100px;
}
/* .action .position-relative:hover .dropdown-menus { */
    /* display: block; */
/* } */
/* General Styling */
/* body {
    font-family: Arial, sans-serif;
} */

/* Table Styling */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.table th, .table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

.table th {
    background-color: #f8f9fa;
}

.table td {
    vertical-align: middle;
}

.image_list {
    width: 80px;
    height: auto;
    object-fit: cover; /* Ensures images fill the space while maintaining aspect ratio */
    border-radius: 5px;
}

/* Button Styling */
.btn {
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    text-transform: uppercase;
    font-weight: bold;
}

.color-bg {
    background-color: #007bff;
}

.color-bg:hover {
    background-color: #0056b3;
}

.search-items input[type="search"] {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ddd;
    width: 200px;
}

.add-category a {
    display: inline-block;
}

/* Dropdown Menus */
.dropdown-menus {
    display: none;
    list-style: none;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    z-index: 2;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.dropdown-menus li {
    margin: 5px 0;
}

.dropdown-menus li a {
    text-decoration: none;
    color: #000;
    display: block;
    padding: 5px;
    border-radius: 3px;
}

.dropdown-menus li a:hover {
    background-color: #f1f1f1;
    color: #007bff;
}

/* Action Section */
.action_dad {
    display: flex;
    align-items: center;
    justify-content: center;
}

.remove_product {
    color: #dc3545;
    font-weight: bold;
}

.remove_product:hover {
    text-decoration: underline;
}

.update_product {
    color: #007bff;
    font-weight: bold;
}

.update_product:hover {
    text-decoration: underline;
}

.position-relative {
    position: relative;
}

/* Responsive Design */
@media (max-width: 768px) {
    .table {
        font-size: 14px;
    }
    
    .image_list {
        width: 60px;
    }
    
    .search-items input[type="search"] {
        width: 150px;
    }
}

</style>

<body>
    <?php include "../include/header.php" ?>
    <div class="container-fluid">
        <div class="row">
            <?php include "../include/aside.php" ?>

            <!-- main  -->
            <main class="col-md-10 mt-5">
                <h1 class="mt-4">Quản lí sản phẩm</h1>
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
                        <a href="./add.php" class="btn color-bg text-white px-4 mx-5">Thêm sản phẩm</a>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Mô tả</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php foreach ($listProducts as $product) { ?>
                        <tr class="align-middle">
                            <td><img src="./image/<?php echo $product['namePic']?>" alt="" class="image_list"></td>
                            <td><?php echo $product['nameProduct']?></td>
                            <td><?php echo formatCurrencyVND($product['price'])?></td>
                            <td><?php echo $product['total_quantity']?></td>
                            <td><?php echo $product['description']?></td>
                            <td class="action_dad">
                                <div class="action d-flex">
                                    <a href="remove.php?id=<?php echo $product['idProduct'] ?>" class="remove_product
                                    fw-bold text-danger text-decoration-none me-2"
                                    onclick="alertRemove(event, 'người dùng')">Xóa</a>
                                    <div class="position-relative">
                                        <a href="#" class="update_product 
                                            text-decoration-none fw-bold mx-2" onclick="showChange(event, this)">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menus position-absolute top-3 end-0 px-3 py-1" id="dropdown-menu">
                                            <li><a class="dropdown-item" href="update.php?id=<?php echo $product['idProduct'] ?>">Cập nhật thông tin</a></li>
                                            <li><a class="dropdown-item" href="list_color.php?id=<?php echo $product['idProduct'] ?>">Danh sách màu sắc</a></li>
                                            <li><a class="dropdown-item" href="list_image.php?id=<?php echo $product['idProduct'] ?>">Danh sách hình ảnh</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>
    <script>
        let openDropdown = null;

function showChange(event, element) {
    event.preventDefault();
    
    // Close any currently open dropdowns
    if (openDropdown && openDropdown !== element.nextElementSibling) {
        openDropdown.style.display = 'none';
    }

    // Toggle the clicked dropdown
    let dropdown = element.nextElementSibling;
    if (dropdown.style.display === 'block') {
        dropdown.style.display = 'none';
        openDropdown = null;
    } else {
        dropdown.style.display = 'block';
        openDropdown = dropdown;
    }
}

    </script>

    <?php include "../include/footer.php" ?>
</body>

</html>