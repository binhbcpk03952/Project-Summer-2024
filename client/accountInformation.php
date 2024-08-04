<?php
// session_start();
include_once("./DBUntil.php");
$dbHelper = new DBUntil();
$user_id = $_GET['id'];
$query = $dbHelper->select("SELECT * FROM users WHERE idUser = ?", [$user_id]);
$user = $query[0];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $newPassword = $_POST['newPassword'] ?? '';
    $newPasswordConfirm = $_POST['newPasswordConfirm'] ?? '';
    $image = $user['image'];

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "C:\\xampp\htdocs\Project-Summer-2024\admin\users\image\\";
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $IMAGE_TYPES = ['jpg', 'jpeg', 'png'];
var_dump($target_file);
        if (!in_array($imageFileType, $IMAGE_TYPES)) {
            $errors['image'] = "Image type must be JPG, JPEG, or PNG.";
        }

        if ($_FILES['profile_image']["size"] > 1000000) {
            $errors['image'] = "Image file size is too large.";
        }

        // If no errors, proceed with file upload
        if (empty($errors)) {
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                $image = htmlspecialchars(basename($_FILES["profile_image"]["name"]));
            } else {
                $errors['image'] = "Sorry, there was an error uploading your file.";
            }
        }
    }

    if (!empty($newPassword) && $newPassword == $newPasswordConfirm) {
        $password = $newPassword;
    }

    $data = [
        'name' => $name,
        'username' => $username,
        'email' => $email,
        'phone' => $phone,
        'password' => $password,
        'image' => $image
    ];

    $condition = "idUser = :idUser";
    $params = ['idUser' => $user_id];

    $update_query = $dbHelper->update('users', $data, $condition, $params);

    if ($update_query) {
        header('Location: accountInformation.php?id=' . $user_id);
        exit();
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
        <main>
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"
                                class="nav-link">Trang chủ</a></li>
                        <li class="breadcrumb-item active"
                            aria-current="page">Tài khoản</li>
                    </ol>
                </nav>
            </div>

            <div class="container form">
            <div class="row">
                <div class="col-md-3 mt-1">
                    <div class="aside-account mt-4">
                        <h2 class="fw-bold fs-3">TÀI KHOẢN</h2>
                        <ul class="mx-3 aside-list">
                            <li class="nav-link">
                                <a href="#" class="text-decoration-none aside-account-list focus-in">Thông tin tài khoản</a>
                            </li>
                            <li class="nav-link">
                                <a href="#" class="text-decoration-none aside-account-list">Địa chỉ</a>
                            </li>
                            <li class="nav-link">
                                <a href="#" class="text-decoration-none aside-account-list">Quản lí đơn hàng</a>
                            </li>
                            <li class="nav-link">
                                <a href="#" class="text-decoration-none aside-account-list">Danh sách yêu thích</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-login">
                        <form action="" class="mt-4" method="POST" enctype="multipart/form-data">
                            <div class="name-value">
                                <img src="../admin/users/image/<?php echo htmlspecialchars($user['image']); ?>" alt="Profile Image" style="border-radius:50%; width: 150px; height: 150px">
                                <input type="file" name="profile_image" id="profile_image" accept="./image/">
                            </div>
                            <br>
                            <div class="name-value">
                                <label for="name" class="form-label m-0">Tên <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="value-forgot d-block w-100" value="<?php echo htmlspecialchars($user['name']); ?>">
                            </div>
                            <div class="username-value mt-4">
                                <label for="username" class="form-label m-0">Tên đăng nhập <span class="text-danger">*</span></label>
                                <input type="text" name="username" id="username" class="value-forgot d-block w-100" value="<?php echo htmlspecialchars($user['username']); ?>">
                            </div>
                            <div class="email-value mt-4">
                                <label for="email" class="form-label m-0">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="value-forgot d-block w-100" value="<?php echo htmlspecialchars($user['email']); ?>">
                            </div>
                            <div class="number-phone mt-4">
                                <label for="phone" class="form-label m-0 d-block">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" name="phone" id="phone" class="value-forgot d-block w-100" value="<?php echo htmlspecialchars($user['phone']); ?>">
                            </div>
                           
                                    <span class="change-password" onclick="changePassword()">Đặt lại mật khẩu?</span>
                                </div>
                               
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
                        </form>
                    </div>
                </div>
                <div class="col-md-3">
                </div>
            </div>
        </div>
    </main>
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
