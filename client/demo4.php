<?php
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['demo']) || empty($_POST['demo'])) {
        $errors['demo'] = "Đây là trường bắt buộc";
    } else {
        $demo = $_POST['demo'];
    }
}
?>