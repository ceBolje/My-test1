<?php


require_once('config.php');

class DBClass
{

    public $connection;

    public function getConnection()
    {

        $this->connection = null;

        try {

            $this->connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS,
                [
                    PDO::ATTR_PERSISTENT => true
                ]);
            $this->connection->exec("set names utf8");
        } catch (PDOException $exception) {

            echo "Error: " . $exception->getMessage();
        }

        return $this->connection;
    }
}