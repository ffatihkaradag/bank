<?php

class User extends Database{
	
	public $username;
	public $password;
	
	public function login($username,$password){
		
		$userfindq = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
		$userfindq->bindValue(":username",$username,PDO::PARAM_STR);
		$userfindq->execute();
		$userfind = $userfindq->fetch(PDO::FETCH_ASSOC);
		$userfindq = null;
		
		if($userfind):
		
			if (password_verify($password, $userfind['password'])):
				return json_encode(array(
					"response" => array(
						"code" => 200,
						"message" => 'login successfuly',
						
					),
					"user" => array(
						"id" => $userfind['id'],
					)
				));
			else:
				return json_encode(array(
					"response" => array(
						"code" => 201,
						"message" => 'password wrong'
					)
				));
			endif;
			
			
		else:
			return json_encode(array(
				"response" => array(
					"code" => 201,
					"message" => 'username wrong.'
				)
			));
		endif;
	}
	
	
	public function register($username,$password){
		
		$userfindq = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
		$userfindq->bindValue(":username",$username,PDO::PARAM_STR);
		$userfindq->execute();
		$userfind = $userfindq->fetch(PDO::FETCH_ASSOC);
		
		if(!$userfindq->rowCount() > 0):
		
			$password =  password_hash($password, PASSWORD_ARGON2I);
			
			$newuserq = $this->pdo->prepare("INSERT INTO users (username, password) VALUES (?,?)");
			$newuser = $newuserq->execute([$username, $password]);
			
			return json_encode(array(
					"response" => array(
						"code" => 200,
						"message" => 'user registered successfuly',
					)
				));
		
		else:
				return json_encode(array(
					"response" => array(
						"code" => 201,
						"message" => 'username already used.',
					)
				));
		endif;
	}
	
	public function getUser($userid){
		
		$userfindq = $this->pdo->prepare("SELECT * FROM users WHERE id = :userid");
		$userfindq->bindValue(":userid",$userid,PDO::PARAM_INT);
		$userfindq->execute();
		$userfind = $userfindq->fetch(PDO::FETCH_ASSOC);
		
		return json_encode(array(
			"response" => array(
				"code" => 200,
			),
			"user" => array(
				"id" => $userfind['id'],
				"username" => $userfind['username'],
				"balance" => $userfind['balance'],
			)
		));
		
	}
	
	public function getUsers($userid){
		
		$usersq  = $this->pdo->prepare("SELECT * FROM users WHERE id != :userid");
		$usersq->bindValue(":userid",$userid,PDO::PARAM_INT);
		$usersq->execute();
		$users = $usersq->fetchAll(PDO::FETCH_ASSOC);
		
		return json_encode(array(
			"response" => array(
				"code" => 200,
			),
			"users" => $users,
		));
		
	}
	
	
}