<?php
session_start();
$login_success = false;
// echo ($_SESSION['id']);
if (isset($_SESSION['success'])) {
    $login_success = true;
}
unset($_SESSION['success'])
?>
<!DOCTYPE html>
<html lang="en">

<?php include "./includes/head.php" ?>

<body>
    <div id="alerts-container"></div> <!-- Container cho thông báo -->


    <?php include "./includes/header.php" ?>
    <main>
        <div class="container mt-3">
            <div class="row">
                <div class="slider w-100">
                    <div><img src="./image/banner1.jpg" alt="Slide 1" class="w-100"></div>
                    <div><img src="./image/banner2.jpg" alt="Slide 2" class="w-100"></div>
                    <div><img src="./image/banner3.jpg" alt="Slide 3" class="w-100"></div>
                </div>
            </div>
        </div>
        <section class="">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="start-item">
                            <img src="https://owen.cdn.vccloud.vn/media/amasty/ampromobanners/Artboard_2-100_210524.jpg"
                                alt>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="start-item">
                            <img src="https://owen.cdn.vccloud.vn/media/amasty/ampromobanners/Artboard_2_copy-100_210524.jpg"
                                alt>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="start-item">
                            <img src="https://owen.cdn.vccloud.vn/media/amasty/ampromobanners/Artboard_2_copy_2-100_210524.jpg"
                                alt>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="container mt-4">
            <div class="row banner-2">
                <img src="https://owen.cdn.vccloud.vn/media/codazon/slideshow/a/r/artboard_5-100_210524.jpg" alt>
            </div>
        </div>

        <section>
            <div class="container mt-3">
                <div class="row">
                    <div class="title-items">
                        <h4 class="text-center fw-bold mb-4">BÁN CHẠY
                            NHẤT</h4>
                    </div>
                    <div class="col-md-3">
                        <div class="products-item">
                            <div class="image-product">
                                <a href="#" class="image-product-links">
                                    <img src="https://owen.cdn.vccloud.vn/media/catalog/product/cache/01755127bd64f5dde3182fd2f139143a/a/p/apv231316.jpg"
                                        alt class>
                                </a>
                                <a href="#" class="btn btn_add--checkout px-4">MUA
                                    NGAY</a>
                            </div>
                            <div class="info_product mt-3">
                                <a href="#" class="text-secondary fw-bold
                                 text-decoration-none">NAME PRODUCTS - ID
                                    PRD</a>
                            </div>
                            <div class="price-product">
                                180.000 đ
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="products-item">
                            <div class="image-product">
                                <a href="#" class="image-product-links">
                                    <img src="https://owen.cdn.vccloud.vn/media/catalog/product/cache/01755127bd64f5dde3182fd2f139143a/s/w/sw231917.jpg"
                                        alt class>
                                </a>
                                <a href="#" class="btn btn_add--checkout px-4">MUA
                                    NGAY</a>
                            </div>
                            <div class="info_product mt-3">
                                <a href="#" class="text-secondary fw-bold
                                 text-decoration-none">NAME PRODUCTS - ID
                                    PRD</a>
                            </div>
                            <div class="price-product">
                                180.000 đ
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="products-item">
                            <div class="image-product">
                                <a href="#" class="image-product-links">
                                    <img src="https://owen.cdn.vccloud.vn/media/catalog/product/cache/01755127bd64f5dde3182fd2f139143a/a/p/apt231406_2_.jpg"
                                        alt class>
                                </a>
                                <a href="#" class="btn btn_add--checkout px-4">MUA
                                    NGAY</a>
                            </div>
                            <div class="info_product mt-3">
                                <a href="#" class="text-secondary fw-bold
                                 text-decoration-none">NAME PRODUCTS - ID
                                    PRD</a>
                            </div>
                            <div class="price-product">
                                180.000 đ
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="products-item">
                            <div class="image-product">
                                <a href="#" class="image-product-links">
                                    <img src="https://owen.cdn.vccloud.vn/media/catalog/product/cache/01755127bd64f5dde3182fd2f139143a/a/e/ae240008n_1.jpg"
                                        alt class>
                                </a>
                                <a href="#" class="btn btn_add--checkout px-4">MUA
                                    NGAY</a>
                            </div>
                            <div class="info_product mt-3">
                                <a href="#" class="text-secondary fw-bold
                                 text-decoration-none">NAME PRODUCTS - ID
                                    PRD</a>
                            </div>
                            <div class="price-product">
                                180.000 đ
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="banner-suit container mt-5">
            <a href="#">
                <img src="https://owen.cdn.vccloud.vn/media/amasty/ampromobanners/Artboard_7-100_210524_1.jpg" alt
                    class="w-100">
            </a>
        </div>
        <section>
            <div class="container mt-4">
                <div class="row">
                    <div class="col-md-8">
                        <div class="image-left-form">
                            <img src="https://owen.cdn.vccloud.vn/media/amasty/ampromobanners/Artboard_10-100_210524.jpg"
                                alt class="w-100">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-status px-4 p-5">
                            <h4 class="text-center fw-bold pt-4">ĐĂNG KÝ
                                NHẬN BẢN TIN</h4>
                            <p class="text-center register-text">Đừng bỏ lỡ
                                hàng ngàn sản phẩm và chương trình siêu hấp
                                dẫn</p>

                            <form action class="pb-4">
                                <div class="input-email">
                                    <input type="email" name id placeholder="Nhập email của bạn" class="w-100">
                                </div>
                                <button class="w-100 bg-dark btn text-white mt-4 fw-bold register-end mb-4">ĐĂNG
                                    KÍ</button>
                            </form>
                        </div>
                    </div>
                </div>
        </section>
    </main>

    <?php include "./includes/footer.php" ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="./js/banner.js"></script>
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

    <?php if ($login_success) : ?>
    alertSuccessfully("Đăng nhập Thành Công!");
    <?php endif; ?>
    </script>
</body>

</html>