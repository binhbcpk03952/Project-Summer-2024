<?php
include "../../client/DBUntil.php";
session_start();
$dbHelper = new DBUntil();

// Lấy từ khóa tìm kiếm từ yêu cầu
$searchTerm = isset($_GET['search_items']) ? $_GET['search_items'] : '';

// Tạo truy vấn tìm kiếm
$query = "SELECT SC.idSubCategory, SC.nameSubCategory, CA.nameCategories
          FROM subcategories SC
          INNER JOIN categories CA ON SC.idCategories = CA.idCategories
          WHERE SC.nameSubCategory LIKE :searchTerm
          OR CA.nameCategories LIKE :searchTerm";

// Thực thi truy vấn với tham số tìm kiếm
$params = ['searchTerm' => '%' . $searchTerm . '%'];
$category = $dbHelper->select($query, $params);

$login_success = false;

if (isset($_SESSION['success']) && $_SESSION['success'] === true) {
    $login_success = true;
    unset($_SESSION['success']); // Unset the session variable to avoid repeated alerts
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "../include/head.php" ?>
    <style>
        /* Add relevant CSS styles */
        .search-items input[type="search"] {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 200px;
        }
        .btn.color-bg {
            background-color: #007bff;
            color: #fff;
        }
        .btn.color-bg:hover {
            background-color: #0056b3;
        }
        .table th, .table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .table th {
            background-color: #f8f9fa;
        }
        .alert-cart {
            background: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
    <script>
    function alertSuccessfully(content) {
        let container = document.getElementById('alerts-container');
        let alertHtml = `
            <div class="alert-cart" id="alertSuccessfully">
                <div class="d-flex justify-content-center align-items-center w-100">
                    <div class="content_alert text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon-check">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <path d="m9 11 3 3L22 4"/>
                        </svg>
                        <h3 class="fs-6 mt-3">${content}</h3>
                    </div>
                </div>
            </div>
        `;
        container.innerHTML += alertHtml;
        setTimeout(() => {
            let alertElement = document.getElementById('alertSuccessfully');
            if (alertElement) {
                alertElement.remove();
            }
        }, 2000);
    }
    <?php if ($login_success): ?>
        alertSuccessfully("Thành Công!");
    <?php endif; ?>
    </script>
</head>
<body>
    <div id="alerts-container"></div> <!-- Container cho thông báo -->
    
    <?php include "../include/header.php" ?>

    <div class="container-fluid">
        <div class="row">
            <?php include "../include/aside.php" ?>

            <!-- main -->
            <main class="col-md-10 mt-5">
                <h1 class="mt-4">Quản lí danh mục con</h1>
                <div class="container-fluid mt-2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html" class="nav-link">Trang quản lí</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Quản lí danh mục con</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <div class="search-items">
                        <form action="" method="get">
                            <input type="search" name="search_items" id="search_items" placeholder="Tìm kiếm danh mục">
                            <button type="submit" class="btn color-bg text-white">Tìm kiếm</button>
                        </form>
                    </div>
                    <div class="add-category">
                        <a href="./add.php" class="btn color-bg text-white px-4 mx-5">Thêm danh mục</a>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mã danh mục</th>
                            <th>Tên danh mục con</th>
                            <th>Tên danh mục</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($category as $cat) { ?>
                        <tr>
                            <td><?php echo $cat['idSubCategory']?></td>
                            <td><?php echo $cat['nameSubCategory']?></td>
                            <td><?php echo $cat['nameCategories']?></td>
                            <td>
                                <div class="action">
                                    <a href="update.php?id=<?php echo $cat['idSubCategory'] ?>" class="update_category text-decoration-none fw-bold mx-2">Cập nhật</a>
                                    <a href="remove.php?id=<?php echo $cat['idSubCategory'] ?>" class="remove_category
                                        fw-bold text-danger text-decoration-none" onclick="alertRemove(event, 'danh mục')">Xóa</a>
                                </div>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>

    <?php include "../include/footer.php" ?>     
</body>
</html>
