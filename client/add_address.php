<?php
session_start();
include "./DBUntil.php";
$dbHelper = new DBUntil();
if (isset($_SESSION['id'])) {
    $idUser = $_SESSION['id'];
}

echo $idUser;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['province']) || empty($_POST['province'])) {
        $errors['province'] = "Đây là trường bắt buộc";
    } else {
        $province = $_POST['province'];
    }
    
    if (!isset($_POST['district']) || empty($_POST['district'])) {
        $errors['district'] = "Đây là trường bắt buộc";
    } else {
        $district = $_POST['district'];
    }
    
    if (!isset($_POST['wards']) || empty($_POST['wards'])) {
        $errors['wards'] = "Đây là trường bắt buộc";
    } else {
        $wards = $_POST['wards'];
    }
    
    if (!isset($_POST['street']) || empty($_POST['street'])) {
        $errors['street'] = "Đây là trường bắt buộc";
    } else {
        $street = $_POST['street'];
    }
    
    if (count($errors) === 0) {
        $isProvince = $dbHelper->select("SELECT name FROM province WHERE province_id = ?",[$province])[0]['name'];
        $isDistrict = $dbHelper->select("SELECT name FROM district WHERE district_id = ?",[$district])[0]['name'];
        $isWard = $dbHelper->select("SELECT name FROM wards WHERE wards_id = ?",[$wards])[0]['name'];
        
        echo $street .", ". $isWard .", ". $isDistrict .", ". $isProvince;

        $data = [
            "nameStreet" => $street,
            "nameAddress" => "$isWard .', '. $isDistrict .', '. $isProvince",
            "idUser" => $_SESSION['id'],
        ];

        $addAddress = $dbHelper->insert("address", $data);

        if ($addAddress) {
            header("Location: checkout.php");
        }

    }
}
$province = $dbHelper->select("select * from province");

?>

<!DOCTYPE html>
<html lang="en">
<?php include "./includes/head.php" ?>

<body>
    <?php include "./includes/header.php" ?>
    <!-- main -->
    <main>
        <div class="container">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <h1 class="">Thêm địa chỉ</h1>
                    <form id="myForm" class="mt-2" method="POST">
                        <div class="form-group">
                            <label for="province">Tỉnh/Thành phố</label>
                            <select id="province" name="province" class="d-block w-100 input-value rounded-0">
                                <option value="">Chọn một tỉnh</option>
                                <!-- populate options with data from your database or API -->
                                <?php foreach ($province as $province) { ?>
                                    <option value="<?php echo $province['province_id'] ?>"><?php echo $province['name'] ?></option>
                                <?php } ?>
                            </select>
                            <?php
                                if (isset($errors['province'])) {
                                    echo "<span class='errors text-danger'>{$errors['province']}</span>";
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="district">Quận/Huyện</label>
                            <select id="district" name="district" class="d-block w-100 input-value rounded-0">
                                <option value="">Chọn một quận/huyện</option>
                            </select>
                            <?php
                                if (isset($errors['district'])) {
                                    echo "<span class='errors text-danger'>{$errors['district']}</span>";
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="wards">Phường/Xã</label>
                            <select id="wards" name="wards" class="d-block w-100 input-value rounded-0">
                                <option value="">Chọn một xã</option>
                            </select>
                            <?php
                                if (isset($errors['wards'])) {
                                    echo "<span class='errors text-danger'>{$errors['wards']}</span>";
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="wards">Tên đường/thôn</label>
                            <input type="text" name="street" id="street" class="d-block w-100 input-value rounded-0" placeholder="VD: Đường Hà Huy Tập,..">
                            <?php
                                if (isset($errors['street'])) {
                                    echo "<span class='errors text-danger'>{$errors['street']}</span>";
                                }
                            ?>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 form-input py-2 rounded-0 mt-4">Thêm địa chỉ</button>
                </div>
                </form>
            </div>
            <div class="col-lg-3"></div>
        </div>
        </div>
    </main>

    <?php include "./includes/footer.php" ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <!-- <script src="js/main.js"></script> -->