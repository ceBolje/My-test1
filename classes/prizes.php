<?php

class Prizes {

    private $connection;


    public function __construct($connection){
        $this->connection = $connection;
    }


    public function index(){

        $query  = $this->connection->query('
                    SELECT (added_amount)-(holded_amount)-(spent_amount) as amount 
                    FROM prizes_money
                    WHERE (added_amount)-(holded_amount)-(spent_amount) > 0');
        //return $query->fetch(PDO::FETCH_ASSOC);

        include 'tpl/prizes.php';
        return;
    }


}