<?php
    session_start();
    $configs = include('config.php');
    if(!isset($_SESSION['loggedIN'])){
        header('Location: login.php');
        exit();
    } else {
        $email = $_SESSION['email'];
        $connection = new mysqli(hostname: $configs['hostname'], username: $configs['username'], password: $configs['password'], database: $configs['database']);
        $data = $connection->query("SELECT firstName FROM Users WHERE email='$email'");
        if ($data->num_rows>0) {
            $row = $data->fetch_assoc();
            $_SESSION['name'] = $row['firstName'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hidden</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<body>
    <h2>Hello, <?php echo $_SESSION['name'] ?></h2>
    <p>You are logged in</p>
    <a href="logout.php" class="btn btn-primary">Logout</a>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>