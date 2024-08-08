<?php
    include "../../client/DBUntil.php";
    session_start();
    $dbHelper = new DBUntil();
    $listUser = $dbHelper->select("SELECT * FROM users");
    $searchTerm = isset($_POST['search']) ? trim($_POST['search']) : "";    
    $users = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($searchTerm)) {
    $users = $dbHelper->select("SELECT * FROM users WHERE username LIKE ?", array('%' . $searchTerm . '%'));
} else {
    $users = $dbHelper->select("SELECT * FROM users");
}          
$login_success = false;
if (isset($_SESSION['success']) && $_SESSION['success'] === true) {
    $login_success = true;
    unset($_SESSION['success']); // Unset the session variable to avoid repeated alerts
}                  
?>


<!DOCTYPE html>
<html lang="en">
    <?php include "../include/head.php" ?>
    
    <body>
    <div id="alerts-container"></div> <!-- Container cho thông báo -->
<script>
function alertSuccessfully(content) {
    let container = document.getElementById('alerts-container');
    let alertHtml = `
        <div class="container-fluid position_alert" id="alertSuccessfully">
            <div class="bg-alert d-flex justify-content-center align-items-center w-100">
                <div class="content_alert alert_cart">
                    <div class="icon-warning d-flex justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-circle-check-big icon_cart mt-3"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 
                            11 3 3L22 4"/></svg>
                    </div>
                    <h3 class="text-center fs-6 mt-3">${content}</h3>
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
       <?php include "../include/header.php" ?>
        <div class="container-fluid">
            <div class="row">
                <?php include "../include/aside.php" ?>

                <!-- main  -->
                <main class="col-md-10 mt-5">
                    <h1 class="mt-4">Quản lí nguời dùng</h1>
                    <div class="container-fluid mt-2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"
                                        class="nav-link">Trang quản lí</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Quản lí người dùng</li>
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
                            <a href="./add.php" class="btn color-bg text-white px-4 mx-5">Thêm người dùng</a>
                        </div>
                    </div>
                    <table class="table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Tên đăng nhập</th>
                                <th>Mật khẩu</th>
                                <th>Email</th>
                                <th>Sđt</th>
                                <th>Vai trò</th>
                                <th>Avatar</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($listUser as $users) { ?>
                            <tr>
                                <td><?php echo $users['idUser']?></td>
                                <td><?php echo $users['name']?></td>
                                <td><?php echo $users['username']?></td>
                                <td><?php echo $users['password']?></td>
                                <td><?php echo $users['email']?></td>
                                <td><?php echo $users['phone']?></td>
                                <td><?php echo $users['role']?></td>
                                <td><img style="width: 50px; height: 50px;" src="image/<?php echo $users['image']?>"></img></td>
                                <td>
                                    <button style="margin-right: 5px; border: none; width: 10px; height: 10px; border-radius: 100%; background-color: 
                                    <?php 
                                        if($users['status'] == "Đang hoạt động"){
                                            echo 'green';
                                        }
                                        else if($users['status'] == "Ngừng hoạt động"){
                                            echo 'red';
                                        }else{
                                            echo 'white';
                                        }
                                            ?>">
                                        </button>
                                        <?php echo $users['status'];?>
                                </td>
                                <td>
                                    <div class="action">
                                        <a href="update_users.php?id=<?php echo $users['idUser']; ?>" class="update_product text-decoration-none fw-bold mx-2">Cập nhật</a>
                                        <a href="remove_users.php?id=<?php echo $users['idUser'] ?>" class="remove_users fw-bold text-danger text-decoration-none" onclick="alertRemove(event, 'người dùng')">Xóa</a>

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
