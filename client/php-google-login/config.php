<?php
require_once 'vendor/autoload.php';
// init configuration
$clientID = '458978552911-p25084ai5sim4q3aj3tqn70mjihl62ds.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/project-summer-2024/client/php-google-login/google-login-info.php';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// // Connect to database
//     $hostname = "localhost";
//     $username = "root";
//     $password = "";
//     $database = "project-sum2024";

//     $conn = mysqli_connect($hostname, $username, $password, $database);
//     // if (!$conn) {
//     //     die("Connection failed: " . mysqli_connect_error());
//     // }
//     // echo "Connected successfully";
    

?>