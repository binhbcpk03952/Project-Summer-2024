<?php
include_once('../../client/DBUntil.php');
$dbHelper = new DBUntil();
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
                    <h1 class="mt-4">Quản lí giảm giá</h1>
                    <div class="container-fluid mt-2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"
                                        class="nav-link">Trang quản lí</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Quản lí giảm giá</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <div class="search-items">
                            <form action="">
                                <input class="input-search" type="search" name="search" id="search" placeholder="Tìm kiếm">
                                <button type="submit" class="btn btn-primary " name="search" value="Tim kiếm">
                            </form>
                        </div>
                        <div class="add-category">
                            <a href="./add.php" class="btn color-bg text-white px-4 mx-5">Thêm mã giảm giá</a>
                        </div>
                    </div>
                    <table class="table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Mã giảm giá</th>
                                <th>Số lượng</th>
                                <th>Giảm giá</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày kết thúc</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $coupons = $dbHelper->select("SELECT * FROM coupons");
                        foreach ($coupons as $items) { ?>
                            <tr>
                                <td><?php echo $items['idCoupon']?></td>
                                <td><?php echo $items['name']?></td>
                                <td><?php echo $items['code']?></td>
                                <td><?php echo $items['quantity']?></td>
                                <td><?php echo $items['discount']?> %</td>
                                <td><?php echo $items['startDate']?></td>
                                <td><?php echo $items['endDate']?></td>
                                <td>
                                    <div class="action">
                                        <a href="update_coupons.php?id=<?php echo $items['idCoupon']; ?>" class="update_coupons text-decoration-none fw-bold mx-2">Cập nhật</a>
                                        <a href="remove_coupons.php?id=<?php echo $items['idCoupon'] ?>" class="remove_coupons  fw-bold text-danger text-decoration-none" onclick="alertRemove(event, 'người dùng')">Xóa</a>

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
