<?php
	session_start();
class Database{
	
    const DB_HOST = 'localhost';
    const DB_NAME = 'bank';
    const DB_USER = 'root';
    const DB_PASSWORD = '';
	
    protected $pdo = null;
	

    public function __construct()
    {
        $dsn = 'mysql:host='.self::DB_HOST.';dbname='.self::DB_NAME.';charset=utf8';
		$options = [
		  PDO::ATTR_EMULATE_PREPARES   => false,
		  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		];
		try {
		  $this->pdo = new PDO($dsn,self::DB_USER,self::DB_PASSWORD,$options);
		} catch (Exception $e) {
		  error_log($e->getMessage());
		  exit('Something weird happened');
		}
    }
	
	
	public function settings(){
		
		$stmt = $this->pdo->prepare("SELECT * FROM settings WHERE id = ?");
		$stmt->execute([1]);
		$settings = $stmt->fetch(PDO::FETCH_ASSOC);
		$stmt = null;

		return array(
			"title" => $settings['title'],
			"baseURL" => $settings['baseURL'],
		);
		
	}


    public function __destruct() {
        $this->pdo = null;
    }

}