<?php
require_once('./user.php');
$email = '';
$errors =[];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!isset($_POST['email']) || empty($_POST['email'])) {
    $errors['email'] = "Email là bắt buộc";
} else{
    $email = $_POST['email'];
}
if(count($errors) == 0){
    $isCheck = $dbHelper->select("SELECT * FROM users WHERE email = ?", [$email]);

if(!$isCheck || count($isCheck) == 0){
    $errors['email'] = "Email không tồn tại";
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
        <link rel="stylesheet" href="../css/style.css">
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
                        <h2 class="text-center fw-bold ">Quên mật khẩu?</h2>
                        <div class="d-flex justify-content-center forgot-pass">
                            <div class="forgot-main p-4">
                                    <p class="text-small">Vui lòng nhập địa chỉ email của bạn dưới đây để đặt lại mật khẩu.</p>
                                    <form action="" method="POST">
                                        <label for="" class="text-small">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email-forgot" 
                                        class="d-block w-100 value-forgot mt-1">
                                    <?php
                                        if (isset($errors['email'])) {
                                            echo "<span class='errors text-danger'>{$errors['email']}</span>";
                                        }
                                    ?>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button class="btn btn-dark btn-forgot" type="submit" name= "action" value="forgot">Đặt lại mật khẩu</button>
                                        </div>
                                    </form>
                            </div>  
                        </div>
                    </div>
                </div>
            </section>
         </main>
        

        
        <!-- footer -->
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
        <script> lucide.createIcons();</script>
        <script src="./js/script.js"></script>
    </body>

</html>
