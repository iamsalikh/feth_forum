<?php
require 'function.php';

if(isset($_SESSION['id'])){
    header('Location: index.php');
}

$register = new Register();

if(isset($_POST['submit'])){
    $result = $register->registration($_POST['name'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirmpassword']);

    if($result == 1){
        $_SESSION['registration'] = true;
        $_SESSION['id'] = $register -> idUser();
        header('Location: index.php');;
        exit();
    }
    elseif($result == 10){
        echo
        "<script> alert('Username or Email Has Already Taken'); </script>";
    }
    elseif($result == 100){
        echo
        "<script> alert('Password Does Not Match')</script>";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/registration.css">
</head>
<body>
<form class="" action="" method="post" autocomplete="off">
    <h2>Registration</h2>
    <label for="">Name : </label>
    <input type="text" name="name" required value=""> <br>
    <label for="">Username : </label>
    <input type="text" name="username" required value=""> <br>
    <label for="">Email : </label>
    <input type="text" name="email" required value=""> <br>
    <label for="">Password : </label>
    <input type="password" name="password" required value=""> <br>
    <label for="">Confirm password : </label>
    <input type="password" name="confirmpassword" required value=""> <br>
    <button type="submit" name="submit">Register</button>
    <a href="login.php">Login</a>
</form>
</body>
</html>