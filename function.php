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

//        var_dump($row);

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
        $result = mysqli_query($this->conn, "SELECT * FROM tb_user WHERE id = $id");
        return mysqli_fetch_assoc($result);
    }
}
