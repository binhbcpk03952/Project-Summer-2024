<?php
    include "../../client/DBUntil.php";
    $dbHelper = new DBUntil();
    $listComment = $dbHelper->select("SELECT * FROM coment");
    $idUser = $listComment[0]['idUser'];
    $users = $dbHelper->select("SELECT * FROM users WHERE idUser = $idUser");
    $name = $users[0]['name'];                           
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
                    <h1 class="mt-4">Quản lí bình luận</h1>
                    <div class="container-fluid mt-2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"
                                        class="nav-link">Trang quản lí</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Quản lí bình luận</li>
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
                            <!-- <a href="./add.php" class="btn color-bg text-white px-4 mx-5">Thêm người dùng</a> -->
                        </div>
                    </div>
                    <table class="table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Bình luận</th>
                                <th>Sản phẩm</th>
                                <th>Hình ảnh</th>
                                <th>Thời gian</th>
                                <th>option</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($listComment as $comments) { 
                            if($comments['image']){
                                $image = json_decode($comments['image'], true);
                            }
                            ?>
                            
                            <tr>
                                <td><?php echo $comments['idComment']?></td>
                                <td><?php echo $name ?></td>
                                <td><?php echo $comments['comment_text']?></td>
                                <td><?php echo $comments['idProduct']?></td>
                                <td><img src ="../../client/comment/image/<?php echo $comments['image'] ?>" style="width: 50px; height: 50px;"></img></td>
                                <td><?php echo $comments['commentDate']?></td>
                                <td>
                                    <div class="action">
                                        <a href="../../client/detail_products.php?id=<?php echo $comments['idProduct']; ?>" class="remove_users fw-bold text-primary text-decoration-none mx-3">xem</a>
                                        <a href="delete_cmt.php?id=<?php echo $comments['idComment']; ?>" class="remove_users fw-bold text-danger text-decoration-none" onclick="alertRemove(event, 'người dùng')">Xóa</a>
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
