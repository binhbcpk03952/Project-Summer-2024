<?php   
    // require 'connnect.php';
    header('Content-Type: application/json');
    include "../DBUntil.php";
    $dbHelper = new DBUntil;

    
    $province_id = $_GET['province_id'];
    $district = $dbHelper->select('SELECT * FROM district WHERE province_id = ?', [$province_id]);
    // var_dump($district);
    
    // $sql = "SELECT * FROM `district` WHERE `province_id` = {$province_id}";
    // $result = mysqli_query($conn, $sql);

    $data[0] = [
        'id' => null,
        'name' => 'Chọn một Quận/huyện'
    ];
    // while ($row = mysqli_fetch_assoc($result)) {
    //     $data[] = [
    //         'id' => $row['district_id'],
    //         'name'=> $row['name']
    //     ];
    // }
    foreach ($district as $row) {
        $data[] = [
            'id' => $row['district_id'],
            'name'=> $row['name']
        ];
    }
    echo json_encode($data);
?>