<?php

//require_once(__DIR__ . '/ConnectionFactory.class.php');

class Connection{
	private $connection;

	public function Connection(){
		$this->connection = ConnectionFactory::getConnection();
	}

	public function getClose(){
		ConnectionFactory::getClose($this->connection);
	}

	public function executeQuery($sql){
		return pg_query ($this->connection, $sql);
	}

	public function executeExport($path, $id){
		return  pg_lo_export($id, $path, $this->connection);

	}
}
?>