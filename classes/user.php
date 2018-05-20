<?php

class User
{

    /**
     *
     * DO NOT CHECK DATA AT ALL, NOT CSRF
     * IT IS EMULATION OF AUTH
     *
     */

    private $connection;


    public function __construct($connection)
    {
        $this->connection = $connection;
    }


    public function create()
    {
        $name = $_POST['name'];
        $password = md5($_POST['password']);

        $pdo = $this->connection->prepare('SELECT id FROM users WHERE name=:name');
        $pdo->bindParam(':name', $name);
        $pdo->execute();

        if ($pdo->rowCount() == 0) {
            $pdo = $this->connection->prepare('INSERT INTO users (name,password) value (:name, :password)');
            $pdo->bindParam(':name', $name);
            $pdo->bindParam(':password', $password);
            $pdo->execute();

            $this->saveUserData($name);
            $this->redirect("/game");

        } else {

            $this->redirect("/user/signup");
        }
    }

    public function auth()
    {
        $name = $_POST['name'];
        $password = md5($_POST['password']);

        $pdo = $this->connection->prepare('SELECT id, name FROM users WHERE name=:name AND password=:password');
        $pdo->bindParam(':name', $name);
        $pdo->bindParam(':password', $password);
        $pdo->execute();

        if ($pdo->rowCount() == 1) {
            
            $data = $pdo->fetch(PDO::FETCH_ASSOC);

            $this->saveUserData($data['name']);
            $this->redirect("/game");

        } else {

            $this->redirect("/user/login");
        }
    }

    public function saveUserData($name)
    {
        session_start();

        $_SESSION['user_name'] = $name;

    }

    public function logout()
    {
        session_start();
        session_destroy();

        $this->redirect("/");
    }


    public function signup()
    {
        include 'tpl/signup.php';
    }

    public function login()
    {
        include 'tpl/login.php';
    }

    public function redirect($location)
    {
        header("Location: " .$location);
    }

}