<?php
    session_start();
    $configs = include('config.php');

    if(isset($_SESSION['loggedIn'])){
        header('Location: hidden.php');
        exit();
    }

    if(isset($_POST['signin'])){
        $connection = new mysqli(hostname: $configs['hostname'], username: $configs['username'], password: $configs['password'], database: $configs['database']);
        $email = $connection->real_escape_string( $_POST['emailPHP']);
        $name = $connection->real_escape_string( $_POST['namePHP']);
        $password = md5($connection->real_escape_string( $_POST['passwordPHP']));

        $data = $connection->query("INSERT INTO Users (firstName, email, password)values ('$name', '$email', '$password')");

        if ($data){
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
    <title>Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<body class="bg-dark">
<div class="container-fluid bg-dark p-5">
    <div class="container-fluid m-5 p-5 w-75 bg-light ">
        <h3 class="display-5">Sign Up</h3>
        <hr>
        <form method="post" action="signup.php">
            <div class="mb-3">
                <label for="name" class="form=label">First Name</label>
                <input class="form-control" type="text" id="name" placeholder="First Name...">
                <div id="nameHelp" class="form-text"></div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input class="form-control" type="text" id="email" placeholder="Email...">
                <div id="emailHelp" class="form-text"></div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input class="form-control" type="password" id="password" placeholder="Password...">
                <div id="passwordHelp" class="form-text"></div>
            </div>
            <div class="mb-3">
                <label for="confirm" class="form-label">Confirm Password</label>
                <input class="form-control" type="password" id="confirm" placeholder="Confirm Password...">
                <div id="confirmHelp" class="form-text"></div>
            </div>
            <input class="btn btn-primary" type="button" value="Sign Up" id="signup"><br>
        </form>
        <br>
        <p>Already have an account? <a href="login.php">Log In</a></p>
    </div>
</div>
    <p id="response"></p>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $("#signup").on("click", function () {
                var email = $("#email").val();
                var name = $("#name").val();
                var password = $("#password").val();
                var confirm = $("#confirm").val();

                if (email == "" || password == "" || confirm=="" || name=="")
                    alert("Please check your input");
                else if (password != confirm) {
                    alert("Passwords do not match")
                } else {
                    $.ajax(
                        {
                            url: "signup.php",
                            method: "POST",
                            data: {
                                signin: 1,
                                emailPHP: email,
                                passwordPHP: password,
                                namePHP: name
                            },
                            success: function (response) {
                                $("#response").html(response);
                                if (response.indexOf('success') >= 0)
                                    window.location = "login.php";
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