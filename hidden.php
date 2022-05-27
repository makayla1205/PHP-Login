<?php
    session_start();
    if(!isset($_SESSION['loggedIN'])){
        header('Location: login.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hidden</title>
</head>
<body>
<p>You are logged in</p>
<a href="logout.php">Logout</a>
</body>
</html>