<?php
    include_once ("./DBUntil.php");
    $dbHelper = new DBUntil();
    function isVietnamesePhoneNumber($number){
        return preg_match('/^(03|05|07|08|09|01[2689])[0-9]{8}$/', $number) === 1;
    }
    function ischeckmail($email){
        $dbHelper = new DBUntil();
        $emailExists = $dbHelper->select("SELECT email FROM users WHERE email = ?", [$email]);
        return count($emailExists) > 0;
    }
    function ischeckUsername($username){
        $dbHelper = new DBUntil();
        $UsernameExists = $dbHelper->select("SELECT username FROM users WHERE username = ?", [$username]);
        return count($UsernameExists) > 0;
    }
    function ischeckPhone($phone){
        $dbHelper = new DBUntil();
        $PhoneExists = $dbHelper->select("SELECT phone FROM users WHERE phone = ?", [$phone]);
        return count($PhoneExists) > 0;
    }
    $errors = [];
    $email = "";
    $username = "";
    $password = "";
    $name = "";
    $phone = "";
    $passwordConfirm = "";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_POST['name']) || empty($_POST['name'])) {
            $errors['name'] = "Tên là bắt buộc";
        } else {
            $name = $_POST['name'];
        }
        if (!isset($_POST['username']) || empty($_POST['username'])) {
            $errors['username'] = "Tên đăng nhập là bắt buộc";
        }else {
            if (ischeckUsername($_POST["username"])) {
                $errors['username'] = "Tên đăng nhập đã tồn tại";
            } else {
                $username = $_POST['username'];
            }
        }
        if (!isset($_POST['email']) || empty($_POST['email'])) {
            $errors['email'] = "Email là bắt buộc";
        } else {
            if (ischeckmail($_POST["email"])) {
                $errors['email'] = "Email đã tồn tại";
            } else {
                $email = $_POST['email'];
            }
        }
        if (!isset($_POST['password']) || empty($_POST['password'])) {
            $errors['password'] = "Mật khẩu là bắt buộc";
        } elseif (strlen($_POST['password']) < 6) {
            $errors['password'] = "Mật khẩu phải có độ dài ít nhất 6 ký tự.";
        } else {
            $password = $_POST['password'];
        }
        if (!isset($_POST['passwordConfirm']) || empty($_POST['passwordConfirm'])) {
            $errors['passwordConfirm'] = "Xác nhận mật khẩu là bắt buộc";
        } elseif (strlen($_POST['passwordConfirm']) < 6) {
            $errors['passwordConfirm'] = "Mật khẩu phải có độ dài ít nhất 6 ký tự.";
        }elseif($_POST['passwordConfirm'] != $password){
            $errors['passwordConfirm'] = "Xác nhận mật khẩu không đúng";
        }else {
            $passwordConfirm = $_POST['passwordConfirm'];
        }
        if (!isset($_POST['phone']) || empty($_POST['phone'])) {
            $errors['phone'] = "Số điện thoại là bắt buộc";
        } else {
            if (!isVietnamesePhoneNumber($_POST['phone'])) {
                $errors['phone'] = "Số điện thoại không được định dạng chính xác";
            }else {
                if (ischeckPhone($_POST["phone"])) {
                    $errors['phone'] = "Số điện thoại đã tồn tại"; 
                }else {
                $phone = $_POST['phone'];
                }
            }
        if (!isset($_POST['term']) || empty($_POST['term'])) {
            $errors['term'] = "Điều khoản là bắt buộc";
        }
    }

        // If no errors, insert data into the database
    if (empty($errors)) {
        $data = [
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'phone' => $phone,
        ];
        
        $isCreate = $dbHelper->insert('users', $data);

        if ($isCreate) {
            // Redirect to the same page to see the new record in the table
            header("Location: " . $_SERVER['PHP_SELF']);
            echo "<script>alert('Đăng ký tài khoản thành công!');</script>";
            exit();
        } else {
            $errors['database'] = "Failed to create new user";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Princes</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
            crossorigin="anonymous">
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <header>
            <div
                class="header container d-flex justify-content-between align-items-center py-3">
                <div class="logo-image">
                    <a href="index.html">
                        <img src="./image/logo.png" alt>
                    </a>
                </div>
                <nav>
                    <ul class="d-flex justify-content-between">
                        <li class="nav-link mx-3"><a href="#"
                                class="nav-items">HÀNG MỚI</a></li>
                        <li class="nav-link mx-3"><a href="#"
                                class="nav-items">ÁO</a></li>
                        <li class="nav-link mx-3"><a href="#"
                                class="nav-items">QUẦN</a></li>
                        <li class="nav-link mx-3"><a href="#"
                                class="nav-items">PHỤ KIỆN</a></li>
                        <li class="nav-link mx-3"><a href="#"
                                class="nav-items">GIÁ TỐT</a></li>
                        <li class="nav-link mx-3"><a href="#"
                                class="nav-items">CỬA HÀNG</a></li>
                    </ul>
                </nav>
                <div class="header-search">
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-search">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                    </button>
                    <input type="search" name="search" class="search"
                        placeholder="Bạn tìm gì...">
                </div>
                <div class="cart-user">
                    <ul class="d-flex justify-content-between ">
                        <li class="nav-link mx-2">
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="30" height="30" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor"
                                    stroke-width="1" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-heart">
                                    <path
                                        d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                                </svg>
                            </a>
                        </li>
                        <li class="nav-link mx-2">
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="30" height="30" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor"
                                    stroke-width="1" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-shopping-bag">
                                    <path
                                        d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" />
                                    <path d="M3 6h18" />
                                    <path d="M16 10a4 4 0 0 1-8 0" />
                                </svg>
                            </a>
                        </li>
                        <li class="nav-link mx-2">
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="32" height="32" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor"
                                    stroke-width="1" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-user-round">
                                    <circle cx="12" cy="8" r="5" />
                                    <path d="M20 21a8 8 0 0 0-16 0" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="container-fluid p-0">
                <div
                    class="d-flex justify-content-center align-items-center header-outstanding">
                    <p class="link-cate m-2 fw-bold">BE CONFIDENT - <a
                            href="#">OUT NOW</a></p>
                </div>
            </div>
        </header>
        <main>
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"
                                class="nav-link">Trang chủ</a></li>
                        <li class="breadcrumb-item active"
                            aria-current="page">Đăng kí</li>
                    </ol>
                </nav>
            </div>

            <div class="container form">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-login">
                            <h2 class="fs-3 fw-bold">ĐĂNG KÍ</h2>
                            <p>Đăng kí để có những trải nghiệm tốt nhất của
                                cửa
                                hàng chúng tôi</p>

                            <form action="" class="mt-4" method="POST">
                                <div class="name-value">
                                    <label for class="form-label m-0">Tên <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name"
                                        class="input-value d-block w-100">
                                    <?php
                                        if (isset($errors['name'])) {
                                            echo "<span class='errors text-danger'>{$errors['name']}</span>";
                                        }
                                    ?>
                                </div>
                                <div class="username-value mt-4">
                                    <label for class="form-label m-0">Tên đăng nhập <span class="text-danger">*</span></label>
                                    <input type="text" name="username" id="username"
                                        class="input-value d-block w-100">
                                        <?php
                                        if (isset($errors['username'])) {
                                            echo "<span class='errors text-danger'>{$errors['username']}</span>";
                                        }
                                    ?>
                                </div>
                                <div class="email-value mt-4">
                                    <label for class="form-label m-0">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email"
                                        class="input-value d-block w-100">
                                        <?php
                                        if (isset($errors['email'])) {
                                            echo "<span class='errors text-danger'>{$errors['email']}</span>";
                                        }
                                    ?>
                                </div>
                                <div class="password-value mt-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for class="form-label m-0">Mật khẩu <span class="text-danger">*</span></label>
                                            <input type="password" name="password" id="password"
                                                class="input-value d-block w-100">
                                                <?php
                                        if (isset($errors['password'])) {
                                            echo "<span class='errors text-danger'>{$errors['password']}</span>";
                                        }
                                    ?>
                                        </div>
                                        <div class="col-md-6">
                                                <label for class="form-label m-0">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                                <input type="password" name="passwordConfirm" id="passwordCofirm"
                                                    class="input-value d-block w-100">
                                                    <?php
                                        if (isset($errors['passwordConfirm'])) {
                                            echo "<span class='errors text-danger'>{$errors['passwordConfirm']}</span>";
                                        }
                                    ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="number-phone mt-4">
                                    <label for class="form-label m-0 d-block">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" id="phone"
                                        class="input-value d-block w-100">
                                        <?php
                                        if (isset($errors['phone'])) {
                                            echo "<span class='errors text-danger'>{$errors['phone']}</span>";
                                        }
                                    ?>
                                </div>
                                <div class="terms mt-3">
                                    <input type="checkbox" name="term" id="term">
                                    <label for="">Tôi đã đọc và đồng ý với các <a href="#" class="text-decoration-none ">điều khoản</a></label>
                                    <?php
                                        if (isset($errors['term'])) {
                                            echo "<span class='errors text-danger d-block'>{$errors['term']}</span>";
                                        }
                                    ?>
                                </div>
                                <button class="btn btn-dark w-100 btn-submit mt-4">ĐĂNG KÍ</button>
                            </form>
                            <div class="text-end mt-1">
                                <p>Bạn đã có tài khoản? <a href="login.php  " class="text-decoration-none">Đăng nhập</a></p>
                            </div>
                               
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_login--image">
                            <img src="./image/image-in-form.jpeg" alt
                                class="w-100">
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer class="mt-3">
            <hr class="m-0">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="address">
                            <div class="logo-image">
                                <a href="index.html">
                                    <img src="./image/logo.png" alt
                                        class="py-3">
                                </a>
                            </div>
                            <div class="info-footer">
                                <p class="m-0 fw-bold">CÔNG TY CỔ PHẦN THỜI
                                    TRANG PRINCES VIỆT NAM</p>
                                <p><span class="fw-bold">Hotline</span>: 1900
                                    1000</p>
                            </div>
                            <div class="address-footer">
                                <p class="m-0"><span class="fw-bold">VP Phía
                                        Bắc</span>: Tầng 17 tòa nhà Viwaseen, 48
                                    Phố Tố Hữu, Trung Văn, Nam Từ Liêm,
                                    Hà Nội.</p>
                                <p><span class="fw-bold">VP Phía Nam</span>:
                                    186A Nam Kỳ Khởi Nghĩa, Phường Võ Thị Sáu,
                                    Quận 3, TP.HCM</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mt-5">
                        <div class="footer-items mt-5">
                            <h5 class="fs-6 fw-bold">GIỚI THIỆU VỀ PRINCES</h5>
                            <ul>
                                <li class="nav-link">
                                    <a href="#">Giới thiệu</a>
                                </li>
                                <li class="nav-link">
                                    <a href="#">BLog</a>
                                </li>
                                <li class="nav-link">
                                    <a href="#">Hệ thống cửa hàng</a>
                                </li>
                                <li class="nav-link">
                                    <a href="#">Liên hệ Princes</a>
                                </li>
                                <li class="nav-link">
                                    <a href="#">Chính sách bảo mật</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 mt-5">
                        <div class="footer-items mt-5">
                            <h5 class="fs-6 fw-bold">HỖ TRỢ KHÁCH HÀNG</h5>
                            <ul>
                                <li class="nav-link">
                                    <a href="#">Hỏi đáp</a>
                                </li>
                                <li class="nav-link">
                                    <a href="#">Chính sách vận chuyển</a>
                                </li>
                                <li class="nav-link">
                                    <a href="#">Hướng dẫn chọn kích cỡ</a>
                                </li>
                                <li class="nav-link">
                                    <a href="#">Hướng dẫn thanh toán</a>
                                </li>
                                <li class="nav-link">
                                    <a href="#">Quy định đổi hàng</a>
                                </li>
                                <li class="nav-link">
                                    <a href="#">Hướng dẫn mua hàng</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 mt-5">
                        <div class="footer-items mt-5">
                            <h5 class="fs-6 fw-bold">KẾT NỐI</h5>
                            <div class="face-ins d-flex">
                                <a href="#" class="nav-link ml-2">
                                    <i class="fa-brands fa-facebook fs-4"></i>
                                </a>
                                <a href="#" class="nav-link ms-2">
                                    <i class="fa-brands fa-instagram fs-4"></i>
                                </a>
                                <a href="#" class="nav-link ms-2">
                                    <i class="fa-brands fa-youtube fs-4"></i>
                                </a>
                            </div>
                            <h5 class="fs-6 fw-bold my-3">PHƯƠNG THỨC THANH
                                TOÁN</h5>
                            <div class="checkout">
                                <img
                                    src="https://owen.cdn.vccloud.vn/static/version1718818632/frontend/Owen/owen2021/vi_VN/images/pay.png"
                                    alt>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <script src="https://kit.fontawesome.com/121f50087c.js"
            crossorigin="anonymous"></script>
        <script src="https://unpkg.com/lucide@latest"></script>
        <script>
            lucide.createIcons();
        </script>
    </body>

</html>
