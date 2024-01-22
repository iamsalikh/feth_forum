<?php
require 'function.php';

$select = new Select();

if(isset($_SESSION['id'])){
    $user = $select->selectUserById($_SESSION['id']); // если пользователь уже ввошел
}
else{
    header('Location: login.php'); // если пользователь не ввошел
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Index</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>

<nav>
    <h1>Feth Forum</h1>
    <ul>
        <li><a href="logout.php">Logout</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="index.php" class="active">Home</a></li>
    </ul>
</nav>
</body>
</html>
