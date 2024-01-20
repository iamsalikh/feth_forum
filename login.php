<?php
require 'function.php';

if(isset($_SESSION['id'])){
    header('Location: index.php');
}

$login = new Login();

if(isset($_POST['submit'])){
    var_dump($_POST['password']);
    $result = $login->login($_POST['usernameemail'], $_POST['password']);
    var_dump($result);

    if($result == 1){
        $_SESSION['login'] = true;
        $_SESSION['id'] = $login->idUser();
        header('Location: index.php');
        exit();
    }
    elseif($result == 10){
        echo
        "<script> alert('Wrong Password'); </script>";
    }
    elseif($result == 100){
        echo
        "<script> alert('User Not Registered'); </script>";
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
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<form class="" action="" method="post" autocomplete="off">
    <h2>Log in</h2>
    <label for="">Username or email : </label>
    <input type="text" name="usernameemail" required value=""> <br>
    <label for="">Password : </label>
    <input type="password" name="password" required value=""> <br> <br>
    <button type="submit" name="submit">Login</button>
    <a href="registration.php">Registration</a>
</form>
</body>
</html>