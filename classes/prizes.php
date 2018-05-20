<?php

class Prizes {

    private $connection;


    public function __construct($connection){
        $this->connection = $connection;
    }


    public function game()
    {
        include 'tpl/game.php';
        return;
    }

    public function getprize()
    {
        //sleep(2);

        $result = [
            'code'      => 200,
            'id'        => 1,
            'type'      => 'goods',
            'amount'    => 253,
            'goods'     => 'smartPhone',
        ];
        echo json_encode($result);
    }

    
    public function showPrizes(){

    }


}