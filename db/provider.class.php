<?php

class HackJob_Db_Provider
{
	protected static $instance;

	protected $pdo;
	
	protected function __construct()
	{
		$dsn = HackJob_Conf_Provider::get('DB_DSN');
		$user  = HackJob_Conf_Provider::get('DB_USER');
		$pw = HackJob_Conf_Provider::get('DB_PW');
		
		$this->pdo = new PDO($dsn, $user, $pw);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->pdo->exec('SET CHARACTER SET utf8');
	}
	
	public function getPDO()
	{
		return $this->pdo;
	}
	
	public function prepare($sql)
	{
		return $this->pdo->prepare($sql);
	}
	
	public static function getInstance()
	{
		if(is_null(self::$instance))
		{
			self::$instance = new self();
		}
		
		return self::$instance;
	}
}

?>