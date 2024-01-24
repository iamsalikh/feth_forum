<?php

session_start();

class Connection
{
    public $host = 'localhost';
    public $user = 'root';
    public $password = '';
    public $dbname = 'oop_reglog';
    public $conn;

    public function __construct()
    {
        $this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->dbname);

        if (!$this->conn) {
            die("Connection error: " . mysqli_connect_error());
        }
    }
}

class Register extends Connection{
    public $id;
    public function registration($name, $username, $email, $password, $confirmpassword){
        $duplicate = mysqli_query($this->conn, "SELECT * FROM tb_user WHERE username = '$username' OR email = '$email'");
        if (mysqli_num_rows($duplicate) > 0) {
            return 10;
        } else {
            if ($password == $confirmpassword) {
                $pepper = "salikh";
                $pwd_peppered = hash_hmac("sha256", $password, $pepper);
                $pwd_hashed = password_hash($pwd_peppered, PASSWORD_DEFAULT);

                $query = "INSERT INTO tb_user VALUES('', '$name', '$username', '$email', '$pwd_hashed')";
                mysqli_query($this->conn, $query);

                $this->id = mysqli_insert_id($this->conn);
                return 1;
            } else {
                return 100;
            }
        }
    }

    public function idUser(){
        return $this->id;
    }
}

class Login extends Connection{
    public $id;
    public function log1n($usernameemail, $password) {
        $result = mysqli_query($this->conn, "SELECT * FROM tb_user WHERE username = '$usernameemail' OR email = '$usernameemail'");
        $row = mysqli_fetch_assoc($result);

        if (mysqli_num_rows($result) > 0) {
            $storedPasswordHash = $row['password'];

            $pepper = "salikh";
            $pwd_peppered = hash_hmac("sha256", $password, $pepper);

            if (password_verify($pwd_peppered, $storedPasswordHash)) {
                $this->id=$row['id'];
                return 1;
            }
            else {
                return 10;
            }

        } else {
            return 100;
        }
    }

    public function idUser(){
        return $this->id;
    }
}

class Select extends Connection{
    public function selectUserById($id){
        $id = mysqli_real_escape_string($this->conn, $id);
        $result = mysqli_query($this->conn, "SELECT * FROM tb_user WHERE id = '$id'");
        return mysqli_fetch_assoc($result);
    }

    public function getUsernameByUserId($userId) {
        $userId = mysqli_real_escape_string($this->conn, $userId);
        $result = mysqli_query($this->conn, "SELECT username FROM tb_user WHERE id = '$userId'");

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['username'];
        } else {
            return false;
        }
    }
}

class Subject extends Connection{
    public $id;
    public $subjectName;
    public $title;
    public $user_id;

    public function __construct($subjectName, $title, $user_id){
        parent::__construct();
        $this->subjectName = mysqli_real_escape_string($this->conn, $subjectName);
        $this->title = mysqli_real_escape_string($this->conn, $title);
        $this->user_id = mysqli_real_escape_string($this->conn, $user_id);
    }

    public function createSubject(){
        $query = "INSERT INTO tb_subject (subjectName, title, user_id) VALUES ('$this->subjectName', '$this->title', '$this->user_id')";
        mysqli_query($this->conn, $query);
        $this->id = mysqli_insert_id($this->conn);
    }

    public function viewSubjects(){
        $result = mysqli_query($this->conn, "SELECT * FROM tb_subject ORDER BY id DESC");
        $subjects = [];
        while($row = mysqli_fetch_assoc($result)){
            $subjects[] = $row;
        }
        return $subjects;
    }

    public function viewSubjectById($id){
        $result = mysqli_query($this->conn, "SELECT * FROM tb_subject WHERE id = $id");
        return mysqli_fetch_assoc($result);
    }

    public function addComment($subjectId, $userId, $content){
        $query = "INSERT INTO tb_comment (subject_id, user_id, content, timestamp) VALUES ('$subjectId', '$userId', '$content', NOW())";
        mysqli_query($this->conn, $query);
    }

    public function viewCommentsBySubjectId($subjectId){
        $subjectId = mysqli_real_escape_string($this->conn, $subjectId);
        $query = "SELECT * FROM tb_comment WHERE subject_id = '$subjectId' ORDER BY id DESC";
        $result = mysqli_query($this->conn, $query);
        $comments = [];
        while ($row = mysqli_fetch_assoc($result)){
            $comments[] = $row;
        }
        return $comments;
    }

}