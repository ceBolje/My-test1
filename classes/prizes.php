<?php

require(dirname(__FILE__) . '/' . 'main.php');


class Prizes extends Main
{

    public function game()
    {
        return include 'tpl/game.php';
    }

    /**
     * Get prize and save transactions
     *
     * @return bool
     */
    public function getprize()
    {
        try {

            //remote call emulation
            sleep(1);

            $availablePrizes = $this->getAvailablePrizes();

            $wonPrize = array_rand($availablePrizes, 1);

            $getPrizeType = 'getPrizeType' . ucfirst($availablePrizes[$wonPrize]['type']);

            $prize = $this->$getPrizeType($availablePrizes[$wonPrize]);

            $transaction = $this->transactionPrize($availablePrizes[$wonPrize], $prize);

            if (empty($prize) || empty($transaction)) {
                throw new Exception(null, 412);
            }

            $result = [
                'code' => 200,
                'id' => 1,
                'type' => $availablePrizes[$wonPrize]['type'],
                'amount' => $prize['amount'],
                'goods' => $prize['goods']['name'],
                'transaction' => $transaction
            ];

            echo json_encode($result);

            return true;

        } catch (Exception $e) {

            echo json_encode(['code' => $e->getCode()]);
        }
    }

    /**
     * Save prize transaction and increase count of prizes
     * @param $prizeData
     * @param $prize
     * @return mixed
     */
    public function transactionPrize($prizeData, $prize)
    {

        try {

            $user_id = $this->getCurrentUser();
            $amount = $prize['amount'] ?? null;
            $goods = $prize['goods']['id'] ?? null;
            $prizes_id = $prizeData['prize_id'];
            $prizeItem = $prize['prizeItem'];


            $tableName = 'prizes_' . $prizeData['type'];

            $this->connection->beginTransaction();

            if ($prizeData['type'] != 'points') {

                $pdo = $this->connection->prepare("
                        UPDATE " . $tableName . "
                        SET holded_amount = holded_amount + :amount
                        WHERE id = :id");

                $pdo->bindParam(':id', $prizeItem);
                $pdo->bindParam(':amount', $amount);
                $pdo->execute();
            }


            $pdo = $this->connection->prepare("
                       INSERT INTO prizes_transactions (user_id, prizes_id, prizes_item_id, amount, goods) 
                       VALUES (:user_id, :prizes_id, :prizes_item_id, :amount, :goods)");

            $pdo->bindParam(':user_id', $user_id);
            $pdo->bindParam(':prizes_id', $prizes_id);
            $pdo->bindParam(':prizes_item_id', $prizeItem);
            $pdo->bindParam(':amount', $amount);
            $pdo->bindParam(':goods', $goods);

            $pdo->execute();

            $transactionId = $this->connection->lastInsertId();
            $this->connection->commit();

            return $transactionId;

        } catch (Exception $e) {

            if ($pdo) {
                $this->connection->rollBack();
            }
            echo json_encode(['code' => $e->getCode()]);

        }
    }


    /**
     * @return mixed
     */
    private function getPrizesTypes()
    {
        $query = $this->connection->query('
                        SELECT id, name, type
                        FROM prizes');
        return $query->fetchALL(PDO::FETCH_ASSOC);
    }


    /**
     * @return array
     */
    private function getAvailablePrizes()
    {
        try {

            $availablePrizes = [];

            $prizesType = $this->getPrizesTypes();

            foreach ($prizesType as $prize) {

                $availablePrizes = $this->checkPrizeHandlers($prize, $prizesType, $availablePrizes);
            }
            return $availablePrizes;

        } catch (Exception $e) {

            echo json_encode(['code' => $e->getCode()]);
        }

    }

    /**
     * Check methods for handle specific prize type, prize can`t be selected without handlers
     * @param $prize
     * @param $prizesType
     * @param $availablePrizes
     * @return array
     */
    private function checkPrizeHandlers($prize, $prizesType, $availablePrizes)
    {
        $checkByPrizeType = 'getAvailable' . ucfirst($prize['type']);
        $getPrizeByType = 'getPrizeType' . ucfirst($prize['type']);

        if (method_exists($this, $checkByPrizeType) &&
            method_exists($this, $getPrizeByType)
        ) {

            $available = $this->$checkByPrizeType();

            if ($available) {

                $availablePrizes[] = [
                    'type' => $prize['type'],
                    'prize_id' => $prize['id'],
                    'prizes' => $available
                ];
            }
        }

        return $availablePrizes;
    }

    /**
     * @return array
     */
    private function getPrizeTypePoints()
    {
        return ['amount' => rand(POINTS_START, POINTS_END)];
    }

    /**
     * @param $prize
     * @return array
     */
    private function getPrizeTypeMoney($prize)
    {
        return [
            'amount' => rand(1, $prize['prizes']['amount']),
            'prizeItem' => $prize['prizes']['id']];
    }

    /**
     * @param $prize
     * @return array
     */
    private function getPrizeTypeGoods($goods)
    {
        $selectedGoods = array_rand($goods['prizes'], 1);
        return [
            'amount' => 1,
            'goods' => $goods['prizes'][$selectedGoods],
            'prizeItem' => $goods['prizes'][$selectedGoods]['id']
        ];
    }


    public function index()
    {
        $prizes = $this->getAllPrizeTransactions($this->getCurrentUser());
        return include 'tpl/prizes.php';
    }


    public function refusal($id, $params)
    {
        $this->processPrize($id, NULL, true);
        return $params == 'noredirect' ? true : $this->redirect('/prizes');
    }


    public function delivery($id, $params)
    {
        $this->processPrize($id, 'delivery');
        return $params == 'noredirect' ? true : $this->redirect('/prizes');
    }

    public function tobank($id, $params)
    {
        $this->processPrize($id, 'bank');
        return $params == 'noredirect' ? true : $this->redirect('/prizes');
    }

    public function toaccount($id, $params)
    {
        $this->processPrize($id, 'points');
        return $params == 'noredirect' ? true : $this->redirect('/prizes');
    }

    public function moneytopoints($id, $params)
    {
        $this->processPrize($id, 'points', false, true);
        return $params == 'noredirect' ? true : $this->redirect('/prizes');

    }

    /**
     * Emulation bank call
     * @return string
     */
    public function bank()
    {
        sleep(2);
        echo json_encode(['code' => 200]);
        return true;

    }


}