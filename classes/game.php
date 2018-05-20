<?php

class Game {

    private $connection;


    public function __construct($connection){
        $this->connection = $connection;
    }


    public function index(){

        include 'tpl/game.php';
        return;
    }

//    /**
//     * @return array
//     */
//    private function getAvailableGoods() :array
//    {
//         $query = $this->connection->query('
//                        SELECT name, (added_number)-(spent_number) as number
//                        FROM prizes_goods
//                        WHERE (added_number)-(spent_number) > 0');
//        return $query->fetchALL(PDO::FETCH_ASSOC);
//    }
//
//    /**
//     * @return array
//     */
//    private function getAvailableMoney() :array
//    {
//        $query  = $this->connection->query('
//                    SELECT (added_amount)-(holded_amount)-(spent_amount) as amount
//                    FROM prizes_money
//                    WHERE (added_amount)-(holded_amount)-(spent_amount) > 0');
//        return $query->fetch(PDO::FETCH_ASSOC);
//    }

}