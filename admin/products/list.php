<?php
// include "../../client/DBUntil.php";
// $dbHelper = new DBUntil();
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
function formatCurrencyVND($number)
{
    // Sử dụng number_format để định dạng số tiền mà không có phần thập phân
    return number_format($number, 0, ',', '.') . 'đ';
}
?>

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
        <a href="index.php?view=product_created" class="btn color-bg text-white px-4 mx-5">Thêm sản phẩm</a>
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
                <td><img src="../../../project-summer-2024/admin/products/image/<?php echo $product['namePic'] ?>" alt="" class="image_list"></td>
                <td><?php echo $product['nameProduct'] ?></td>
                <td><?php echo formatCurrencyVND($product['price']) ?></td>
                <td><?php echo $product['total_quantity'] ?></td>
                <td><?php echo $product['description'] ?></td>
                <td class="action_dad">
                    <div class="action d-flex">
                        <a href="remove.php?id=<?php echo $product['idProduct'] ?>" class="remove_product
                                    fw-bold text-danger text-decoration-none me-2" onclick="alertRemove(event, 'người dùng')">Xóa</a>
                        <div class="position-relative">
                            <a href="#" class="update_product 
                                            text-decoration-none fw-bold mx-2" onclick="showChange(event, this)">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </a>
                            <ul class="dropdown-menus position-absolute top-3 end-0 px-3 py-1" id="dropdown-menu">
                                <li><a class="dropdown-item" href="index.php?view=product_update&id=<?php echo $product['idProduct'] ?>">Cập nhật thông tin</a></li>
                                <li><a class="dropdown-item" href="index.php?view=product_list-color&id=<?php echo $product['idProduct'] ?>">Danh sách màu sắc</a></li>
                                <li><a class="dropdown-item" href="index.php?view=product_list-image&id=<?php echo $product['idProduct'] ?>">Danh sách hình ảnh</a></li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script src="./js/script.js"></script>