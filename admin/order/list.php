<?php
include "../../client/DBUntil.php";
// session_start();
$dbHelper = new DBUntil();
$orders = $dbHelper->select("select * from orders");

?>
<!DOCTYPE html>
<html lang="en">

<?php include "../include/head.php" ?>
<link rel="stylesheet" href="./css/style.css">

<body>

    <?php include "../include/header.php" ?>
    <div class="container-fluid">
        <div class="row">
            <?php include "../include/aside.php" ?>
            <main class="col-md-10 mt-5">

                <table class="table">
                    <thead>
                        <tr>
                            <th>totalPrice</th>
                            <th>Khach Mua</th>
                            <th>Dia chi</th>
                            <th>Thoi gian</th>
                            <th>Note</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <?php
                    /**
                     * 1. dat hang thanh cong
                     * 2. dat hang va da thanh toan
                     * 3. shop da xac nhan
                     * 4. dang van chuyen
                     * 5. thanh cong
                     * 6. that bai
                     * 7. da huy don     
                     */
                    foreach ($orders as $order) {
                        echo "<tr>";
                        echo "<td>$order[totalPrice]đ</td>";
                        echo "<td>$order[idUser]</td>";
                        echo "<td>$order[address]</td>";
                        echo "<td>$order[orderDate]</td>";
                        echo "<td>$order[noteOrder]</td>";
                        if ($order['statusOrder'] == 1) {
                            echo "<td>Chờ xác nhận</td>";
                            echo "<td> <a class='btn btn-danger' href='master.php?view=update_order&id=$order[idOrder]'>Xác nhận</a>";
                            echo "<a class='btn btn-primary mx-3' href='master.php?view=refuse_order&id=$order[idOrder]'>Từ chối</a></td>";
                        } elseif ($order['statusOrder'] == 3) {
                            echo "<td>Chuẩn bị hàng</td>";
                            echo "<td> <a class='btn btn-primary' href='master.php?view=update_order&id=$order[idOrder]'>Chuẩn bị hàng</a>";
                        } elseif ($order['statusOrder'] == 7) {
                            echo "<td>Tu choi</td>";
                            echo "<td> <a class='btn btn-danger' href=''>Từ chối</a>";
                        }
                        echo "</tr>";
                    }
                    ?>
                    </tr>
                </table>
            </main>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/121f50087c.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
    <!-- <script src="js/script.js"></script> -->
    <script src="js/main.js"></script>
</body>

</html>