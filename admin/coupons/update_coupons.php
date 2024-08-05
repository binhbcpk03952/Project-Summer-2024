<?php
include "../../client/DBUntil.php";
$dbHelper = new DBUntil();

$id = $_GET['id'];
$coupons = $dbHelper->select("SELECT * FROM coupons WHERE idCoupon = ?", [$id])[0];
// Function to check if email exists in the database for a different user
function ischeckCode($code, $id) {
    global $dbHelper;
    $result = $dbHelper->select("SELECT code FROM coupons WHERE code = ? AND idCoupon != ?", [$code, $id]);
    return count($result) > 0;
}
    $errors = [];
    $name = "";
    $code = "";
    $quantity = "";
    $discount = "";
    $startDate = "";
    $endDate = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_POST['name']) || empty($_POST['name'])) {
            $errors['name'] = "Tên là bắt buộc";
        } else {
            $name = $_POST['name'];
        }
        if (!isset($_POST['code']) || empty($_POST['code'])) {
            $errors['code'] = "Mã giảm giá là bắt buộc";
        }else {
            if (ischeckCode($_POST["code"] , $id) ) {
                $errors['code'] = "Mã giảm giá đã tồn tại";
            } else {
                $code = $_POST['code'];
            }
        }
        if (!isset($_POST['quantity']) || empty($_POST['quantity'])) {
            $errors['quantity'] = "Số lượng là bắt buộc";
        }else if ($_POST['quantity'] < 0) {
            $errors['quantity'] = "Số lượng phải lớn hơn 0";
        }
         else {
                $quantity = $_POST['quantity'];
            }
        
        if (!isset($_POST['discount']) || empty($_POST['discount'])) {
            $errors['discount'] = "Giảm giá là bắt buộc";
        }else if ($_POST['discount'] < 0) {
            $errors['discount'] = "Giảm giá phải lớn hơn 0";
        }
         else {
            $discount = $_POST['discount'];
        }
        if (!isset($_POST['startDate']) || empty($_POST['startDate'])) {
            $errors['startDate'] = "Ngày là bắt buộc";
        } else {
                $startDate = $_POST['startDate'];
            }
        if (!isset($_POST['endDate']) || empty($_POST['endDate'])) {
            $errors['endDate'] = "Ngày là bắt buộc";
        } else {
            $endDate = $_POST['endDate'];
        }
    if (empty($errors)) {
        $data = [
            'name' => $name,
            'code' => $code,
            'discount' => $discount,
            'quantity' => $quantity,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];
            $isUpdate = $dbHelper->update("coupons", $data, "idCoupon = $id");   
        if ($isUpdate) {
            header("Location: list.php");
            exit();
        } 
    }
}
      
      // var_dump($isUpdate);
        
    

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
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <h1 class="mt-4">Cập nhật Mã giảm giá</h1>
                            <span name ="database" class="text-danger fs-5">
                                <?php
                                    if(isset($errors['database'])) {
                                        echo $errors['database'];
                                    }
                                ?>
                            </span>
                            <form action="" method="POST" >
                                <div class="name mb-3" >
                                    <label for="">Tên mã khuyến mãi</label>
                                    <input type="text" name="name"
                                        id="name" class="form-control" value ="<?= htmlspecialchars($coupons['name']) ?>">
                                        <?php
                                            if(isset($errors['name'])) {
                                                echo "<span class='text-danger'>$errors[name] </span>";
                                            }
                                        ?>
                                </div>
                                <div class="code mb-3">
                                    <label for="">Mã khuyến mãi</label>
                                    <input type="text" name="code"
                                        id="code" class="form-control" value ="<?= htmlspecialchars($coupons['code']) ?>">
                                        <?php
                                            if(isset($errors['code'])) {
                                                echo "<span class='text-danger'>$errors[code] </span>";
                                            }
                                        ?>
                                </div>
                                <div class="email mb-3">
                                    <label for="">Số lượng mã giảm giá</label>
                                    <input type="number" name="quantity"
                                        id="quantity" class="form-control" value ="<?= htmlspecialchars($coupons['quantity']) ?>">
                                        <?php
                                            if(isset($errors['quantity'])) {
                                                echo "<span class='text-danger'>$errors[quantity] </span>";
                                            }
                                        ?>
                                </div>
                                <div class="discount mb-3">
                                    <label for="">Phần trăm giảm giá</label>
                                    <input type="number" name="discount"
                                        id="discount" class="form-control" value ="<?= htmlspecialchars($coupons['discount']) ?>">
                                        <?php
                                            if(isset($errors['discount'])) {
                                                echo "<span class='text-danger'>$errors[discount] </span>";
                                            }
                                        ?>
                                </div>
                                <div class="startDate mb-3">
                                    <label for="">Ngày bắt đầu</label>
                                    <input type="text" name="startDate"
                                        id="startDate" class="form-control" value ="<?= htmlspecialchars($coupons['startDate']) ?>">
                                        <?php
                                            if(isset($errors['startDate'])) {
                                                echo "<span class='text-danger'>$errors[startDate] </span>";
                                            }
                                        ?>
                                </div>
                                <div class="endDate mb-3">
                                    <label for="">Ngày kết thúc</label>
                                    <input type="text" name="endDate" id="endDate" class="form-control" value ="<?= htmlspecialchars($coupons['endDate']) ?>" >
                                        <?php
                                            if(isset($errors['endDate'])) {
                                                echo "<span class='text-danger'>$errors[endDate] </span>";
                                            }
                                        ?>
                                </div>
        
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="list.php" class="return btn text-white color-bg">
                                        <i class="fa-solid fa-right-from-bracket deg-180"></i>
                                        Quay lại
                                    </a>

                                    <button type="submit" class="btn color-bg text-white">Cập nhật</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                </main>
            </div>
        </div>
        <?php include "../include/footer.php" ?>     
    </body>
</html>
