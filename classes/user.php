<?php

class User {

    private $connection;


    public function __construct($connection){
        $this->connection = $connection;
    }


    public function create(){

        var_dump($_REQUEST);
//
//        $stmt = $dbh->prepare("INSERT INTO user (name, password) VALUES (:name, :password)");
//        $stmt->bindParam(':name', $name);
//        $stmt->bindParam(':password', $password);
//
//        $name = 'one';
//        $value = 1;
//        $stmt->execute();
    }

    public function signup(){
        include 'tpl/signup.php';
    }

    public function login(){
        include 'tpl/login.php';
    }

}