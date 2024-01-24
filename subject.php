<?php
require 'function.php';

if (isset($_GET['id'])) {
    $subjectId = $_GET['id'];

    $subjectInstance = new Subject('something', 'something', 'something');
    $subject = $subjectInstance->viewSubjectById($subjectId);

    $comments = $subjectInstance->viewCommentsBySubjectId($subjectId);
} else {
    echo
    "<script> alert('No subject ID provided.'); window.location.href = 'index.php'; </script>";
    exit;
}

$select = new Select();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_comment'])) {
    if (isset($_SESSION['id']) && isset($subjectId)) {
        $userId = $_SESSION['id'];
        $content = $_POST['new_comment'];
        $subjectInstance->addComment($subjectId, $userId, $content);

        header('Location: subject.php?id=' . $subjectId);
        exit();
    } else {
        echo "<script> alert('Error: User not logged in or invalid subject ID.'); </script>";
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
    <title>Subject</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/subject.css">
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
        <?php if($subject): ?>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($subject['subjectName']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($subject['title']) ?></p>
                        <p class="text-muted">Created by: <?= htmlspecialchars($select->getUsernameByUserId($subject['user_id'])) ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="" method="post">
                <input type="text" name="new_comment" placeholder="Add your comment" class="form-control" required>
                <button type="submit" class="btn btn-success">Add</button>
            </form>
        </div>
    </div>
</div>

<div class="container my-4">
    <div class="row justify-content-center">
        <?php foreach ($comments as $comment): ?>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($select->getUsernameByUserId($comment['user_id'])) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($comment['content']) ?></p>
                        <p class="text-muted">Posted on: <?= date("Y-m-d H:i:s", strtotime($comment['timestamp'])) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>