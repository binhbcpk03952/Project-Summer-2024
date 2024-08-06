<?php
session_start();
include_once("./DBUntil.php");
$dbHelper = new DBUntil();
$user_id = $_GET['id'];
$query = $dbHelper->select("SELECT * FROM users WHERE idUser = ?", [$user_id]);
$user = $query[0];
$errors = [];
function ischeckmail($email, $user_id) {
    global $dbHelper;
    $result = $dbHelper->select("SELECT email FROM users WHERE email = ? AND idUser != ?", [$email, $user_id]);
    return count($result) > 0;
}

// Function to validate Vietnamese phone numbers
function isVietnamesePhoneNumber($number) {
    return preg_match('/^(03|05|07|08|09|01[2689])[0-9]{8}$/', $number) === 1;
}

// Function to check if username exists in the database for a different user
function ischeckUsername($username, $user_id) {
    global $dbHelper;
    $result = $dbHelper->select("SELECT username FROM users WHERE username = ? AND idUser != ?", [$username, $user_id]);
    return count($result) > 0;
}

// Function to check if phone number exists in the database for a different user
function ischeckPhone($phone, $user_id) {
    global $dbHelper;
    $result = $dbHelper->select("SELECT phone FROM users WHERE phone = ? AND idUser != ?", [$phone, $user_id]);
    return count($result) > 0;
} 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $image = $user['image'];
    if (!isset($_POST['name']) || empty($_POST['name'])) {
        $errors['name'] = "Tên là bắt buộc";
    } else {
        $name = $_POST['name'];
    }
    if (!isset($_POST['username']) || empty($_POST['username'])) {
        $errors['username'] = "Tên đăng nhập là bắt buộc";
    } else {
        if (ischeckUsername($_POST["username"], $user_id)) {
            $errors['username'] = "Tên đăng nhập đã tồn tại";
        } else {
            $username = $_POST['username'];
        }
    }

    if (!isset($_POST['email']) || empty($_POST['email'])) {
        $errors['email'] = "Email là bắt buộc";
    } else {
        if (ischeckmail($_POST["email"], $user_id)) {
            $errors['email'] = "Email đã tồn tại";
        } else {
            $email = $_POST['email'];
        }
    }
    if (!isset($_POST['phone']) || empty($_POST['phone'])) {
        $errors['phone'] = "Số điện thoại là bắt buộc";
    } else {
        if (!isVietnamesePhoneNumber($_POST['phone'])) {
            $errors['phone'] = "Số điện thoại không được định dạng chính xác";
        } else {
            if (ischeckPhone($_POST["phone"], $user_id)) {
                $errors['phone'] = "Số điện thoại đã tồn tại";
            } else {
                $phone = $_POST['phone'];
            }
        }
    }
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "C:\\xampp\htdocs\Project-Summer-2024\admin\users\image\\";
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $IMAGE_TYPES = ['jpg', 'jpeg', 'png'];
// var_dump($target_file);
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
    if(empty($errors)){
        $data = [
        'name' => $name,
        'username' => $username,
        'email' => $email,
        'phone' => $phone,
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
                                <?php
                                    if(isset($errors['name'])) {
                                        echo "<span class='text-danger'>$errors[name] </span>";
                                    }
                                ?>
                            </div>
                            <div class="username-value mt-4">
                                <label for="username" class="form-label m-0">Tên đăng nhập <span class="text-danger">*</span></label>
                                <input type="text" name="username" id="username" class="value-forgot d-block w-100" value="<?php echo htmlspecialchars($user['username']); ?>">
                                <?php
                                    if(isset($errors['username'])) {
                                        echo "<span class='text-danger'>$errors[username] </span>";
                                    }
                                ?>
                            </div>
                            <div class="email-value mt-4">
                                <label for="email" class="form-label m-0">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="value-forgot d-block w-100" value="<?php echo htmlspecialchars($user['email']); ?>">
                                <?php
                                    if(isset($errors['email'])) {
                                        echo "<span class='text-danger'>$errors[email] </span>";
                                    }
                                ?>
                            </div>
                            <div class="number-phone mt-4">
                                <label for="phone" class="form-label m-0 d-block">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" name="phone" id="phone" class="value-forgot d-block w-100" value="<?php echo htmlspecialchars($user['phone']); ?>">
                                <?php
                                    if(isset($errors['phone'])) {
                                        echo "<span class='text-danger'>$errors[phone] </span>";
                                    }
                                ?>
                            </div>
                            <a href="table_password.php?id=<?php echo $user_id ?>" class="change-password  text-decoration-none text-warning mt-4 d-block">Đặt lại mật khẩu ? </a>
                                    <!-- <span class="change-password" onclick="changePassword()">Đặt lại mật khẩu?</span> -->
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
