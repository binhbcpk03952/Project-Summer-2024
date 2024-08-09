<?php 
    // require 'connnect.php';
    include "../DBUntil.php";
    $dbHelper = new DBUntil;
    $district_id = $_GET['district_id'];

    $wards = $dbHelper->select("SELECT * FROM wards WHERE district_id = ?", [$district_id]);

    // echo $district_id;
    
    // $sql = "SELECT * FROM `wards` WHERE `district_id` = {$district_id}";
    // $result = mysqli_query($conn, $sql);


    $data[0] = [
        'id' => null,
        'name' => 'Chọn một xã/phường'
    ];

    foreach ($wards as $row) {
        $data[] = [
            'id' => $row['wards_id'],
            'name'=> $row['name']
        ];
    }
    echo json_encode($data);
?>
