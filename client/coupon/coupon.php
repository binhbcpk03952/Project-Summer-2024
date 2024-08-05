<?php   
include "../DBUntil.php";
$dbHelper = new DBUntil();
$errors = [];
$code = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['code']) || empty($_POST['code'])) {
        $errors['code'] = "Mã giảm giá là bắt buộc";
    } else {
        $code = $_POST['code'];
    }
    $coupon = $dbHelper->select("SELECT * FROM coupons WHERE code = ?", [$code]);
    if (count($coupon) > 0) {
        $coupon = $coupon[0];
    } else {
        $coupon = null;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="coupon.php" method="post">
        <input type="text" name="code" placeholder="Nhập mã giảm giá">
        <input type="submit">
        <span name="database">
         giảm 
            <?=
                $coupon ? $coupon['discount'] : "0"
            ?>
            %
        </span>
    </form>
</body>
</html>