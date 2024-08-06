<?php
    include_once ("./DBUntil.php");
    $dbHelper = new DBUntil();

    session_start();

    $errors = [];
    $email = "";
    $password = "";
    if (isset($_SERVER['HTTP_REFERER'])) {
        $previous_url = $_SERVER['HTTP_REFERER'];
        echo "Previous page URL: " . $previous_url;
    } else {
        echo "No referrer URL detected.";
    }

   

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_POST['email']) || empty($_POST['email'])) {
            $errors['email'] = "Email hoặc tên đăng nhập là bắt buộc";
        } else {
            $email = $_POST['email'];
        }

        if (!isset($_POST['password']) || empty($_POST['password'])) {
            $errors['password'] = "Mật khẩu là bắt buộc";
        } elseif (strlen($_POST['password']) < 6) {
            $errors['password'] = "Mật khẩu phải có độ dài ít nhất 6 ký tự.";
        } else {
            $password = $_POST['password'];
        }

        if (count($errors) == 0) {
            $query = $dbHelper->select("SELECT * FROM users");
            // var_dump($query);
            if (count($query) > 0) {
                foreach ($query as $query) {
                    if (($query['email'] == $email && $query['password'] == $password) || 
                        ($query['username'] == $email && $query['password'] == $password)) {
                        // Redirect user after successful login
                        $_SESSION['id'] = $query['idUser'];
                        $_SESSION['success'] = true;
                        // echo $_SESSION['id'];
                        if ($previous_url = "http://localhost/project-summer-2024/client/shop.php") {
                            header('Location: http://localhost/project-summer-2024/client/shop.php');
                        }
                        else {
                            header('Location: index.php');
                            exit();
                        }

                    } else {
                        $errors['login'] = "Sai Tên đăng nhập hoặc Mật khẩu.";
                    }
                }
            } else {
                $errors['login'] = "Sai Tên đăng nhập hoặc Mật khẩu.";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <div class="header container d-flex justify-content-between align-items-center py-3">
            <div class="logo-image">
                <a href="index.html">
                    <img src="./image/logo.png" alt>
                </a>
            </div>
            <nav>
                <ul class="d-flex justify-content-between">
                    <li class="nav-link mx-3"><a href="#" class="nav-items">HÀNG MỚI</a></li>
                    <li class="nav-link mx-3"><a href="#" class="nav-items">ÁO</a></li>
                    <li class="nav-link mx-3"><a href="#" class="nav-items">QUẦN</a></li>
                    <li class="nav-link mx-3"><a href="#" class="nav-items">PHỤ KIỆN</a></li>
                    <li class="nav-link mx-3"><a href="#" class="nav-items">GIÁ TỐT</a></li>
                    <li class="nav-link mx-3"><a href="#" class="nav-items">CỬA HÀNG</a></li>
                </ul>
            </nav>
            <div class="header-search">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-search">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                </button>
                <input type="search" name="search" class="search" placeholder="Bạn tìm gì...">
            </div>
            <div class="cart-user">
                <ul class="d-flex justify-content-between ">
                    <li class="nav-link mx-2">
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-heart">
                                <path
                                    d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                            </svg>
                        </a>
                    </li>
                    <li class="nav-link mx-2">
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-shopping-bag">
                                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" />
                                <path d="M3 6h18" />
                                <path d="M16 10a4 4 0 0 1-8 0" />
                            </svg>
                        </a>
                    </li>
                    <li class="nav-link mx-2">
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-user-round">
                                <circle cx="12" cy="8" r="5" />
                                <path d="M20 21a8 8 0 0 0-16 0" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="container-fluid p-0">
            <div class="d-flex justify-content-center align-items-center header-outstanding">
                <p class="link-cate m-2 fw-bold">BE CONFIDENT - <a href="#">OUT NOW</a></p>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html" class="nav-link">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Đăng nhập</li>
                </ol>
            </nav>
        </div>

        <div class="container form">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-login">
                        <h2 class="fs-3 fw-bold">ĐĂNG NHẬP</h2>
                        <p>Đăng nhập để có những trải nghiệm tốt nhất của
                            cửa
                            hàng chúng tôi</p>

                        <form action="" class="mt-4" method="POST">
                            <div class="email-phone">
                                <label for class="form-label m-0">Email hoặc Tên đăng nhập<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="email" id="email" class="input-value d-block w-100">
                                <?php
                                        if (isset($errors['email'])) {
                                            echo "<span class='errors text-danger'>{$errors['email']}</span>";
                                        }
                                    ?>
                            </div>
                            <div class="password-login mt-4">
                                <label for class="form-label m-0">Mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" class="input-value d-block w-100">

                                <i class="fa-regular fa-eye show-password d-block" onmousedown="showPassword()"
                                    onmouseup="endPass()" onmouseleave="endPass()"></i>
                                    <?php
                                        if (isset($errors['password'])) {
                                            echo "<span class='errors text-danger'>{$errors['password']}</span>";
                                        }
                                    ?>
                            </div>
                            <div class="forgot-pass text-end mt-3">
                                <a href="forgotPassword/forgotPassword.php" class="text- text-decoration-none text-warning">
                                    Quên mật khẩu?
                                </a>
                            </div>
                            <button class="btn btn-dark w-100 btn-submit">ĐĂNG NHẬP</button>
                            <?php
                                if (isset($errors['login'])) {
                                    echo "<span class='text-danger mt-2 d-block'>{$errors['login']}</span>";
                                }
                            ?>
                        </form>
                        <?php
                            require_once 'php-google-login/google-login.php';
                        ?>
                        <a href="register.php" class="text-decoration-none text-dark d-block text-center add-account mt-5">
                            TẠO TÀI KHOẢN
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form_login--image">
                        <img src="./image/image-in-form.jpeg" alt class="w-100">
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
                                <img src="./image/logo.png" alt class="py-3">
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
                            <img src="https://owen.cdn.vccloud.vn/static/version1718818632/frontend/Owen/owen2021/vi_VN/images/pay.png"
                                alt>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://kit.fontawesome.com/121f50087c.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
    lucide.createIcons();
    </script>
    <script src="https://accounts.google.com/gsi/client" async></script>
    <script src="./js/main.js"></script>
</body>

</html>