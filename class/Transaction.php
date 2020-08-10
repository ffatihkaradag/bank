<?php
class Transaction extends Database {

    public function transfer($from,$to,$balance) {
		
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("SELECT balance FROM users WHERE id=:from");
            $stmt->execute(array(":from" => $from));
            $availableAmount = (int) $stmt->fetchColumn();
            $stmt->closeCursor();

            if ($availableAmount < $balance) {
				
				return json_encode(array(
					"response" => array(
						"code" => 101,
						"message" => "Insufficient balance to transfer",
					),
				));
            }
            $stmt = $this->pdo->prepare("UPDATE users SET balance = balance - :balance WHERE id = :from");
            $stmt->execute(array(":from" => $from, ":balance" => $balance));
            $stmt->closeCursor();

            $stmt = $this->pdo->prepare("UPDATE users SET balance = balance + :balance WHERE id = :to");
            $stmt->execute(array(":to" => $to, ":balance" => $balance));

            $this->pdo->commit();
			
			$newtransactionq = $this->pdo->prepare("INSERT INTO transactions (toid, fromid,balance) VALUES (?,?,?)");
			$newtransaction = $newtransactionq->execute([$from, $to,$balance]);
			
			if($newtransaction):
				return json_encode(array(
					"response" => array(
						"code" => 100,
						"message" => "The balance has been transferred successfully",
					),
				));
			endif;
			
			
			
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            die($e->getMessage());
        }
    }
	
	public function all($fromid) {
		
		$transactionsq  = $this->pdo->prepare("SELECT * FROM transactions WHERE fromid = :fromid ORDER BY id DESC");
		$transactionsq->bindValue(":fromid",$fromid,PDO::PARAM_INT);
		$transactionsq->execute();
		$transactions = $transactionsq->fetchAll(PDO::FETCH_ASSOC);
		
		
		return json_encode(array(
			"response" => array(
				"code" => 200,
			),
			"transactions" => $transactions,
		));
		
    }
	
	
}