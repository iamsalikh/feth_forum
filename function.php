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
    public function registration($name, $username, $email, $password, $confirmpassword){
        $duplicate = mysqli_query($this->conn, "SELECT * FROM tb_user WHERE username = '$username' OR email = '$email'");
        if (mysqli_num_rows($duplicate) > 0) {
            return 10;
            // Username or email already taken
        } else {
            if ($password == $confirmpassword) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $query = "INSERT INTO tb_user VALUES('', '$name', '$username', '$email', '$hashedPassword')";
                mysqli_query($this->conn, $query);

                return 1; // Registration successful
            } else {
                return 100;
                // Password does not match
            }
        }
    }
}

class Login extends Connection{
    public $id;
    public function login($usernameemail, $password) {
        $result = mysqli_query($this->conn, "SELECT * FROM tb_user WHERE username = '$usernameemail' OR email = '$usernameemail'");
        $row = mysqli_fetch_assoc($result);

//        var_dump($row);  // Отладочный вывод для $row

        if (mysqli_num_rows($result) > 0) {
            $storedPasswordHash = $row['password'];

//            var_dump($storedPasswordHash);  // Отладочный вывод для $storedPasswordHash

            if (password_verify($password, $storedPasswordHash)) {
                $this->id = $row['id'];
                return 1;  // Вход успешен
            } else {
                return 10;  // Неверный пароль
            }
        } else {
            return 100;  // Пользователь не зарегистрирован
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


























