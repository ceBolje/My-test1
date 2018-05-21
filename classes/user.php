<?php

require(dirname(__FILE__) . '/' . 'main.php');

class User extends Main
{

    /**
     *
     * DO NOT CHECK DATA AT ALL, NOT CSRF
     * IT IS EMULATION OF AUTH
     *
     */

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

            $this->auth($name, $password);
            $this->redirect("/prizes/game");

        } else {

            $this->redirect("/user/signup");
        }
    }

    public function auth($name, $password)
    {
        $name = $_POST['name'] ?? $name;
        $password = md5($_POST['password']) ?? md5($password);

        $pdo = $this->connection->prepare('SELECT id, name, points FROM users WHERE name=:name AND password=:password');
        $pdo->bindParam(':name', $name);
        $pdo->bindParam(':password', $password);
        $pdo->execute();

        if ($pdo->rowCount() == 1) {

            $data = $pdo->fetch(PDO::FETCH_ASSOC);

            $this->saveUserData($data['id'], $data['name']);
            $this->redirect("/prizes/game");

        } else {

            $this->redirect("/user/login");
        }
    }

    public function saveUserData($id, $name)
    {
        session_start();

        $_SESSION['user_id'] = $id;
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
        return include 'tpl/signup.php';
    }

    public function login()
    {
        return include 'tpl/login.php';
    }

}