<?php 

class Database
{
	
	public $conn;
	private $host='localhost';
	private $dbname='api';
	private $username='root';
	private $password='';

	public function connect()
	{

		$this->conn=null ;

		try{

			$this->conn=new PDO('mysql:host='.$this->host.';dbname='.$this->dbname,$this->username,$this->password);
			$this->conn->exec("set names utf8");
		}

		catch(PDOException $e)
		{

			echo "Connection Error".$e->getMessage();
		}

		return $this->conn;
	}	
}

