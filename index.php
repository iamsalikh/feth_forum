<?php
require 'function.php';

$select = new Select();

if(isset($_SESSION['id'])){
    $user = $select->selectUserById($_SESSION['id']);
}
else{
    header('Location: login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['subject_name'], $_POST['write_subject'], $_POST['add_username'])) {

        $newSubject = new Subject($_POST['subject_name'], $_POST['write_subject'], $_SESSION['id']);
        $newSubject->createSubject();

        header('Location: index.php');
//        exit();
    }
}
$subjectInstance = new Subject('something', 'something', 'something');

$subjects = $subjectInstance->viewSubjects();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forum</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand ms-3" href="#">Feth Forum</a>
    <ul class="navbar-nav">
        <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
        <li class="nav-item"><a href="index.php" class="nav-link active">Home</a></li>
    </ul>
</nav>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="" method="post">
                <input type="text" name="subject_name" placeholder="Name of your subject" class="form-control" required>
                <input type="text" name="write_subject" placeholder="Write your subject" class="form-control" required>
                <input type="hidden" name="add_username" value="1">
                <button type="submit" class="btn btn-success">Add</button>
            </form>
        </div>
    </div>

    <div class="row justify-content-center">
        <?php foreach ($subjects as $subject): ?>
            <div class="col-md-8">
                <a href="subject.php?id=<?= htmlspecialchars($subject['id']) ?>" class="card-link">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($subject['subjectName']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($subject['title']) ?></p>
                            <p class="text-muted">Created by: <?= htmlspecialchars($select->getUsernameByUserId($subject['user_id'])) ?></p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
