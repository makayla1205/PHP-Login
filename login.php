<?php
    session_start();
    $configs = include('config.php');

    //if already logged in
    if(isset($_SESSION["loggedIN"])){
        header('Location: hidden.php');
        exit();
    }
    if(isset($_POST['login'])){
        $connection = new mysqli(hostname: $configs['hostname'], username: $configs['username'], password: $configs['password'], database: $configs['database']);
        $email = $connection->real_escape_string( $_POST['emailPHP']);
        $password = md5($connection->real_escape_string($_POST['passwordPHP']));

        $data = $connection->query("SELECT id FROM Users WHERE email='$email' AND password= '$password'");
        if ($data->num_rows>0){
            $_SESSION['loggedIN'] = 1;
            $_SESSION['email'] = $email;
            exit("success");
        } else {
            exit("failed");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <form method="post" action="login.php">
        <input type="text" id="email" placeholder="Email..."><br>
        <input type="password" id="password" placeholder="Password..."><br>
        <input type="button" value="Log In" id="login"><br>
    </form>

    <p id="response"></p>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $("#login").on("click", function () {
                var email = $("#email").val();
                var password = $("#password").val();

                if (email == "" || password == "")
                    alert("Please check your input");
                else {
                    $.ajax(
                        {
                            url: "login.php",
                            method: "POST",
                            data: {
                                login: 1,
                                emailPHP: email,
                                passwordPHP: password
                            },
                            success: function (response) {
                                $("#response").html(response);
                                if (response.indexOf('success') >= 0)
                                    window.location = "hidden.php";
                            },
                            dataType: "text"
                        }

                    );
                }
            })
        })
    </script>
</body>
</html>