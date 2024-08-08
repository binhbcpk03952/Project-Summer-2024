
<?php
session_start();
include_once("./DBUntil.php");
$dbHelper = new DBUntil();
$user_id = $_GET['id'];
$users = $dbHelper->select("SELECT * FROM users WHERE idUser = ?", [$user_id]);
$userPassword = $users[0]['password'];
// var_dump($userPassword);
$errors =[];
$newPassword = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['password']) || empty($_POST['password'])) {
        $errors['password'] = "Mật không cũ là bắt buộc";
    }else if($_POST['password'] != $userPassword){
        $errors['password'] = "Mật không cũ không đúng";
    }
    if (!isset($_POST['newPassword']) || empty($_POST['newPassword'])) {
        $errors['newPassword'] = "Mật khẩu mới là bắt buộc";
    } else if (strlen($_POST['newPassword']) < 6) {
      $errors['newPassword'] = "Mật khẩu mới phải lớn hơn 6 kí tự";
    }
    if (!isset($_POST['passConfirm-forgot']) || empty($_POST['passConfirm-forgot'])) {
        $errors['passConfirm-forgot'] = "Xác nhận mật khẩu là bắt buộc";
    } elseif($_POST['passConfirm-forgot'] != $_POST['newPassword']){
        $errors['passConfirm-forgot'] = "Xác nhận mật khẩu không đúng";
    }elseif (strlen($_POST['passConfirm-forgot']) < 6) {
        $errors['passConfirm-forgot'] = "Xác nhận mật khẩu phải lớn hơn 6 kí tự";
    }

    if (empty($errors)) {
        $newPassword = $_POST['newPassword'];
        $updatePassword = $dbHelper->update('users', array('password'=>$newPassword), "idUser = '$user_id'");
            if ($updatePassword) {
                $_SESSION['success'] = true;
                header('Location: ./accountInformation.php?id=' . $user_id);
            }
    }
}

?>
<?php include "./includes/head.php" ?>

<!-- Tải jQuery trước mã JavaScript của bạn -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="./js/ajax.js"></script> 
<script src="./js/script.js"></script>

<body>
    <?php include "./includes/header.php" ?>
        <!-- banner -->
        <div class="container mt-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"
                            class="nav-link">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tài khoản</li>
                </ol>
            </nav>
        </div>
        <!-- main  -->
         <main>
            <section id="forgotPassword">
                <div class="container">
                    <div class="row">
                        <h2 class="text-center fw-bold mb-4">Đặt lại mật khẩu</h2>
                        <div class="d-flex justify-content-center forgot-pass mb-4">
                            <div class="forgot-main p-4">
                                    <form action="" method="POST" class="">
                                        <div>
                                            <label for="" class="text-small">Nhập mật khẩu cũ<span class="text-danger">*</span></label>
                                            <input type="password" name="password" id="password" 
                                            class="d-block w-100 value-forgot mt-1">
                                            <i class="fa-regular fa-eye show-password d-none" onmousedown="showPassword(this)" onmouseup="endPass(this)" onmouseleave="endPass(this)"></i>
                                            <?php
                                                 if (isset($errors['password'])) {
                                                    echo "<span class='errors text-danger'>{$errors['password']}</span>";
                                                }
                                            ?>
                                        </div>
                                        <div class="mt-3">
                                            <label for="" class="text-small">Mật khẩu mới <span class="text-danger">*</span></label>
                                            <input type="Password" name="newPassword" id="newPassword" 
                                            class="d-block w-100 value-forgot mt-1">
                                            <i class="fa-regular fa-eye show-password d-none" onmousedown="showPassword(this)" onmouseup="endPass(this)" onmouseleave="endPass(this)"></i>
                                            <?php
                                                 if (isset($errors['newPassword'])) {
                                                    echo "<span class='errors text-danger'>{$errors['newPassword']}</span>";
                                                }
                                            ?>
                                        </div>
                                        <div class="mt-3">
                                            <label for="" class="text-small">Nhập lại mật khẩu mới <span class="text-danger">*</span></label>
                                            <input type="password" name="passConfirm-forgot" id="passConfirm-forgot" oninput="change(this)"
                                            class="d-block w-100 value-forgot mt-1">
                                            <i class="fa-regular fa-eye show-password d-none" onmousedown="showPassword(this)" onmouseup="endPass(this)" onmouseleave="endPass(this)"></i>
                                            <?php
                                                 if (isset($errors['passConfirm-forgot'])) {
                                                    echo "<span class='errors text-danger'>{$errors['passConfirm-forgot']}</span>";
                                                }
                                            ?>
                                        </div>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button class="btn btn-dark btn-forgot" type="submit" name= "action" value="reset">Đặt lại mật khẩu</button>
                                        </div>
                                    </form>
                            </div>  
                        </div>
                    </div>
                </div>
            </section>
         </main>
             <!-- <form action="" method="post">
         <div class="load-change">
                            <div class="password-value password-login mt-4">
                                <div class="justify-content-between">
                                    <label for="password" class="form-label m-0 d-block">Mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="value-forgot d-block w-100 password" oninput="change(this)" value="<?php echo htmlspecialchars($user['password']); ?>" require>
                                    <i class="fa-regular fa-eye show-password d-none" onmousedown="showPassword(this)" onmouseup="endPass(this)" onmouseleave="endPass(this)"></i>
                                </div>
                            </div>      
                                <div class="new-password password-login mt-4">
                                    <label for="newPassword" class="form-label m-0">Mật khẩu mới<span class="text-danger">*</span></label>
                                    <input type="password" name="newPassword" id="newPassword" class="value-forgot d-block w-100 password" oninput="change(this)">
                                    <i class="fa-regular fa-eye show-password d-none" onmousedown="showPassword(this)" onmouseup="endPass(this)" onmouseleave="endPass(this)"></i>
                                </div>
                                <div class="new-passwordConfirm password-login mt-4">
                                    <label for="newPasswordConfirm" class="form-label m-0">Nhập lại mật khẩu mới<span class="text-danger">*</span></label>
                                    <input type="password" name="newPasswordConfirm" id="newPasswordConfirm" class="value-forgot d-block w-100 password" oninput="change(this)">
                                    <i class="fa-regular fa-eye show-password d-none" onmousedown="showPassword(this)" onmouseup="endPass(this)" onmouseleave="endPass(this)"></i>
                                </div>
                            </div>
                            <button class="btn btn-dark w-100 btn-submit mt-4">CẬP NHẬT</button>
                        </form> -->

        
        <!-- footer -->
        <?php include "./includes/footer.php" ?>
        <script src="https://kit.fontawesome.com/121f50087c.js"
            crossorigin="anonymous"></script>
        <script src="https://unpkg.com/lucide@latest"></script>
        <script>
            lucide.createIcons();
        </script>
        <script src="js/script.js"></script>
        <script src="./js/main.js"></script>
        <!-- <script src="js/main.js"></script> -->
    </body>

</html>
                                                