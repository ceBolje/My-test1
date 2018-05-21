<?php

class Main
{

    public $connection;


    public function __construct($connection)
    {
        $this->connection = $connection;
    }


    public function index()
    {

        $goods = $this->getAvailableGoods();
        $money = $this->getAvailableMoney();

        return include 'tpl/main.php';
    }

    /**
     * @return mixed
     */
    public function getAvailableGoods()
    {
        $query = $this->connection->query('
                        SELECT id, name, (added_amount)-(holded_amount)-(spent_amount) as number
                        FROM prizes_goods
                        WHERE (added_amount)-(holded_amount)-(spent_amount) > 0');
        return $query->fetchALL(PDO::FETCH_ASSOC);
    }

    /**
     * @return mixed
     */
    public function getAvailableMoney()
    {
        $query = $this->connection->query('
                    SELECT id, (added_amount)-(holded_amount)-(spent_amount) as amount 
                    FROM prizes_money
                    WHERE (added_amount)-(holded_amount)-(spent_amount) > 0');
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @return bool
     */
    public function getAvailablePoints()
    {
        return true;
    }


    /**
     * @return mixed
     */
    public function getAllPrizeTransactions($userId)
    {
        $query = $this->connection->prepare("
                    SELECT pt.*, p.name, p.type, pg.name as goodsName 
                    FROM prizes_transactions as pt
                    LEFT OUTER JOIN prizes p ON pt.prizes_id = p.id
                    LEFT OUTER JOIN prizes_goods pg ON pt.goods = pg.id
                    WHERE user_id = :user_id");
        $query->execute(array(':user_id' => $userId));

        return $query->fetchALL(PDO::FETCH_ASSOC);
    }

    /**
     * @return mixed
     */
    public function getPrizeTransaction($id, $userId)
    {
        $query = $this->connection->prepare("
                    SELECT pt.*, p.name, p.type, pg.name as goodsName 
                    FROM prizes_transactions as pt
                    LEFT OUTER JOIN prizes p ON pt.prizes_id = p.id
                    LEFT OUTER JOIN prizes_goods pg ON pt.goods = pg.id
                    WHERE pt.id = :id 
                    AND pt.user_id = :user_id");
        $query->execute(array(':user_id' => $userId, ':id' => $id));

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function page404()
    {

        include 'tpl/404.php';
        return;
    }

    /**
     * DO NOT check user, token etc
     * @return mixed
     */
    public function getCurrentUser()
    {

        session_start();
        return $_SESSION['user_id'];
    }


    /**
     * Change calculate prizes amount and change transaction status
     * @param $id
     * @param $type
     * @param bool $is_refusal
     * @return bool
     */
    public function processPrize($id, $type, $is_refusal = false, $is_moneyToPoints = false)
    {
        try {

            if (empty($id)) {
                throw new Exception(null, 404);
            }

            $transaction = $this->getPrizeTransaction($id, $this->getCurrentUser());

            if (empty($transaction)) {
                throw new Exception(null, 404);
            }

            $this->connection->beginTransaction();

            if ($transaction['type'] == 'points' || $is_moneyToPoints) {

                $sql = $this->preparePrizeProcessType($is_refusal, true, 'users');
                $pdo = $this->connection->prepare($sql);

                // calculate amount from money
                $amount = $is_moneyToPoints ? $transaction['amount'] * MONEY_TO_POINTS_FACTOR :
                    $transaction['amount'];

                $pdo->bindParam(':amount', $amount);
                $pdo->bindParam(':user_id', $this->getCurrentUser());

            } else {

                $tableName = 'prizes_' . $transaction['type'];

                $sql = $this->preparePrizeProcessType($is_refusal, false, $tableName);
                $pdo = $this->connection->prepare($sql);

                $pdo->bindParam(':id', $transaction['prizes_item_id']);
                $pdo->bindParam(':amount', $transaction['amount']);
            }

            $pdo->execute();

            $pocessed = $is_refusal ? 'returned' : 'processed';

            $pdo = $this->connection->prepare("
                        UPDATE prizes_transactions
                        SET status = '" . $pocessed . "', processed_type = '" . $type . "'
                        WHERE id = :id");
            $pdo->bindParam(':id', $id);
            $pdo->execute();
            $this->connection->commit();

            echo json_encode(['code' => 200]);

            return true;

        } catch (Exception $e) {

            if ($pdo) {
                $this->connection->rollBack();
            }
            echo json_encode(['code' => $e->getCode()]);

        }
    }

    /**
     * Prepare SQL for different cases, override table in case "points"
     * @param $is_refusal
     * @param $tableName
     * @return string
     */
    private function preparePrizeProcessType($is_refusal, $is_points, $tableName)
    {
        $sql = "UPDATE " . $tableName . "
                SET holded_amount = holded_amount - :amount,
                spent_amount = spent_amount + :amount
                WHERE id = :id";

        if ($is_refusal) {
            $sql = "UPDATE " . $tableName . "
                    SET holded_amount = holded_amount - :amount
                    WHERE id = :id";
        }

        // points or calculated to points money
        if ($is_points) {
            $sql = "UPDATE " . $tableName . "
                    SET points = points + :amount
                    WHERE id = :user_id";
        }
        return $sql;
    }

    public function redirect($location)
    {
        header("Location: " . $location);
    }

}