<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="demo4.php" method="POST">
        <input type="text" name="demo" id="demo">
        <?php
            if (isset($errors['demo'])) {
                echo "<span class='errors text-danger'>{$errors['province']}</span>";
            }
        ?>
        <button type="submit">click me</button>
    </form>
</body>
</html>